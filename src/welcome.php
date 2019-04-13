<?php
session_start();
require_once "config.php";
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
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
                    Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b><br>
                    Welcome to our site !
                </div>
                <input type="button" value="Inbox" onclick="window.location.href='inbox.php'" />
                <input type="button" value="Send Message" onclick="window.location.href='send.php'" />
                <b><a href="logout.php" style="text-decoration:none; color: red;">Logout</a></b>
            </form>
        </div>
    </div>
</body>
</html>