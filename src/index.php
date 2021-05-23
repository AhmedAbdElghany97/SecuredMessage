<?php
session_start();
require_once "config.php";

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("location: welcome.php");
    exit;
}

?>



<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <style>
        <?php include 'style.css'; ?>
    </style>

    <style>
        .container .form .welcome-part{
            font-family: "Roboto",cursive;
            outline: 1;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 20px;
            padding: 25px;
            box-sizing: border-box;
            font-size: 20px;
        }
        .container .form input{
            font-family: "Roboto",sans-serif;
            text-transform: uppercase;
            outline: 0;
            background: #4CAF50;
            width: 100%;
            border: 0;
            margin: 0 0 16px;
            padding: 15px;
            color: #FFFFFF;
            font-size: 15px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form">
            <form class="register-form">
                <div class="welcome-part">
                    Hi, <b>Guest</b><br>
                </div>
                Are you member?
                <input type="button" value="Login" onclick="window.location.href='login.php'" /><br>
                Do you want to register?
                <input type="button" value="Register" onclick="window.location.href='register.php'" />
                
            </form>
        </div>
    </div>
    
    
    <script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
    
</body>
</html>
