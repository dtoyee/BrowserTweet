<?php

// require codebird
require_once('Twitter/codebird.php');

if(isset($_POST['submit'])){
    
    $key = trim($_POST['key']);
    $secret = trim($_POST['secret']);
    $token = trim($_POST['token']);
    $token_secret = trim($_POST['token_secret']);
    $message = trim($_POST['message']);
    
    $errors = array();
    
    if($key && $secret && $token && $token_secret && $message){
        
        \Codebird\Codebird::setConsumerKey($key, $secret);
        $cb = \Codebird\Codebird::getInstance();
        $cb->setToken($token, $token_secret);

        $params = array(
          'status' => $message
        );
        
        $reply = $cb->statuses_update($params);
        
        $errors[] = "Your Tweet has been sent!";
    }else{
        $errors[] = "All fields are required!";
    }    
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tweet</title>
        <style>
            #errors{
                width:300px;
                background:#ffcccc;
                border:thin solid #000;
                padding:5px 5px;
                color:#ff0000;
            }
        </style>
        <script type="text/javascript">
            function limit(){
                var message = document.getElementById('message');

                if(message.value.length >= 140){
                    alert('Tweet cannot be more than 140 characters!');
                    return false;
                }
            }
        </script>
    </head>
    <body>
        <?php
            if(!empty($errors) && is_array($errors)){
                foreach($errors as $error){
                    echo "<aside id='errors'>".$error."</aside>";
                }
            }
        ?>
        <form action="index.php" method="post">
            <table>
                <tr>
                    <td>Your Key</td>
                    <td><input type="text" name="key"</td>
                </tr>
                <tr>
                    <td>Your Secret</td>
                    <td><input type="text" name="secret"</td>
                </tr>
                <tr>
                    <td>Your Token</td>
                    <td><input type="text" name="token"</td>
                </tr>
                <tr>
                    <td>Token Secret</td>
                    <td><input type="text" name="token_secret"</td>
                </tr>
                <tr>
                    <td>Message</td>
                    <td><textarea name="message" cols="17" rows="5" id="message" onkeydown="limit();"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Tweet!"></td>
                </tr>
            </table>
        </form>
    </body>
</html>
