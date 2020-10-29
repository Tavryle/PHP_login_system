<?php
session_start();
set_include_path("../");
require_once("../config/connection.php");

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST['submit'])){

    $name = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `Email` = :email");
    $stmt->execute();
    $userex = $stmt->fetch();
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    try{
//          --- Adding a Profile Picture ---

        $targetDir = "../profiles/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        $allowTypes = array('jpg','png','jpeg','gif');

        if(empty($_FILES["file"]["name"])){
            $errorstuff = 'YOU HAVE TO CHOOSE A PROFILE PICTURE';
			header("location: ../pages/register.php?error=$errorstuff");
			return;
        }
 		else if (empty($name) || empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($cpassword))
		{
            $errorstuff = 'FILL IN ALL THE FIELDS';
			header("location: ../pages/register.php?error=$errorstuff");
			return;
        }
        else if (!preg_match("/([A-Za-z0-9])/", $name)){
            $errorstuff = 'USERNAME MUST BE ALPHABETS AND NUMBERS';
			header("location: ../pages/register.php?error=$errorstuff");
			return;
        }
        else if (!preg_match("/([A-Za-z0-9])/", $firstname)){
            $errorstuff = 'FIRSTNAME MUST BE ALPHABETS AND NUMBERS';
			header("location: ../pages/register.php?error=$errorstuff");
			return;
        }
        else if (!preg_match("/([A-Za-z0-9])/", $lastname)){
            $errorstuff = 'LASTNAME MUST BE ALPHABETS AND NUMBERS';
			header("location: ../pages/register.php?error=$errorstuff");
			return;
        }
        // else if ($userex == $email)
        // {
        //     $errorstuff = 'EMAIL ALREADY EXISTS , TRY ANOTHER EMAIL';
		// 	header("location: ../pages/register.php?error=$errorstuff");
		// 	return;
        // }
        else if ($password != $cpassword){
            $errorstuff = 'PASSWORDS DOES NOT MATCH';
			header("location: ../pages/register.php?error=$errorstuff");
			return;
        }
        else{
            $token = 'qwertyuiop123456789lkjhgf!$#/()dsazxcvbnmQ';
            $token = str_shuffle($token);
            $token = substr($token, 0, 10);

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            if(!empty($_FILES["file"]["name"])){
                if(in_array($fileType, $allowTypes))
                {
                    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath))
                    {
                        $insert = "INSERT INTO `users` (`profile`, `Username`,`Firstname`, `Lastname`, `Email`,`Password`, `Token`) VALUES(:profile, :name, :firstname, :lastname, :email, :passwordc, :token) ";
                        $insert = $conn->prepare($insert);
                        $insert->bindParam(":profile", $targetFilePath, PDO::PARAM_STR);
                        $insert->bindParam(":name", $name, PDO::PARAM_STR);
                        $insert->bindParam(":firstname", $firstname, PDO::PARAM_STR);
                        $insert->bindParam(":lastname", $lastname, PDO::PARAM_STR);
                        $insert->bindParam(":email", $email, PDO::PARAM_STR);
                        $insert->bindParam(":passwordc", $hashed_password, PDO::PARAM_STR);
                        $insert->bindParam(":token", $token ,PDO::PARAM_STR);
                        $insert->execute();

                        $to_email = $email;
                        $subject = "verify your account";
                        $body = 'click here <a href="../pages/verify.php">Verify Your Account</a>';
                        $headers = "hypertube@gmail.com";
                         
                        if (mail($to_email, $subject, $body, $headers)) {
                            echo "Email successfully sent to $to_email...";
                        } else {
                            echo "Email sending failed...";
                        }
                    }
                    header("location: ../pages/login.php");

                }
            }
        }

    }catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }
}
?>