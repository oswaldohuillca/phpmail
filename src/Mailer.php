<?php
namespace src;
class Mailer{
    private $name;
    private $subject;
    private $message;
    private $email;
    private $recipient = "oswaldohuillca@gmail.com";
    public function __construct($name,$subject,$message,$email){
        $this->name = strip_tags(trim($name));
        $this->subject = trim($subject);
        $this->email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        $this->message = trim($message);

       
    }
    public function send() {
        // Check that data was sent to the mailer.
        if ( empty($this->name) OR empty($this->subject) OR empty($this->message) OR !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.

        // Set the email subject.
        $this->subject = "New contact from $this->name";

        // Build the email content.
        $email_content = "Name: {$this->name}\n";
        $email_content .= "Email: {$this->email}\n\n";
        $email_content .= "Subject: {$this->subject}\n\n";
        $email_content .= "Message:\n{$this->message} \n";

        // Build the email headers.
        /*$email_headers = "From: $this->name <$this->email>\n";
        $email_headers .= "Reply-To: bob@bob.com\r\n";
        $email_headers .= "X-Mailer: PHP/".phpversion()."\r\n";
        $email_headers .= "Mime-Version: 1.0\n";*/
        
        $email_headers  = 'MIME-Version: 1.0' . "\r\n";
        $email_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $email_headers .= "To: {$this->name} <mary@example.com>, Kelly <kelly@example.com>" . "\r\n";
        $email_headers .= 'From: Recordatorio <cumples@example.com>' . "\r\n";
        $email_headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
        $email_headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

        ini_set ( "SMTP", "smtp-server.example.com" );
        date_default_timezone_set('America/New_York');

        // Send the email.
        if (mail($this->recipient, $this->subject, $email_content, $email_headers,'-fwebmaster@example.com')) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "¡Gracias! Su mensaje ha sido enviado.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }
    }
}