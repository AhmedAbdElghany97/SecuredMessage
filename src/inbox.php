<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>   
<head>
    <title>Inbox</title>
    <style>
        body{
            background-image: linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),url(background.jpg);
            height: 100vh;
            background-size: cover;
            background-position: center;  
        }
        .center{
            position: relative;
            z-index: 1;
            background: #ffffff;
            max-width: 380px;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
        }
        .inbox{
            position: relative;
            z-index: 1;
            background: #f2f2f2;
            max-width: 330px;
            margin: 0 auto 100px;
            padding: 5px;
            text-align: left;
        }
        table, td, th {  
            border: 2px solid #ddd;
            text-align: left;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 15px;
        }
    </style>
</head>  
<body>
    <div class="container">
        <div class="center">
            <h1>Welcome to your inbox !</h1>
            <b><a href="welcome.php" style="text-decoration:none; color: red;">Return Home</a></b><br><br>
            <div class="inbox">
                <div style="overflow-y:auto;">
                <table>
                    <caption>INBOX</caption>
                    <?php
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
                    $cur_usr=$_SESSION["username"];  
                    $sql="SELECT * FROM msgs WHERE usr_to='$cur_usr' ORDER BY created_at DESC";
                    $result = $link->query($sql);
                    while($row = $result->fetch_assoc()){
                        $row["msg_content"]=encrypt_decrypt($row["msg_content"],$cur_usr,'d');
                        echo "<tr><td>From: <b>".$row["usr_from"]."</b><hr><p style='color:#4CAF50'>".$row["msg_content"]."</p><br>
                        <div style='text-align:right; font-size:11px;'>".$row["created_at"]."</div>
                    </td></tr>";
                    }
                    ?>
                </table>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>