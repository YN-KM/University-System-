<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$email = $name = $subject = $body  = '';
$errors = [];

$to = 'info@le-sultan.com';

if (isset($_POST['email'])){
    $email = $_POST['email'];
}

if (isset($_POST['name'])) {
   $name = $_POST['name'];
}

if (isset($_POST['txtcntctno'])) {
    $phone = $_POST['txtcntctno'];
}

$subject = 'New message from site le-sultan.com';

if (isset($_POST['body'])) {
    $body = $_POST['body'];
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors []= 'Invalid email';
}

if (empty($name)) {
    $errors []= 'Name is empty';
}

//var_dump($errors);

if (count($errors) > 0) {
    echo json_encode([
        'status' => 'error',
        'data' => $errors
    ]);
    exit;
}

$subject = 'Beontop debug';
$messageContent = 'Email: ' . $email . PHP_EOL;
$messageContent .= 'Name: ' . $name . PHP_EOL;
if (!empty($phone)) {
    $messageContent .= 'Phone number: ' . $phone . PHP_EOL;
}
if (!empty($body))
{
    $messageContent .= 'Message:' . PHP_EOL . $body;
}


$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
//    $mail->isSMTP(true);                                      // Set mailer to use SMTP

    $mail->Host = "ssl://le-sultan.com:465";
    //Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth = true;
    //Provide username and password
    $mail->Username = "no-reply@le-sultan.com";
    $mail->Password = "no-reply@le-sultan";

    //Recipients
    $mail->setFrom($mail->Username, $name);
    $mail->addAddress($to);     // Add a recipient
    $mail->addReplyTo($email, $name);

    //Content
    //$mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $messageContent;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo json_encode([
        'status' => 'success',
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => [
            'Unable to send message. Try again later',
        ],
    ]);
    //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
