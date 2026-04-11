<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UEmail {

    public static function sendEmail(string $recipientEmail, string $recipientName, string $subject, string $body) : bool {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER; 
            $mail->Password   = SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SMTP_PORT;

            $mail->setFrom('info@volunturing.it', 'Volunturing');
            $mail->addAddress($recipientEmail, $recipientName);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Impossibile inviare la mail. Errore: {$mail->ErrorInfo}");
            return false;
        }
    }
}

?>