<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer-master/src/Exception.php';
require '../../PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/src/SMTP.php';


function sendMail($mailTo, $recipientName,$mailBody,$mailSubject)
{
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true); // true enables exceptions

    try {
        // Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';               // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                             // Enable SMTP authentication
        $mail->Username = 'pharmacypi012@gmail.com';         // SMTP username
        $mail->Password = 'ykxjqdjjtrkrvaoq';            // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                              // TCP port to connect to

        // Recipients
        $mail->setFrom('pharmacypi012@gmail.com', 'PI Pharmacy');
        $mail->addAddress($mailTo, $recipientName); // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $mailSubject;
        $mail->Body = $mailBody;

        if($mail->send()){
                return ["isSuccess" => true, "data" => ["destinationMail"=>$mailTo, "recipientName"=>$recipientName], "message" => "send mail successfully!"];
        } 
        
    } catch (Exception $e) {
     
        return ["isSuccess" => false, "data" => [$mail->ErrorInfo], "message" => "Failed to send mail."];
    }


}

function generatePassword() {
    $length = 8;
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';

    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $password;
}
