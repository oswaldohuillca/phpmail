<?php
namespace src;
class Mailer{
    private $name;
    private $subject;
    private $message;
    private $email;
    private string $recipient = "oswaldohuillca@gmail.com";
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
        //$this->subject = "Cotización de: $this->name";

        // Build the email content.
        $email_content = "Name: {$this->name}\n";
        $email_content .= "Email: {$this->email}\n\n";
        $email_content .= "Subject: {$this->subject}\n\n";
        $email_content .= "Message:\n{$this->message} \n";

        // Build the email headers.
   
        
        $email_headers  = 'MIME-Version: 1.0' . "\r\n";
        $email_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $email_headers .= "To: Oswaldo <oswaldohuillca@gmail.com>". "\r\n";
        $email_headers .= "From: {$this->name} <{$this->email}>" . "\r\n";
        $email_headers .= "Reply-To: {$this->email}\r\n";
        $email_headers .= "X-Mailer: PHP/".phpversion()."\r\n";
        $email_headers .= 'Cc: oswaldohuillca@gmail.com' . "\r\n";
        $email_headers .= 'Bcc: oswaldohuillca@gmail.com' . "\r\n";

        ini_set ( "SMTP", "smtp-server.example.com" );
        date_default_timezone_set('America/Lima');

        // Send the email.
        if (mail($this->recipient, $this->subject, $email_content, $email_headers)) {
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