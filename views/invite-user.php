<?php
class UserCheck {
    function get_user_info_by_email($email) {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        $where = "WHERE       email = '" . $email . "'";
        
        $query = "  SELECT      *
                    FROM        `"._DB_PREFIX."user`
                    $where
        ;";
        
        $result = $this->db_connection->query( $query ); 
        return $result;
    }
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
$user_info_query = $UserCheck->get_user_info_by_email($_POST['email']); 
$num_results = $user_info_query->num_rows; 

$user_info = $user_info_query->fetch_assoc(); 
$project_id = $_POST['project_id'];
$email = $_POST['email'];

    

if (!isset($Controller)) {
    $Controller = new Controller();
}
    ?>
    <BR>
        
        
<?php
if (!isset($_POST['proceed'])) {
?>
        
        
        
<?php 
if ($_POST['email'] == $user_info['email']) { 
        $user_exists = 1; 
$client_access_query = $Controller->projects_list('0,1', '1');
$rowC = $client_access_query->fetch_assoc();
    if ($rowC['customer_id'] == $user_info['customer_id'] || $user_info['is_staff'] == 1 || $user_info['user_id'] == '1') {
        $client_access = 1;
    } else {
        $client_access = 0;
    }
    
//$Controller = new Controller();
$special_access_query = $Controller->special_access($user_info['user_id']);
$row = $special_access_query->fetch_assoc();
    if ($row['special_access'] != 'NULL' && $row['special_access'] != '') {
        $special_access_values = explode(',',$row['special_access']);
        if (in_array("$project_id", $special_access_values)) {
            $grant_access = 1;
        } else {
            $grant_access = 0;
        }
    } elseif ($client_access == 1){
        $grant_access = 1;
    } else {
            $grant_access = 0;
    }
} else {
    $grant_access = 0;
}




if ($_POST['email'] == $user_info['email'] && $grant_access == '1') { 
        //$user_exists = 1; ?>
    <div class='due-date' style='background-color: #909090; color: f5f5f5; font-size: 20px; font-weight: 700;'>
        User Already Has Access
    </div><BR>
    <div style="width: 75%; margin: 0 auto;">
    There is already a user in the system with the email address you provided. This user also already has access to the project you're inviting them to.
        <HR style="margin: 10px;">


<?php 
} elseif ($_POST['email'] == $user_info['email'] && $grant_access == '0') { 
        //$user_exists = 1; ?>
<div class='due-date' style='background-color: #909090; color: f5f5f5; font-size: 20px; font-weight: 700;'>
    User Already Exists
</div><BR>
<div style="width: 75%; margin: 0 auto;">
There is already a user in the system with the email address you provided. Please confirm that you still wish to share the project with this person.
    <HR style="margin: 10px;">
        <center>
        <table style="margin: 0 auto: border: 0px solid; ">
            <TR style="font-size: 18px; font-weight: 600;">
                <TD>
                    Name:&nbsp;
                </TD>
                <TD>
                    <?php
                    if ($user_info['name'] != '') {
                        echo $user_info['name'] . "&nbsp;";
                        if ($user_info['last_name'] != '') {
                            echo $user_info['last_name'];
                        }
                    } else {
                        echo "Not On File";
                    }
                    ?>
                </TD>
            </TR>
            <TR style="font-size: 18px; font-weight: 600;">
                <TD>
                    Email:&nbsp;
                </TD>
                <TD>
                    <?php
                    if ($user_info['email'] != '') {
                        echo $user_info['email'] . "&nbsp;";
                    } else {
                        echo "Not On File";
                    }
                    ?>
                </TD>
            </TR>
            <TR style="font-size: 18px; font-weight: 600;">
                <TD>
                    Phone:&nbsp;
                </TD>
                <TD>
                    <?php
                    if ($user_info['phone'] != '') {
                        echo $user_info['phone'] . "&nbsp;";
                    } else {
                        echo "Not On File";
                    }
                    ?>
                </TD>
            </TR>
        </table>
            
            
            
            
<?php } else { 
        $user_exists = 0;
        //$grant_access = 0; ?>
        <div class='due-date' style='background-color: #909090; color: f5f5f5; font-size: 20px; font-weight: 700;'>
    Please Confirm
</div><BR>
<div style="width: 75%; margin: 0 auto;">
Please double check the email you provided to make sure this is the correct address. This will set up an acount for this person and give them access to this project. If the information below is incorrect, please return to the previous page and re-enter it.
    <HR style="margin: 10px;">
        <center>
        <table style="margin: 0 auto: border: 0px solid; ">
            <TR style="font-size: 18px; font-weight: 600;">
                <TD>
                    Email:&nbsp;
                </TD>
                <TD>
                    <?php
                    echo $_POST['email'];
                    ?>
                </TD>
            </TR>
        </table>
        </center>
<?php } ?>
<BR>
    <center>
        <form method="post">
            <?php 
            if ($grant_access == '0') {
            echo '<input type="submit" style="padding: 4px; width: auto;" 
                       name="proceed" 
                       value="Proceed"/>';
            } ?>
            <input type="submit" style="padding: 4px; width: auto;" 
                       name="cancel" 
                       value="Cancel"/>
            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="hidden" name="user_exists" value="<?php echo $user_exists; ?>">
        </form>
    </center>
</div><BR><BR>
    <? 
if (isset($_POST['cancel'])) {
    echo "<script>document.location = 'index.php?project_id=" . $project_id . "'</script>";
}

}

if (isset($_POST['proceed'])) {
    
    $user_exists = $_POST['user_exists'];
    
    if (!isset($Controller)) {
    $Controller = new Controller();
    }
    
    if ($user_exists == '1') {
    $user_id = $user_info['user_id'];
    }
    
    if ($user_exists == '1' && $user_info['customer_id'] != '') {
        $customer_id = $user_info['customer_id'];
    } else {
        $customer_id = '0';
    }
    if ($user_exists == '1' && $user_info['is_staff'] != '') {
        $is_staff = $user_info['is_staff'];
    } else {
        $is_staff = '0';
    }
    if ($user_exists == '1' && $user_info['name'] != '') {
        $name = $user_info['name'];
    } else {
        $name = '';
    }
    if ($user_exists == '1' && $user_info['last_name'] != '') {
        $last_name = $user_info['last_name'];
    } else {
        $last_name = '';
    }
    if ($user_exists == '1' && $user_info['email'] != '') {
        $email = $user_info['email'];
    } else {
        $email = $_POST['email'];
    }
    if ($user_exists == '1' && $user_info['password'] != '') {
        $password = $user_info['password'];
    } else {
        $password = $Controller->randomPassword();
    }
    if ($user_exists == '1' && $user_info['phone'] != '') {
        $phone = $user_info['phone'];
    } else {
        $phone = '';
    }
    if ($user_exists == '1' && $user_info['date_created'] != '') {
        $date_created = $user_info['date_created'];
    } else {
        $date_created = 'NOW()';
    }
    
    
    $special_access_seperator = ', ';
    $special_access_new = $_POST['project_id'];
    if ($user_info['special_access'] != '') {
        $special_access_read = $user_info['special_access'];
        $special_access_write = $special_access_read . $special_access_seperator . $special_access_new;
    } else {
        $special_access_write = $special_access_new;
    }
    
//echo $customer_id . $is_staff . $email . $password . $name . $last_name . $phone . $date_created . $special_access_write;
echo "<BR>";
if ($user_exists == '1') {
    $Controller->update_user($customer_id, $is_staff, $email, $password, $name, $last_name, $phone, $date_created, $special_access_write, $user_id);
    
} elseif ($user_exists == '0') {
    $Controller->add_user($customer_id, $is_staff, $email, $password, $name, $last_name, $phone, $date_created, $special_access_write);
    
} else {
    echo "Something went wrong with the script...";
}
    
    //$Controller->add_user($customer_id, $is_staff, $email, $password, $name, $last_name, $phone, $date_created, $special_access_write);



?>
<?php
require 'classes/PHPMailer/PHPMailerAutoload.php';


if (!isset($Controller)) {
    $UserCheck = new UserCheck();
}
    
if (!isset($user_info)) {
$user_info_query = $UserCheck->get_user_info_by_email($_POST['email']); 
$num_results = $user_info_query->num_rows; 
$user_info = $user_info_query->fetch_assoc(); 
}
$project_id = $_POST['project_id'];
//$email = $_POST['email'];

$project_query = $UserCheck->project_info($project_id);
$project_info = $project_query->fetch_assoc();

$project_image = $Controller->display_project_latest_image('list-img', $project_info['job_id'], '0', '1');

    
$system_url = $_GET["base_url"];
    
if ($user_exists == '1' && $user_info['password'] != '') {
        $mailed_pass = 'HIDDEN';
    } elseif ($user_exists == '0' && $user_info['password'] != '') {
        $mailed_pass = $user_info['password'];
    } else {
        $mailed_pass = 'Error: Please contact an administrator if you don\'t know you\'re password';
}
    
/*
$email_query = $Controller->get_user_info_staff($_POST['user_id']); 
$num_results = $email_query->num_rows; 
if( $num_results > 0){ 
$row = $email_query->fetch_assoc(); 
*/
$user_id = $_SESSION['user_id'];
$user_info_query = $Controller->get_user_info($user_id);
$user_info_db = $user_info_query->fetch_assoc();

// -------- CLIENT EMAIL -------- // 
//if ($_SESSION['is_staff'] == 0){
    
        $address_to = $user_info['email'];
        $name = ($user_info_db['name'] . ' ' . $user_info_db['last_name']);
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
    
    
if (constant('DEMO_MODE') == 'on') {
    echo "<BR><div class='welcome' style='
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
            Emails cannot be sent from the demo. However, below is a preview of how the email would look. Also any new users are functional, so feel free to log in with these credentials and see how the system would look to someone with whom you share a project.</div>";
    echo '<br>';
    echo '<br>';
    echo '<table style="width: 80%; border: 1px solid #000; background: #f5f5f5; color: 303030; margin: 0 auto; border-radius: 5px;">
        <TR>
        <TD style="padding: 15px;">
        <strong>This is a message from ' . constant('COMPANY_NAME') . '.</strong><BR> This is to let you know that <strong>' . $user_info_db['name'] . '&nbsp;' . $user_info_db['last_name'] . '</strong> (' . $user_info_db['email'] . ') has shared a project with you. This means you can login and it will appear in your projects list. You can then view progress and add comments throughout the process.<BR><BR>
        <center>
        <strong>Project: ' . $project_info['name'] . '</strong>
        <BR>
        <table style="border: 0px solid; margin: 10px auto; text-align: center; max-width: 300px;">
        <TR>
        <TD>
        <img src="' . $project_image . '" width="300px">
        </TD>
        </TR>
        </table>
        </center>
        <BR>
        Please login to <a href="' . $system_url . '">' . $system_url . '</a> with the credentials below.<BR>
        <strong>NOTE:</strong>If you already have an account the password field bellow is hidden.<BR>
        <center>
        <table style="border: 1px solid #000; color: 303030; margin: 10px auto;">
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
        ' . $mailed_pass . '
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
} else {
    
//------- SEND MAIL -------//    
    
        $mail->Subject = 'You were invited to view a project!';
        $mail->Body    = '<table style="width: 80%; border: 1px solid #000; background: #f5f5f5; color: 303030; margin: 0 auto; border-radius: 5px;">
        <TR>
        <TD style="padding: 15px;">
        <strong>This is a message from ' . constant('COMPANY_NAME') . '.</strong><BR> This is to let you know that <strong>' . $user_info_db['name'] . '&nbsp;' . $user_info_db['last_name'] . '</strong> (' . $user_info_db['email'] . ') has shared a project with you. This means you can login and it will appear in your projects list. You can then view progress and add comments throughout the process.<BR><BR>
        <center>
        <strong>Project: ' . $project_info['name'] . '</strong>
        <BR>
        <table style="border: 0px solid; margin: 10px auto; text-align: center; max-width: 300px;">
        <TR>
        <TD>
        <img src="' . $project_image . '" width="300px">
        </TD>
        </TR>
        </table>
        </center>
        <BR>
        Please login to <a href="' . $system_url . '">' . $system_url . '</a> with the credentials below.<BR>
        <strong>NOTE:</strong>If you already have an account the password field bellow is hidden.<BR>
        <center>
        <table style="border: 1px solid #000; color: 303030; margin: 10px auto;">
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
        ' . $mailed_pass . '
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
    
        $mail->AltBody = 'This is a message from ' . constant('COMPANY_NAME') . ' to let you know that ' . $user_info_db['name'] . ' ' . $user_info_db['last_name'] . ' (' . $user_info_db['email'] . ') has shared a project with you. This means you can login and it will appear in your projects list. You can then view progress and add comments throughout the process. Please Login to ' . $system_url . ' with the following credentials:(NOTE: If you already have an account the password field is hidden.) (Username): ' . $user_info['email'] . ' (Password): ' . $mailed_pass . '
        ';
    
        $mail->From = $user_info_db['email'];
        $mail->FromName = $name;
        $mail->addAddress($address_to);     // Add a recipient
        $mail->addReplyTo($user_info_db['email'], $name);
    

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
            echo "<BR><BR><div style='text-align: center; width: 100%;'>Please <a href='index.php?project_id=" . $project_info['job_id'] . "'>Click Here</a> to return to the project page.</div>";
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
            <strong>Message Sent.</strong><br> A message has been sent to the client to inform them of you're invitation.<BR>";
            echo "<BR><BR><div style='text-align: center; width: 100%;'>Please <a href='index.php?project_id=" . $project_info['job_id'] . "'>Click Here</a> to return to the project page.</div></div>";
        }
        
}
}
  //}*/
}


