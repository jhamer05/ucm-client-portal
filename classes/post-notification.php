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
}

$UserCheck = new UserCheck();

if (!isset($Controller)) {
$Controller = new Controller();
}

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

$project_id = $_POST['id'];
$project_query = $UserCheck->project_info($project_id);
$project_info = $project_query->fetch_assoc();


// -------- CLIENT TO STAFF EMAIL -------- // 
if ($_SESSION['is_staff'] == 0){
        
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
    
        $mail->Subject = 'New comment for project: (' . $project_info['name'] . ')';
        $mail->Body    = '<table style="width: 80%; border: 1px solid #000; background: #f5f5f5; color: 303030; margin: 0 auto; border-radius: 5px;">
        <TR>
        <TD style="padding: 15px;">
        <strong>This is a message from ' . constant('COMPANY_NAME') . '.</strong><BR> This is to let you know that <strong>' . $user_info['name'] . '&nbsp;' . $user_info['last_name'] . '</strong> (' . $user_info['email'] . ') has left a comment for a project.<BR><BR>
        <center>
        <strong>Project: ' . $project_info['name'] . '</strong>
        <BR>
        <table style="border: 0px solid; margin: 10px auto; text-align: center; max-width: 300px;">
        <TR>
        <TD>
        <img src="' . $Controller->display_project_latest_image('list-img', $project_info['job_id'], '0', '1') . '" width="300px">
        </TD>
        </TR>
        </table>
        </center>
        <BR>
        <BR>
        <strong>Comment:</strong>
        <BR>
        ' . $_POST['comment'] . '
        <BR><BR>
        <a href="' . $_GET["base_url"] . 'index.php?project_id=' . $project_info['job_id'] . '">Click Here</a> to vew the project.
        </TD>
        </TR>
        </table>
            ';
    
        $mail->AltBody = 'This is a message from ' . constant('COMPANY_NAME') . '.</strong><BR> This is to let you know that ' . $user_info['name'] . ' ' . $user_info['last_name'] . ' (' . $user_info['email'] . ') has left a comment for a project.';
    
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
            echo "<BR><BR><div style='text-align: center; width: 100%;'>Please <a href='index.php?project_id=" . $project_info['job_id'] . "'>Click Here</a> to remove this message.</div>";
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
            echo "<BR><BR><div style='text-align: center; width: 100%;'>Please <a href='index.php?project_id=" . $project_info['job_id'] . "'>Click Here</a> to remove this message.</div></div>";
        }
        
}



// -------- STAFF TO CLIENT EMAIL -------- //    
} elseif ($_SESSION['is_staff'] == 1){
    if (isset($_POST['notify_customer'])) {
        //$address_to = $row['email'];
        //$name = ($row['name'] . ' ' . $row['last_name']);
        //$mail = new PHPMailer;

    $email_settings_query = $Controller->get_email_info($_GET['project_id']);
    $num_results = $email_settings_query->num_rows;
    $client_info = $email_settings_query->fetch_assoc();
        
        $address_to = $client_info['email'];
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
    
        $mail->Subject = 'New comment for project: (' . $project_info['name'] . ')';
        $mail->Body    = '<table style="width: 80%; border: 1px solid #000; background: #f5f5f5; color: 303030; margin: 0 auto; border-radius: 5px;">
        <TR>
        <TD style="padding: 15px;">
        <strong>This is a message from ' . constant('COMPANY_NAME') . '.</strong><BR> This is to let you know that <strong>' . $user_info['name'] . '&nbsp;' . $user_info['last_name'] . '</strong> (' . $user_info['email'] . ') has left a comment or updated a project.<BR><BR>
        <center>
        <strong>Project: ' . $project_info['name'] . '</strong>
        <BR>
        <table style="border: 0px solid; margin: 10px auto; text-align: center; max-width: 300px;">
        <TR>
        <TD>
        <img src="' . $Controller->display_project_latest_image('list-img', $project_info['job_id'], '0', '1') . '" width="300px">
        </TD>
        </TR>
        </table>
        </center>
        <BR>
        <BR>
        <strong>Comment:</strong>
        <BR>
        ' . $_POST['comment'] . '
        <BR><BR>
        <a href="' . $_GET["base_url"] . 'index.php?project_id=' . $project_info['job_id'] . '">Click Here</a> to vew the project.
        </TD>
        </TR>
        </table>
            ';
    
        $mail->AltBody = 'This is a message from ' . constant('COMPANY_NAME') . '.</strong><BR> This is to let you know that ' . $user_info['name'] . ' ' . $user_info['last_name'] . ' (' . $user_info['email'] . ') has left a comment for a project.';
    
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
            echo "<BR><BR><div style='text-align: center; width: 100%;'>Please <a href='index.php?project_id=" . $project_info['job_id'] . "'>Click Here</a> to remove this message.</div>";
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
            echo "<BR><BR><div style='text-align: center; width: 100%;'>Please <a href='index.php?project_id=" . $project_info['job_id'] . "'>Click Here</a> to remove this message.</div></div>";
        }
        
}
        
    }
}
  
    
