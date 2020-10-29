<?php
session_start();
set_include_path("../");
include("../config/connection.php");

if(isset($_POST['submit'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    try{
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE `Username` = ? ");
		$stmt->execute(array($username));
		$data = $stmt->fetch();
		var_dump($data);
        if (empty($username) || empty($password))
        {
            $errorstuff = 'FILL IN ALL THE FIELDS';
            header("location: ../pages/login.php?error=$errorstuff");
            return;
        }
        else if (!preg_match("/([A-Za-z0-9])/", $username)){
            $errorstuff = 'USERNAME MUST BE ALPHABETS AND NUMBERS';
            header("location: ../pages/login.php?error=$errorstuff");
            return;
        }
        else if($username != $data['Username']){
            $errorstuff = 'USERNAME DOES NOT EXIST';
            header("location: ../pages/login.php?error=$errorstuff");
            return;
        }
        else if($data['Verify'] != 1){
            $errorstuff = 'ACCOUNT IS NOT VERIFIED CHECK EMAIL OR REGISTER-';
            header("location: ../pages/login.php?error=$errorstuff");
            return;
        }
        else
        {
            if($data)
            {
                if(password_verify($password, $data['Password']) && $username == $data['Username'] && $data['Verify'] == 1){
                    $_SESSION["uid"] = $data['id'];
                    $_SESSION["username"] = $data['Username'];
                    $_SESSION["firstname"] = $data['Firstname'];
                    $_SESSION["lastnameame"] = $data['Lastname'];
					$_SESSION["email"] = $data['Email'];
                    $_SESSION["profile"] = $data['Profle'];
                }
                header("location:../pages/index.php");
            }

        }
    }catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }
}
?>