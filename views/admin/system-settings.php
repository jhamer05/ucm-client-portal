<BR><BR>
<?php if ($_SESSION['user_id'] == 1) { ?>
<div class="inner">
    <form method="post" enctype="multipart/form-data" id="main">
        <div class="welcome">
        <input type="hidden" name="admin_tab=3">
        <input type="submit"  name="update_page" value="Check For Updates" />
        </div>
    </form>
    <BR>
<form method="post" enctype="multipart/form-data" id="main">
    <div style="text-align: right;">
<ul style="padding: 10px; margin-top: -10px;">
    Timezone&nbsp;-&nbsp;
    <?php  
    $utc = new DateTimeZone('UTC');
    $dt = new DateTime('now', $utc);
    
if (defined('TIME_ZONE')) {
    $current_tz = constant('TIME_ZONE');
} else {
    $current_tz = 'America/New_York';
}
    echo '<select type="dropdown" name="userTimeZone" style="width: 250px;">';
    echo '<option value="' . $current_tz . '">' . $current_tz . '&nbsp;(Current)</option>';    foreach(DateTimeZone::listIdentifiers() as $tz) {
        $current_tz = new DateTimeZone($tz);
        $offset =  $current_tz->getOffset($dt);
        $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
        $abbr = $transition[0]['abbr'];

        echo '<option value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. $Controller->formatOffset($offset). ']</option>';
    }
    echo '</select>';
    ?>
</ul>
<ul style="padding: 10px; margin-top: -10px;">
    Change URL of UCM installation
    &nbsp;-&nbsp;<input type="username" name="ucm-url" 
                               value="<?php echo $_GET['ucm_url']; ?>" style="width: 250px;" /><BR>
</ul>
<ul style="padding: 10px;">
    Change the URL of this site
    &nbsp;-&nbsp;<input type="username" name="base-url" 
                               value="<?php echo $_GET['base_url']; ?>" style="width: 250px;" /><BR>
</ul>
<ul style="padding: 10px;">
    URL of main website
    &nbsp;-&nbsp;<input type="username" name="main-site" 
                               value="<?php echo constant('MAIN_SITE'); ?>" style="width: 250px;" /><BR>
</ul>
<ul style="padding: 10px;">
    Site Title
    &nbsp;-&nbsp;
    <input type="username" name="title" 
           value="<?php echo constant('SITE_TITLE'); ?>" style="width: 250px;" /><BR>
</ul>
<ul style="padding: 10px;">
    Notification Email
    &nbsp;-&nbsp;
    <input type="username" name="email" 
           value="<?php echo constant('SYSTEM_EMAIL'); ?>" style="width: 250px;" /><BR>
</ul>
<ul style="padding: 10px;">
    Company Name
    &nbsp;-&nbsp;
    <input type="username" name="company" 
           value="<?php echo constant('COMPANY_NAME'); ?>" style="width: 250px;" /><BR>
</ul>
<ul style="padding: 10px;">
    Phone Number
    &nbsp;-&nbsp;
    <input type="username" name="phone" 
           value="<?php echo constant('PHONE_NUMBER'); ?>" style="width: 250px;" /><BR>
</ul>
        <!--
<ul style="padding: 10px;">
    <input type="checkbox" name="demo" <?php //if(constant('DEMO_MODE') == 'on') { echo 'checked'; } ?> />
    &nbsp;Change to/from Demo Mode<BR>
        -->
</ul>
<ul style="padding: 10px;">
    <center>
    <a href="<?php echo constant('LOGO_IMG'); ?>" data-featherlight='image'>
    <img src="<?php echo constant('LOGO_IMG'); ?>" style="max-width: 80%"></a><BR>
    Logo
    &nbsp;-&nbsp;
    <input name="file" type="file" /><BR>
    </center>
</ul>


    
    <div class="welcome">
    <input type="submit"  name="settings_input" value="Continue" />
    </div>
