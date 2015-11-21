
<?php

//require '../config/config.php';
require 'classes/PHPMailer/PHPMailerAutoload.php';
require_once('config/config.php');
//require 'classes/Controller.php';
class UserCheck {
    function project_info($project_id)
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }
        if (!$this->db_connection->connect_errno) {
            
            $query = "  SELECT  * 
                        FROM    `"._DB_PREFIX."job` 
                        WHERE   job_id = '" . $project_id . "';";
            
            $result = $this->db_connection->query( $query );
            
            return $result;
        }
    }
    function quote_info($quote_id)
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }
        if (!$this->db_connection->connect_errno) {
            
            $query = "  SELECT  * 
                        FROM    `"._DB_PREFIX."quote` 
                        WHERE   quote_id = '" . $quote_id . "';";
            
            $result = $this->db_connection->query( $query );
            
            return $result;
        }
    }
}

$UserCheck = new UserCheck();

if (!isset($Controller)) {
$Controller = new Controller();
}

$quote_id = $_GET['quote_id'];

$customer_query = $Controller->get_customer_info(); 
$num_results0 = $customer_query->num_rows; 
//if( $num_results0 > 0){ 
$row0 = $customer_query->fetch_assoc();
    
$email_query = $Controller->get_user_info(); 
$num_results = $email_query->num_rows; 
//if( $num_results > 0){ 
$row = $email_query->fetch_assoc(); 

$user_id = $_SESSION['user_id'];
$user_info_query = $Controller->get_user_info($user_id);
$user_info = $user_info_query->fetch_assoc();

//$project_id = $_POST['id'];
//$project_query = $UserCheck->project_info($project_id);
//$project_info = $project_query->fetch_assoc();

$quote_query = $UserCheck->quote_info($quote_id); 
$quote_info = $quote_query->fetch_assoc();

// -------- CLIENT TO STAFF EMAIL -------- // 
//if ($_SESSION['is_staff'] == 0){
        
        $address_to = $user_info['email'];
        $name = ($user_info['name'] . ' ' . $user_info['last_name']);
        $mail = new PHPMailer;

    $email_settings_query = $Controller->get_email_settings();
    $num_results = $email_settings_query->num_rows;
    //if( $num_results > 0){
    $row1 = $email_settings_query->fetch_assoc();
    //}
    
class phpmailerAppException extends phpmailerException {}
 

$to = $user_info['email'];
if(!PHPMailer::validateAddress($to)) {
  throw new phpmailerAppException("Email address " . $to . " is invalid -- aborting!");
} else {
    
$smtp_url = $row1['email_smtp_hostname'];
$parts = explode(":", $smtp_url);
$smtp_host = $parts[0];
$smtp_port = $parts[count($parts) - 1];
    
$mail->isSMTP();
$mail->SMTPDebug  = 0;
$mail->Host       = $smtp_host;
$mail->Port       = $smtp_port;
$mail->SMTPSecure = $row1['email_smtp_auth'];
$mail->SMTPAuth   = true;
$mail->Username   = $row1['email_smtp_username']; 
$mail->Password   = $row1['email_smtp_password'];
    

    
//------- SEND MAIL -------//    

        $mail->Subject = 'Comment on Quote: (' . $quote_info['name'] . ')';
        $mail->Body    = '<table style="width: 80%; border: 1px solid #000; background: #f5f5f5; color: 303030; margin: 0 auto; border-radius: 5px;">
        <TR>
        <TD style="padding: 15px;">
        <strong>This is a message regarding the quote for (' . $quote_info['name'] . ') for ' . $row0['customer_name'] . '.</strong><BR><BR>
        ' . $name . '&nbsp;said:' . '<p>' . $_POST['comment'] . '</p><BR><BR>
        </TD>
        </TR>
        </table>
            ';
    
        $mail->AltBody = 'This is a message regarding the quote for  (' . $quote_info['name'] . ') for ' . $row0['customer_name'] . '. - ' . $_POST['comment'];
    
        $mail->From = $_SESSION['email'];
        $mail->FromName = $name;
        $mail->addAddress($address_to);     // Add a recipient
        $mail->addReplyTo($_SESSION['email'], $name);
    

        $mail->WordWrap = 60;                                 // Set word wrap to 50 characters
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        if(!$mail->send()) {
            echo "<div class='welcome' style='
            position: absolute;
            z-index: 999;
            left: 4%;
            right: 4%;
            max-width: 95%;
            margin-top: 50px;
            margin-bottom: 50px;
            background-color: #f4f4f4; 
            background: rgba(255, 255, 255, 0.9); 
            color: #303030;
            padding: 4px; 
            border: 1px solid #d8d8d8; 
            text-align: center;
            box-shadow: 2px 2px 4px #808080;'>
            There was a problem sending your message... Please try again or contact an administrator if the problem persists.<BR><BR>";
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            if (constant('DEMO_MODE') == 'on') {
                echo '<BR><strong>Mail notifications are disabled for this demo. No email info is set.</strong>';
            }
            //echo '</div>';
            echo "<BR><BR><div style='text-align: center; width: 100%;'>Please <a href='index.php?quote_id=" . $quote_info['quote_id'] . "'>Click Here</a> to remove this message.</div>";
            echo '</div>';
        } else {
            echo "<div class='welcome' style='
            position: absolute;
            z-index: 999;
            left: 4%;
            right: 4%;
            max-width: 95%;
            margin-top: 50px;
            margin-bottom: 50px;
            background-color: #f4f4f4; 
            background: rgba(255, 255, 255, 0.9); 
            color: #303030;
            padding: 4px; 
            border: 1px solid #d8d8d8; 
            text-align: center;
            box-shadow: 2px 2px 4px #808080;'>
            <strong>Message Sent.</strong><br> A message has been sent to notify the staff of your comment.<BR>";
            echo "<BR><BR><div style='text-align: center; width: 100%;'>Please <a href='index.php?quote_id=" . $quote_info['quote_id'] . "'>Click Here</a> to remove this message.</div></div>";
        }
        
}


