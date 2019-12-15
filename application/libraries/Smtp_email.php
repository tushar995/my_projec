<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* PHPMailer library 
 * (To load Composer's autoloader, make sure $config['autoload'] is 
 * set to TRUE in config file)
 *
 */

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//include('./vendor/autoload.php');


class Smtp_email{

    var $host = 'mindiii.com', //server hostname
        $user_name = 'test@mindiii.com',
        $pwd = 'Ch@ML7!s-R@+',
        $from_mail = 'test@mindiii.com', //email a/c username
        $port = 587, //or 25(depends or server email configuration)
        $from_name = 'LIVE WIRE';

    public function __construct(){
        $this->mail = new PHPMailer(true);  // Passing `true` enables exceptions
        $this->mail->From = $this->from_mail;
        $this->mail->FromName = $this->from_name;
    }

    //to override default 'from' email and name
    public function set_header($from_email, $from_name, $reply_to=FALSE){
        
        $this->mail->setFrom($from_email, $from_name);

        //whether 'reply-to' should be added?
        if($reply_to)
            $mail->addReplyTo($from_email, $from_name);
    }
 
    
    public function send_mail($to, $subject, $message){

        //$this->mail = new PHPMailer(true);  // Passing `true` enables exceptions

        try {
            //Server settings

            //$this->mail->SMTPDebug = 2;  // Enable verbose debug output

            //Godaddy server does not allow to use SMTP authentication
            //$this->mail->isSMTP();         // Set mailer to use SMTP

            $this->mail->Host = $this->host;;  // Specify main and backup SMTP servers

            //Godaddy server does not allow to use SMTP authentication
            $this->mail->SMTPAuth = false;      // Enable SMTP authentication
            
            $this->mail->Username = $this->user_name;  // SMTP username
            $this->mail->Password = $this->pwd;        // SMTP password
            $this->mail->SMTPSecure = 'tls';  // Enable TLS encryption, `ssl` also accepted
            $this->mail->Port = $this->port;  // TCP port to connect to

            //Recipients
            $this->mail->addAddress($to);   // Name is optional
             
            //Content
            $this->mail->isHTML(true);      // Set email format to HTML
            $this->mail->Subject = $subject;
            $this->mail->Body    = $message;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
            $this->mail->send();
            return TRUE;
            //echo 'Message has been sent';
        } catch (Exception $e) {
            return 'Message could not be sent. Error: '. $this->mail->ErrorInfo;
        }
    } 
}