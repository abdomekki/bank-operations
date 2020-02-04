<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/handreg.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    
    <?php
        session_start();
        include "connection.php";
        $email=$_POST["email"];
        $pass=$_POST["password"];
        $emp=new validuser();
        $result=$emp->valid($email,$pass);
        if($result== true)
        {
            $_SESSION["email"]=$email;
            header("location:home.php");
        }


    ?>


</body>
</html>