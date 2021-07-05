<?php

spl_autoload_register();
use src\Mailer;  
header("Access-Control-Allow-Origin: *");
 // Only process POST reqeusts.
print_r($_SERVER["REQUEST_METHOD"] );
if ($_SERVER["REQUEST_METHOD"] == "POST") {

$mailer = new Mailer($_POST["name"],$_POST["subject"],$_POST["message"],$_POST["email"]);
$mailer->send();

} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "There was a problem with your submission, please try again.\n 
        Ha habido un problema con su envío, inténtelo de nuevo.
    ";
}   