</form>


        
<?php 
//$target_dir = "images/";
//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//$uploadOk = 1;
//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image

    ?>
        
        
        
    <?php
    if (isset($_POST['settings_input'])) {
        
    if (!empty($_FILES["file"])) {
        if ($_FILES["file"]["error"] > 0) {
            //echo "Error: " . $_FILES["file"]["error"] . "<br>";
            $logo_img = constant('LOGO_IMG');
        } else {
            //echo "Stored file:".$_FILES["file"]["name"]."<br/>Size:".($_FILES["file"]["size"]/1024)." kB<br/>";
            move_uploaded_file($_FILES["file"]["tmp_name"],'images/' . $_FILES["file"]["name"]);
            $logo_img = 'images/' . $_FILES["file"]["name"];
           }
    } else {
        $logo_img = constant('LOGO_IMG');
    }
           
        
    $db_name = constant('DB_NAME');
    $db_user = constant('DB_USER');
    $db_password = constant('DB_PASSWORD');
    $db_host = constant('DB_HOST');
    $db_prefix = constant('_DB_PREFIX');
    $secret = constant('_UCM_SECRET');
    
        
        
if (isset($_POST['userTimeZone'])) {
    $time_zone = $_POST['userTimeZone'];
} else {
    $time_zone = constant('TIME_ZONE');
}
        
if (isset($_POST['ucm-url'])) {
    $ucm_url = $_POST['ucm-url'];
} else {
    $ucm_url = $_GET['ucm_url'];
}
if (isset($_POST['base-url'])) {        
    $base_url = $_POST['base-url'];
} else {
    $base_url = $_GET['base_url'];
}
if (isset($_POST['title'])) {  
    $site_title = $_POST['title'];
} else {
    $site_title = constant('SITE_TITLE');
}
if (isset($_POST['main-site'])) {  
    $main_site = $_POST['main-site'];
} else {
    $main_site = constant('MAIN_SITE');
}
if (isset($_POST['email'])) {  
    $system_email = $_POST['email'];
} else {
    $system_email = constant('SYSTEM_EMAIL');
}
if (isset($_POST['company'])) {  
    $company_name = $_POST['company'];
} else {
    $company_name = constant('COMPANY_NAME');
}
if (isset($_POST['phone'])) {  
    $phone = $_POST['phone'];
} else {
    $phone = constant('PHONE_NUMBER');
}
    
    
    if (isset($_POST['demo'])) {
        $demo_mode = 'on';
    } else {
        $demo_mode = 'off';
    }

if (constant('DEMO_MODE') != 'on') {
        
file_put_contents('config/config.php', '<?php

//UCM Database Settings
//Make sure these match your UCM installation!
define("DB_NAME", "' . $db_name . '");
define("DB_USER", "' . $db_user . '");
define("DB_PASSWORD", "' . $db_password . '");
define("DB_HOST", "' . $db_host . '");
define("_DB_PREFIX", "' . $db_prefix . '");

//UCM Settings
//!IMPORTANT! - This is the decryption key for the file links to UCM.
//Change this to match your UCM installation
define("_UCM_SECRET","' . $secret . '"); 

//URL settings
//URL of your UCM installation"s top folder
$_GET["ucm_url"] = "' . $ucm_url . '";
//URL for this system"s top folder
$_GET["base_url"] = "' . $base_url . '";

//Client Portal Settings
//There may be issues with the dashboard lists if no timezone is set.
define("TIME_ZONE", "' . $time_zone . '");
//This is used for the page titles and a few other things here and there.
define("SITE_TITLE", "' . $site_title . '");
//There is a link in the main menu to go to this address
define("MAIN_SITE", "' . $main_site . '");
//Email address where all comment notifications will be sent
//This will change later and addresses will be pulled for staff members asigned to a project
define("SYSTEM_EMAIL", "' . $system_email . '");
//This is just used on quotes and invoices
define("PHONE_NUMBER", "' . $phone . '");
//Name of your company - Used for sending emails
define("COMPANY_NAME", "' . $company_name . '");
//Logo Image - Used for Quotes & Invoices
define("LOGO_IMG", "' . $logo_img . '");

// Demo mode settings
define("DEMO_MODE", "' . $demo_mode . '");

?>
');
}
        /*
        if (isset($_GET['section']) && $_GET['section'] < 2.5) {
            echo "<script>window.location = 'install.php?section=2.5'</script>";
        } elseif (!isset($_GET['section'])) {
            echo "<script>window.location = 'install.php?section=2.5'</script>";
        }*/
    }
    
//}
// --- End Section 2 ---

// --- Start Section 3 ---

if (isset($_GET['section']) && $_GET['section'] == 2.5) { 
    $scp_config = 'config/config.php';
    if (file_exists($scp_config)) {
        require_once('config/config.php');
        if (constant('DEMO_MODE') == 'on') {

if (isset($_POST['demo_client_email'])) { 
    $demo_client_email = $_POST['demo_client_email'];
} else {
    $demo_client_email = '';
}
        
if (isset($_POST['demo_client_pass'])) { 
    $demo_client_pass = $_POST['demo_client_pass'];
} else {
    $demo_client_email = '';
}
            
if (isset($_POST['demo_staff_email'])) {   
    $demo_staff_email = $_POST['demo_staff_email'];
} else {
    $demo_client_email = '';
}
            
if (isset($_POST['demo_staff_pass'])) { 
    $demo_staff_pass = $_POST['demo_staff_pass'];
} else {
    $demo_client_email = '';
}
        
?>
Just a few settings since this is a demo.
<form method="post" id="demo">

<ul style="padding: 10px;">
    <strong>Client Usernamer</strong><BR>
    <input type="username" name="client_email" placeholder="client@example.com" style="width: 250px;" /><BR>
</ul>
<ul style="padding: 10px;">
    <strong>Client Password</strong><BR>
    <input type="password" name="client_pass" placeholder="password" style="width: 250px;" /><BR>
</ul>
<ul style="padding: 10px;">
    <strong>Staff Username</strong><BR>
    <input type="username" name="staff_email" placeholder="staff@example.com" style="width: 250px;" /><BR>
</ul>
<ul style="padding: 10px;">
    <strong>Staff Password</strong><BR>
    <input type="password" name="staff_pass" placeholder="password" style="width: 250px;" /><BR>
</ul>

</div>
    <div class="welcome">
    <input type="submit"  name="demo_settings_input" value="Continue" />
    </div>
</form>

    <?php
if (isset($_POST['demo_settings_input'])) {

    $d_client_email = $_POST['client_email'];
    $d_client_pass = $_POST['client_pass'];
    $d_staff_email = $_POST['staff_email'];
    $d_staff_pass = $_POST['staff_pass'];
    
    $data = '<?php

define("DEMO_CLIENT_EMAIL", "' . $d_client_email . '");
define("DEMO_CLIENT_PASS", "' . $d_client_pass . '");
define("DEMO_STAFF_EMAIL", "' . $d_staff_email . '");
define("DEMO_STAFF_PASS", "' . $d_staff_pass . '");

?>
';

file_put_contents('config/config.php', $data, FILE_APPEND);
    
    if (isset($_GET['section']) && $_GET['section'] < 3) {
            echo "<script>window.location = 'index.php?page=admin'</script>";
        } elseif (!isset($_GET['section'])) {
            echo "<script>window.location = 'index.php?page=admin'</script>";
        }
    
}
} else {
        
    if (isset($_GET['section']) && $_GET['section'] < 3) {
            echo "<script>window.location = 'index.php?page=admin'</script>";
        } elseif (!isset($_GET['section'])) {
            echo "<script>window.location = 'index.php?page=admin'</script>";
        }
}
        } else { ?>
        <div class="welcome">
            <h2>Oh No! There was an error...</h2>
            There was an error creating the config file. Please try again. If the problem persists you may need to try re-installing by going <a href="install.php">Here</a>.
        </div>
    <?php
    }
    
}
?>
</div>
<?php
} else {
?>

<?php } ?>