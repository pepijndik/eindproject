<?php



class Model_mailer extends CI_Model
{
    public $mail;

    public function __construct($exceptions = false)
    {
        include APPPATH . 'third_party/phpmailer/PHPMailer.php';
        include APPPATH . 'third_party/phpmailer/Exception.php';
        include APPPATH . 'third_party/phpmailer/SMTP.php';
        $this->mail = new \PHPMailer\PHPMailer\PHPMailer($exceptions);
        $smtp = $this->config->item('smtp');
        //SMTP Setup
        if (!empty($smtp)) {
            $this->mail->SMTPDebug = $smtp['debug']; // Enable Verbose Debug output
            $this->mail->isSMTP();  // Set Mailer to use SMTP
            $this->mail->Host = $smtp['host']; // Specify Main and Backup SMTP Servers 
            $this->mail->SMTPAuth = $smtp['auth'];  // Enable SMTP Authentication
            $this->mail->Username = $smtp['username']; // SMTP username
            $this->mail->Password = $smtp['password']; // SMTP password
            $this->mail->SMTPSecure = $smtp['secure']; // Enable TLS Encryption, 'ssl' also accepted 
            $this->mail->Port = $smtp['port']; //TCP Port to connect to
        }
    }


    public function mail($to = array(), $subject, $html, $from = array(), $plaintext, $cc = array(), $bcc = array(), $attachments = array())
    {
        //Required Parameters are $to, $from, $subjects and $html and Plaintext
        if (empty($to) || empty($from) || empty($subject) || empty($html) || empty($plaintext)) {
            die('Missing a Parameter');
        }

        // Sender 
        $this->mail->setFrom($from['email'], $from['name']);
        $this->mail->addReplyTo('info@mobox.nl', 'Info mobox');

        //Recipients
        if (!empty($to)) {
            foreach ($to as $recipient) {
                $this->mail->addAddress($recipient['email'], $recipient['name']);
            }
        }
        //CC
        if (!empty($cc)) {
            foreach ($cc as $recipient) {
                $this->mail->addCC($recipient);
            }
        }
        //BCC
        if (!empty($bcc)) {
            foreach ($bcc as $recipient) {
                $this->mail->addBCC($recipient);
            }
        }
        // Attachments 
        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $this->mail->addAttachment($attachment);
            }
        }

        //HTML Mail
        $this->mail->isHTML(true);
        $this->mail->CharSet = "UTF-8;";
        $this->mail->Subject = $subject;
        $this->mail->Body = $html;
        //Plain text Version
        $this->mail->wordwrap = 1000000;
        $this->mail->AltBody = $plaintext;


        //Send the Mail
        try {
            $this->mail->send();
            // echo 'Mail is verstuurd';
            return true;
        } catch (Exception $e) {
            return false;
            echo 'Message could not be sent. Mailer Error:', $this->mail->ErrorInfo;
        }
    }
}