/*
// ---- Old System - May Not Always Work ---- //
require 'classes/PHPMailer/PHPMailerAutoload.php';

if (!isset($Controller)) {
$Controller = new Controller();
}

$customer_query = $Controller->get_customer_info(); 
$num_results0 = $customer_query->num_rows; 
if( $num_results0 > 0){ 
$row0 = $customer_query->fetch_assoc();
    
$email_query = $Controller->get_user_info($_POST['user_id']); 
$num_results = $email_query->num_rows; 
if( $num_results > 0){ 
$row = $email_query->fetch_assoc(); 

$invoice_query = $Controller->invoice_list(); 
$num_results3 = $invoice_query->num_rows; 
if( $num_results3 > 0){ 
$row3 = $invoice_query->fetch_assoc(); 

// -------- CLIENT TO STAFF EMAIL -------- // 
if ($_SESSION['is_staff'] == 0){
    
        $address_to = $row['email'];
        $name = ($row['name'] . ' ' . $row['last_name']);
        $mail = new PHPMailer;
        $client_name = ($_SESSION['name'] . ' ' . $_SESSION['last_name']);

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
    $email_settings_query = $Controller->get_email_settings();
    $num_results = $email_settings_query->num_rows;
    if( $num_results > 0){
    $row1 = $email_settings_query->fetch_assoc();
        $mail->Host = $row1['email_smtp_hostname'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $row1['email_smtp_username'];                 // SMTP username
        $mail->Password = $row1['email_smtp_password'];                           // SMTP password
        $mail->SMTPSecure = $row1['email_smtp_auth'];                            // Enable TLS encryption, `ssl` also accepted
        //$mail->Port = 587;                                    // TCP port to connect to
    }

        $mail->Subject = 'Quote Message From Client';
        $mail->Body    = '<strong>This is a message regarding the quote for (' . $row3['name'] . ') for ' . $row0['customer_name'] . '.</strong> <BR>' . $client_name . '&nbsp;said -<BR>' . '<p>' . $_POST['comment'];
        $mail->AltBody = 'This is a message regarding the quote for  (' . $row3['name'] . ') for ' . $row0['customer_name'] . '. - ' . $_POST['comment'];
        $mail->From = $_SESSION['email'];
        $mail->FromName = $client_name;
        $mail->addAddress($address_to);     // Add a recipient
        $mail->addReplyTo($_SESSION['email'], $client_name);
    }

        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        if(!$mail->send()) {
            echo 'There was a problem sending your message... Please email us directly at&nbsp;' . SYSTEM_EMAIL . '&nbsp;if the problem persists.<BR><BR>';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            if (constant('DEMO_MODE') == 'on') {
                echo '<BR><strong>Mail notifications are disabled for this demo. No email info is set.</strong>';
            }
            echo '</div>';
            echo "<BR><BR><div style='text-align: center; width: 100%;'>Please <a href='index.php'>Click Here</a> to return to the homepage.</div>";
        } else {
            echo "<BR><div class='welcome'><strong>Thank you.</strong><br>Your message has been sent. It will be reviewed as soon as posible. <BR>
            We appologize if this quote did not meet your expectations. We will do our best to make it better.</div><BR><BR>";
            echo "<BR><BR><div style='text-align: center; width: 100%;'>Please <a href='index.php'>Click Here</a> to return to the homepage.</div>";
        }  
    }
  }
}
*/