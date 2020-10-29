<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../css/style.css">
<style>
body{
    background-image: url(../images/horror-movies-collage.jpg);
    background-position: cover;
    background-repeat: no-repeat;
}
h1{
    color: whitesmoke;
    text-align: center;
}
h2{
    color: whitesmoke;
    text-align: center;
}
.hback{
    background-color: rgba(0, 0, 0, 0.7) ;
    width: auto;
    margin: auto;
}
form{
    text-align: center;
    color:antiquewhite;
    padding: 50px;
}
</style>
<script>
var loadFile = function(event) {
	var image = document.getElementById('output');
	image.src = URL.createObjectURL(event.target.files[0]);
};
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registration</title>
</head>
<body>
    <div class="hback">
        <h1>Welcome To HyperTube</h1>
    </div>
    <div class="hback">

    <form method="POST" action="../src/register.php" enctype="multipart/form-data" >
        <h2>Registration</h2>
        <div style="padding:10px;margin:auto;color:red;background-color:aliceblue;border: solid 1px #555;box-shadow: 10px -3px 5px  rgba(0,0,0,0.6);border-radius:15px;width:auto">
        <?=isset($_GET['error']) ? $_GET['error'] : ""?>
        </div>
        <br>
        <img id="output" width="100vh" />
        <br>
        <label>Profile Picture</label>
        <input type="file" name="file" id="file" onchange="loadFile(event)">
        <br>
        <label>Username</label>
        <br>
        <input type="text" name="username" placeholder="Username">
        <br>
        <label>Firstname</label>
        <br>
        <input type="text" name="firstname" placeholder="Firstname">
        <br>

        <label>Lastname</label>
        <br>
        <input type="text" name="lastname">
        <br>
        <label>Email</label>
        <br>
        <input type="email" name="email">
        <br>
        <label>Password</label>
        <br>
        <input type="password" name="password">
        <br>
        <label>Confirm Password</label>
        <br>
        <input type="text" name="cpassword">
        <br>
        <input type="submit" name="submit">
    </form>
    </div>
</body>
</html>