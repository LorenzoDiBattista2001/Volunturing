<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class for configuring and using the PHPMailer library
 */
class UEmail {

    /**
     * Sends an email to the specified address using SMTP
     * 
     * This method sets the SMTP host, username, password and port to the relevant
     * values globally defined in the configuration file, creates an HTML email with
     * a given subject and body and tries to send it to the specified address
     * 
     * @param string $recipientEmail The email address to send the email message to
     * @param string $recipientName The name associated with the email address of the recipient
     * @param string $subject The subject of the email to be sent
     * @param string $body The HTML body of the email to be sent
     * @return bool true if the email was successfully sent (i.e. accepted by the SMPT server), false otherwise
     */
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