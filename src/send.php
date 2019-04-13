<?php
session_start();
require_once "config.php";
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
function encrypt_decrypt($string,$arg_key,$action = 'e'){
    $secret_key = $arg_key;
    $secret_iv = 'Secure_Message';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
    return $output;
}
$username = $message = $success = "";
$username_err = $message_err = "";
$cur_usr=$_SESSION["username"];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    if(empty($username_err)){
        $param_usr_to = $username;
        $msg=trim($_POST["message"]);
        $param_msg_content = encrypt_decrypt($msg,$username,'e');
        $sql = "INSERT INTO msgs(usr_from,usr_to,msg_content) VALUES ('$cur_usr','$param_usr_to','$param_msg_content') ";
        if($stmt = mysqli_prepare($link, $sql)){
            if(mysqli_query($link, $sql)){
                $success="Message sent succecful";
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>   
<head>
    <title>Send Message</title>
    <style>
        <?php include 'style.css'; ?>
    </style>
    <style>
        textarea {
            resize: none;
        }
        .container .form #bttn{
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
            <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" name="username" placeholder="Send To" value="<?php echo $username; ?>"/>
                <span class="error-msg"><?php echo $username_err; ?></span>
                <br>
                <textarea name="message" value="<?php echo $message; ?>" placeholder="Content" rows="10" cols="34"></textarea>
                <span class="error-msg"><?php echo $message_err; ?></span>
                <?php echo $success?>
                <br><br>
                <button type="submit">send</button>
                <b><a href="welcome.php" style="text-decoration:none; color: red;">Back Home</a></b>
            </form>
        </div>
    </body>
</html>