
<?php
require 'classes/PHPMailer/PHPMailerAutoload.php';

if (!isset($Controller)) {
$Controller = new Controller();
}

$system_url = $_GET["base_url"];

$customer_query = $Controller->get_customer_info(); 
$num_results0 = $customer_query->num_rows; 
//if( $num_results0 > 0){ 
$row0 = $customer_query->fetch_assoc();
    
$email_query = $Controller->get_user_info(); 
$num_results = $email_query->num_rows; 
//if( $num_results > 0){ 
$row = $email_query->fetch_assoc(); 

$user_id = $_GET['user_id'];
$user_info_query = $Controller->get_user_info($user_id);
$user_info = $user_info_query->fetch_assoc();

$email_query = $Controller->get_user_info_staff($_POST['user_id']); 
$num_results = $email_query->num_rows; 
$row = $email_query->fetch_assoc(); 

// -------- CLIENT EMAIL -------- // 
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
    

    
/*
        $address_to = $row['email'];
        $name = ($_SESSION['name'] . ' ' . $_SESSION['last_name']);
        $mail = new PHPMailer;
        $client_name = ($row['name'] . ' ' . $row['last_name']);

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
*/
    if (isset($_POST['new_pass'])) {
        $pass = $_POST['new_pass'];
    } else {
        $pass = "Unchanged";
    }
    if ($user_info['phone'] != '') {
        $phone = $user_info['phone'];
    } else {
        $phone = "Not On File";
    }
    if ($user_info['name'] == '' && $user_info['last_name'] == '') {
        $name1 = "Not On File";
    } else {
        if ($user_info['last_name'] == '') {
            $l_name = "Not On File";
        } else {
            $l_name = $user_info['last_name'];
        }
        if ($user_info['name'] == '') {
                $f_name = "Not On File";
        } else {
                $f_name = $user_info['name'];
        }
        $name1 = $f_name . '&nbsp;' . $l_name;
    }
    
        $mail->Subject = 'User information updated';
        $mail->Body    = '<table style="width: 80%; border: 1px solid #000; background: #f5f5f5; color: 303030; margin: 0 auto; border-radius: 5px;">
        <TR>
        <TD style="padding: 15px;">
        <strong>This is a message from ' . constant('COMPANY_NAME') . '.</strong> This is to let you know that your user information or password has been updated. <BR><BR>
        
        Please login to <a href="' . $system_url . '">' . $system_url . '</a> with the credentials below.<BR>
        <center>
        <table style="border: 1px solid #000; color: 303030; margin: 10px auto;">
        <TR style="border: 1px solid #000; color: 303030; padding: 5px;">
        <TD style="padding: 10px;">
        Name:
        </TD>
        <TD style="padding: 10px;">
        ' . $name1 . '
        </TD>
        </TR>
        <TR style="border: 1px solid #000; color: 303030; padding: 5px;">
        <TD style="padding: 10px;">
        Company:
        </TD>
        <TD style="padding: 10px;">
        ' . $row['customer_name'] . '
        </TD>
        </TR>
        <TR style="border: 1px solid #000; color: 303030; padding: 5px;">
        <TD style="padding: 10px;">
        Phone:
        </TD>
        <TD style="padding: 10px;">
        ' . $phone . '
        </TD>
        </TR>
        <TR style="border: 1px solid #000; color: 303030; padding: 5px;">
        <TD style="padding: 10px;">
        Username:
        </TD>
        <TD style="padding: 10px;">
        ' . $user_info['email'] . '
        </TD>
        </TR>
        <TR style="border: 1px solid #000; color: 303030; padding: 5px;">
        <TD style="padding: 10px;">
        Password:
        </TD>
        <TD style="padding: 10px;">
        ' . $pass . '
        </TD>
        </TR>
        </table>
        </center>
        <BR>
        If any of this information is incorect or if you need help loging in please contact ' . SYSTEM_EMAIL . ' for further assistance.
        <BR><BR>
        It is recommended that you change you password on the profile page once you log in. To do so simply click the avatar image in the upper left portion of the screen.
        </TD>
        </TR>
        </table>
            ';
    
    
    /*
    
        $mail->Body    = '<strong>This is a message from ' . constant('COMPANY_NAME') . '.</strong> This is to let you know that your user information or password has been updated. <BR><BR>
        Company: ' . $row['customer_name'] . '<BR>
        Name: ' . $row['name'] . ' ' . $row['name'] . '<BR>
        Email: ' . $row['email'] . '<BR>
        ' . $pass . '
        <BR>
        If any of this information is incorect please contact ' . SYSTEM_EMAIL . ' for further assistance.
        <BR><BR>
        It is recommended that you change you password on the profile page once you log in. To do so simply click the avatar image in the upper left portion of the screen.
            ';
        $mail->AltBody = 'This is a message from ' . constant('COMPANY_NAME') . '. This is to let you know that your user information or password has been updated. - Email:' . $row['email'] . ' ' . $pass;
        */
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
            echo "<BR><BR><div style='text-align: center; width: 100%;'>Please <a href='index.php?page=staff&staff_tab=4&user_id=" . $_POST['user_id'] . "'>Click Here</a> to remove this notice.</div>";
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
            <strong>Message Sent.</strong><br> A message has been sent to the client to inform them of any changes you've made.<BR>";
            echo "<BR><BR><div style='text-align: center; width: 100%;'>Please <a href='index.php?page=staff&staff_tab=4&user_id=" . $_POST['user_id'] . "'>Click Here</a> to remove this notice.</div></div>";
        }  
    
  }
