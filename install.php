<!DOCTYPE html>
<head>
<?php
//include("views/header.php");
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="css/style.css">
<script src="js/pagefade.js"></script>
<script src="js/menu.js"></script>
<?php
require("classes/Controller.php");
$Controller = new Controller();
?>
<style>
    ul:nth-child(odd) {
        background-color: #f5f5f5;
    }
    a {
       color: #303030; 
        -o-transition:.3s;
        -ms-transition:.3s;
        -moz-transition:.3s;
        -webkit-transition:.3s;
    }
    a:hover {
       color: #0090de; 
    }
    h2 {
        margin-left: 0px;
    }
</style>
</head>

<div class="header">
    <table style="width: 100%;">
        <tr>
            <td style="color: #fff; vertical-align: top; min-width: 40px; border: 0px solid;">
            </td>
            <td style="color: #fff; text-align: center; width: 100%;">
                <h2>
                    Simple Client Portal (Installation)
                </h2>
            </td>
            <td style="width: 40px; vertical-align: center; text-align: right;">
                <a href="#menu" class="menu-link"><div class="menu-img"></div></a>
            </td>
        </tr>
    </table>
<nav id="menu" class="panel" role="navigation">
    <a href="install.php?section=settings"><div class="menu-item"><img src="images/installer_icons/settings_icon.png">Change Settings</div></a>
    <a href="install.php?section=reset"><div class="menu-item"><img src="images/installer_icons/leave_icon.png">Start Fresh</div></a>
</nav>
<script>
    $(document).ready(function() {
        $('.menu-link').bigSlide();
    });
</script>
</div><BR><BR><BR><BR>
<div class="wrap">    
<?php
class fList {
/**
 *  CONDENSED LICENSE INFO - SEE FULL INFO AT http://www.redbottledesign.com
 *  The absolute_to_relative_path() utility function.
 *  © 2011 RedBottle Design, LLC. All rights reserved.
 *  This source code is free software: you can redistribute it and/or modify
 *  it under the terms of the Lesser GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *  @author Guy Paddock (guy.paddock@redbottledesign.com)
 */
  function absolute_to_relative_path($from_path, $to_path) {
    if (empty($to_path)) {
      throw new InvalidArgumentException('$to_path must not be NULL or empty.');
    }

    if ($to_path[0] !== '/') {
      throw new InvalidArgumentException('$to_path must be an absolute path.');
    }

    if (empty($from_path)) {
      throw new InvalidArgumentException('$from_path must not be NULL or empty.');
    }

    if ($from_path[0] !== '/') {
      throw new InvalidArgumentException('$from_path must be an absolute path.');
    }

    // Trim off trailing slashes for consistency, then turn paths into arrays
    $to_path_parts    = explode('/', rtrim($to_path, '/'));
    $from_path_parts  = explode('/', rtrim($from_path, '/'));

    $common_part_count = 0;

    // Count how many parts the two paths have in common
    for ($i = 0; $i < max(sizeof($to_path_parts), sizeof($from_path_parts)); ++$i) {
      if (isset($to_path_parts[$i]) && isset($from_path_parts[$i])) {
        if ($to_path_parts[$i] == $from_path_parts[$i]) {
          ++$common_part_count;
        }
        else {
          break;
        }
      }

      else {
        break;
      }
    }

    $relative_parts = array();

    // Each part of the "from path" that remains after the common parts has to
    // be replaced with ".." to get back to the common root for both paths.
    if (sizeof($from_path_parts) > $common_part_count) {
      $replacement_count  = sizeof($from_path_parts) - $common_part_count;
      $relative_parts     = array_fill(0, $replacement_count, '..');
    }

     // Each part of the "to path" that remains after the common parts is appended to the relative path.
     
    if (sizeof($to_path_parts) > $common_part_count) {
      $remaining_to_path_parts  = array_slice($to_path_parts, $common_part_count);
      $relative_parts           = array_merge($relative_parts, $remaining_to_path_parts);
    }

    // Turn array back into path string
    return implode('/', $relative_parts);
  }
    
}
$fList = new fList();
?>
<div class="inner">
 
<?php
// ----- Start Reset Section -----
if (isset($_GET['section']) && $_GET['section'] == 'reset'){ ?>
    <div class="wrap-header">
        <h2 style="text-align: center;">Reset</h2>
    </div>
    <div class="welcome">
        This will reset the installer so you can start fresh. The existing config files will be renamed with '.bak' as the filename and you will be taken to the start of the installer. If you are sure you want to do this, please press the button below. Otherwise please select a different option in the menu.
    <BR><BR><BR>
    <form method="post">
        <input type="submit" name="start_fresh" value="Continue">
    </form>
    </div>
<?php
}
    
if (isset($_POST['start_fresh'])){
    $ucm_config_file1 = 'config/ucm_config.php';
    if (file_exists($ucm_config_file1)) {
$timestamp = time();
rename($ucm_config_file1, 'config/ucm_config.php-'.$timestamp.'.bak');
    }
    
    $config_file1 = 'config/config.php';
    if (file_exists($config_file1)) {
$timestamp = time();
rename($config_file1, 'config/config.php-'.$timestamp.'.bak');
    }
    
    if (isset($_GET['section']) && $_GET['section'] == 'reset') {
            echo "<script>window.location = 'install.php'</script>";
        } elseif (!isset($_GET['section'])) {
            echo "<script>window.location = 'install.php'</script>";
        }
}
// ----- End Reset Section -----
?>
    
<?php
// ----- Start Settings Section -----
if (isset($_GET['section']) && $_GET['section'] == 'settings'){
    $ucm_config_file1 = 'config/ucm_config.php';
    if (!file_exists($ucm_config_file1)) {
?>
    <div class="wrap-header">
        <h2 style="text-align: center;">Change Settings</h2>
    </div>
    <div class="welcome">
        If you want to change the settings of a current installation, the config file from UCM is required. <BR>
        <strong>Please select your UCM installation directory on the first page.</strong><BR><BR>
        <strong>NOTE:</strong> This page simply acts as a 'page refresh'. The installer will automatically go to section 2 if the required files are present.
    <BR><BR><BR>
    <form method="post">
        <input type="submit" name="to_start" value="Continue">
    </form>
    </div>
<?php
        if (isset($_POST['to_start'])) {
            echo "<script>window.location = 'install.php'</script>";
        } elseif (!isset($_GET['section'])) {
            echo "<script>window.location = 'install.php'</script>";
        }
    } elseif (file_exists($ucm_config_file1)) {
        if (isset($_GET['section']) && $_GET['section'] == 'settings') {
            echo "<script>window.location = 'install.php?section=2'</script>";
        } elseif (!isset($_GET['section'])) {
            echo "<script>window.location = 'install.php?section=2'</script>";
        }
    }
}
// ----- End Settings Section -----
?>
    
    
<?php   
// ----- Start Section 1 -----
if (!isset($_GET['section'])){ ?>
    
<div class="wrap-header">
    <h2 style="text-align: center;">Part 1/3 - Start Here</h2>
</div>
<div class="left-box" style="text-align: left;">

<h2 style="text-align: center;">UCM Settings</h2><BR>
    <center><strong>Simple Client Portal for UCM requires the <br><a href="http://ultimateclientmanager.com">Ultimate Client Manager</a> to work.</strong></center><BR>
Please use the file browser below to select the directory where UCM is installed and press "Continue" to set up the configuration. <BR><BR>
    When you have located the folder, the box will fill in with the relative location. If you already know where it is you can just type it into the box.
    <BR><BR>It should look something like this: <BR><strong>../sites/UCM</strong>

    </div>
    <div class="right-box">
<?php

  $script = basename(__FILE__); // the name of this script   dirname(__DIR__)
  $path = !empty($_REQUEST['path']) ? $_REQUEST['path'] : dirname(__DIR__); // the path the script should access

  $directories = array();
  $directory_name = array();
  if (is_dir($path)) {
    chdir($path); 
   if ($handle = opendir('.')) {
      while (($item = readdir($handle)) !== false) {
        // Loop through current directory and divide files and directorys
        if(is_dir($item)){
          array_push($directories, realpath($item));
          array_push($directory_name, $item);
        }
          
   /*if ($handle = opendir('.')) {
      while (($item = readdir($handle)) !== false) {
        // Loop through current directory and divide files and directorys
        if(is_dir($item)){
          array_push($directories, realpath($item));
        }*/
        //else
        //{
        //}
      }
   closedir($handle);
   }
    else {
      echo "<p class=\"error\">Directory handle could not be obtained.</p>";
    }
  }
  else
  {
    echo "<p class=\"error\">Path is not a directory</p>";
  }
  echo "<div style='
                    margin: 0 auto;
                    width: 80%;
                    border: 0px solid #909090;
                    background-color: #404040;
                    color: #ffffff;
                    padding: 10px;
                    margin-bottom: 
                    -6px;-webkit-border-top-left-radius: 5px;
                    -webkit-border-top-right-radius: 5px;
                    -moz-border-radius-topleft: 5px;
                    -moz-border-radius-topright: 5px;
                    border-top-left-radius: 5px;
                    border-top-right-radius: 5px;
                    '>";
  echo '<strong>Selected Directory: </strong>' . $path;
  echo "</div>";
  echo "<div class='list-container'>";
    
        $from_path = __DIR__ . "";
        $to_path = realpath('..');
        $up = $fList->absolute_to_relative_path($from_path, $path);
        //if ($up == '..') {
        //echo ($directories != $path) ? "<li>1<a href=\"{$script}?path=" . $directories . "\">asdf</a></li>" : "";
        //} 

    foreach( $directories as $directory ){
        $current = basename(__DIR__);//$fList->absolute_to_relative_path($from_path, $directory);
        //$c = implode('/', $directory);
        //$str = preg_replace('/^.*>\s*/', '', $directory);
        $tokens = explode('/', $directory);
        $str1 = trim(end($tokens));
        echo ($directory == realpath('..')) ? "
        <div class='list-item'>
        <img src='images/installer_icons/install_up_icon.png'>&nbsp;
        <a href=\"{$script}?path={$directory}\">Up one level ({$str1})</a>
        </div>" : "";
        echo ($directory != $path && $directory != realpath($up)) ? "
        <div class='list-item'>
        <img src='images/installer_icons/install_folder_icon.png'>&nbsp;
        <a href=\"{$script}?path={$directory}\">" . $str1 . "</a>
        </div>" : "";
    }
    
        
  echo "</div>";
?>

<?php
$from_path_1 = __DIR__ . "";
$to_path_1 = $path;
echo '<div style="max-width: 600px; margin: 10px auto; padding: 10px; background-color: #f5f5f5;">';
echo '<strong>SCP Directory: </strong>' . $from_path_1;
echo '<BR>'; 
//echo '<strong>Selected Directory: </strong>' . $to_path;
echo '</div>';

$ucm_config = $fList->absolute_to_relative_path($from_path_1, $to_path_1);

?>
    
    <BR>
<div class="welcome">
    <strong>Relative path to your UCM installation</strong>
<form method="post" action="install.php">
    <input type="username" name="ucm_url" value="<?php echo $ucm_config; ?>" style="width: 250px;" />&nbsp;/includes/config.php<BR>
    <input type="submit"  name="get_ucm_url" value="Continue" />
</form>
    </div>
<?php
    if (isset($_POST['get_ucm_url'])) {
        chdir ($from_path_1);
        $ucm_config_file = $_POST['ucm_url'] . '/includes/config.php';
        if (file_exists($ucm_config_file)) {
            copy ($_POST['ucm_url'] . '/includes/config.php', 'config/ucm_config.php');
        } else {
            
            echo '  <div style="text-align: center; color: #fff; margin: 0 auto; 
                    background-color: #b60000; padding: 10px; max-width: 500px;">
                    <strong>There was an error locating the config file.</strong>
                    <br>Please try to select the UCM directory again.</div>'; 
            
        }
    }


$ucm_config_file_local = $from_path . '/config/ucm_config.php';
if (file_exists($ucm_config_file_local)) {
    //require ('config/ucm_config.php');
        if (isset($_GET['section']) && $_GET['section'] < 2) {
            echo "<script>window.location = 'install.php?section=2'</script>";
        } elseif (!isset($_GET['section'])) {
            echo "<script>window.location = 'install.php?section=2'</script>";
        }
} 

}
// --- End Section 1 ---

// --- Start Section 2 ---
if (isset($_GET['section']) && $_GET['section'] == 2) { 
require ('config/ucm_config.php');
?>
<div class="wrap-header">
    <h2 style="text-align: center;">Part 2/3 - Almost done...</h2>
</div>
<div class="left-box" style="text-align: left; padding: 10px;">
<h2 style="text-align: center;">SCP Settings</h2><BR>

Now we have the UCM config file. Most of the settings will be pulled from there. We just need a few more things to get SCP up and running. These settings are used for various things like email notifications and other things throughout the Client Portal.<BR><BR>Please fill out all of the fields. If some things are left blank the config file will still be created but there may be problems in SCP.
    <BR><BR>
<strong>NOTE:</strong> If you are changing the settings of your current installation this will overwrite the existing config file, so please fill out all the necessary fields. 
    <BR><BR>
<span style="color: #b60000;">This page will be improved in the future and some of the information can be condensed or pulled from UCM. For now though, please excuse the messy structure of this page.</span>

</div>
<div class="right-box">
<form method="post" enctype="multipart/form-data">
<ul style="padding: 10px; margin-top: -10px;">
    <strong>Timezone</strong><BR>
    <?php  
    $utc = new DateTimeZone('UTC');
    $dt = new DateTime('now', $utc);

    echo '<select type="dropdown" name="userTimeZone" style="width: 250px;">';
    foreach(DateTimeZone::listIdentifiers() as $tz) {
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
    <strong>What is the url of your UCM installation?</strong>
    <span style="color: #b60000;"> (Required)</span><BR>
    http://<input type="username" name="ucm-url" placeholder="www.example.com/UCM" style="width: 215px;" required/>/<BR>
    <h3>Used for generating links related to UCM such as project files or invoices. Don't include the "http://" or "/" in the url. This is added automatically.</h3>
</ul>
<ul style="padding: 10px;">
    <strong>What is the url of your Client Portal (This Site)?</strong>
    <span style="color: #b60000;"> (Required)</span><BR>
    http://<input type="username" name="base-url" placeholder="www.example.com/SCP" style="width: 215px;" required/>/<BR>
    <h3>This is needed for many links to work properly even if they don't relate to UCM. Don't include the "http://" or "/" in the url. This is added automatically.</h3>
</ul>
<ul style="padding: 10px;">
    <strong>Do you have a primary site to link to?</strong><BR>
    http://<input type="username" name="main-site" placeholder="www.example.com" style="width: 215px;" />/<BR>
    <h3>A quick link back to your main website. Don't include the "http://" or "/" in the url. This is added automatically.</h3>
</ul>
<ul style="padding: 10px;">
    <strong>What should be the title of this site?</strong><BR>
    <input type="username" name="title" value="Client Portal" style="width: 250px;" /><BR>
    <h3>Shown at the top of the browser window.</h3>
</ul>
<ul style="padding: 10px;">
    <strong>Where would you like message notifications sent?</strong><BR>
    <input type="username" name="email" value="notifications@example.com" style="width: 250px;" /><BR>
    <h3>Used to send notifications about messages from a client on project pages. Also shown in error messages.</h3>
</ul>
<ul style="padding: 10px;">
    <strong>What is the name of your company?</strong><BR>
    <input type="username" name="company" placeholder="Widget Corp" style="width: 250px;" /><BR>
    <h3>Used when displaying compnay info on invoices and quotes.</h3>
</ul>
<ul style="padding: 10px;">
    <strong>What is your company phone number?</strong><BR>
    <input type="username" name="phone" placeholder="(555) 555-5555" style="width: 250px;" /><BR>
    <h3>Used when displaying compnay info on invoices and quotes.</h3>
</ul>
<ul style="padding: 10px;">
    <strong>Select a logo image:</strong>
    <input name="file" type="file" /><BR>
    <h3>Used on invoices and quotes. The stock image is about 600 x 400. Its dynamic though so most sizes should work.</h3>
</ul>
<ul style="padding: 10px;">
    <input type="checkbox" name="demo" />
    &nbsp;Is this a Demo installation?<BR>
</ul>
</div>
    <div class="welcome">
    <input type="submit"  name="settings_input" value="Continue" />
    
</form>
</div>

        
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
        if ($_FILES["file"]["error"] > 0)
           {echo "Error: " . $_FILES["file"]["error"] . "<br>";
        } else {
            //echo "Stored file:".$_FILES["file"]["name"]."<br/>Size:".($_FILES["file"]["size"]/1024)." kB<br/>";
            move_uploaded_file($_FILES["file"]["tmp_name"],'images/' . $_FILES["file"]["name"]);
            $logo_img = $_FILES["file"]["name"];
           }
    } 
        
    if ($logo_img == ''){
        $logo_img = 'sample-logo.png';
    }
           
    $db_name = constant('_DB_NAME');
    $db_user = constant('_DB_USER');
    $db_password = constant('_DB_PASS');
    $db_host = constant('_DB_SERVER');
    $db_prefix = constant('_DB_PREFIX');
    
    $secret = constant('_UCM_SECRET');
    
    $ucm_url = 'http://' . $_POST['ucm-url'] . '/';
    $base_url = 'http://' . $_POST['base-url'] . '/';
    $site_title = $_POST['title'];
    $main_site = 'http://' . $_POST['main-site'] . '/';
    $system_email = $_POST['email'];
    $company_name = $_POST['company'];
    $phone = $_POST['phone'];
        
if (isset($_POST['userTimeZone'])) {
    $time_zone = $_POST['userTimeZone'];
} else {
    $time_zone = 'America/New_York';
}
    
    if (isset($_POST['demo'])) {
        $demo_mode = 'on';
    } else {
        $demo_mode = 'off';
    }
        
    $demo_client_email = $_POST['demo_client_email'];
    $demo_client_pass = $_POST['demo_client_pass'];
    $demo_staff_email = $_POST['demo_staff_email'];
    $demo_staff_pass = $_POST['demo_staff_pass'];
    $demo_admin_email = $_POST['demo_admin_email'];
    $demo_admin_pass = $_POST['demo_admin_pass'];
        
        
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
define("LOGO_IMG", "images/' . $logo_img . '");

// Demo mode settings
define("DEMO_MODE", "' . $demo_mode . '");

?>
');
        
        
        if (isset($_GET['section']) && $_GET['section'] < 2.5) {
            echo "<script>window.location = 'install.php?section=2.5'</script>";
        } elseif (!isset($_GET['section'])) {
            echo "<script>window.location = 'install.php?section=2.5'</script>";
        }
    }
    
}
// --- End Section 2 ---

// --- Start Section 3 ---





if (isset($_GET['section']) && $_GET['section'] == 2.5) { 
    $scp_config = 'config/config.php';
    if (file_exists($scp_config)) {
        require_once('config/config.php');
        if (constant('DEMO_MODE') == 'on') {
?>
<div class="wrap-header">
    <h2 style="text-align: center;">Almost done... Really this time</h2>
</div>
<div class="left-box" style="text-align: left;">
<div style="max-width: 600px; margin: 10px auto;">
<h2 style="text-align: center;">Demo Settings</h2><BR>
One more little thing... Since this is a demo, there is an overlay on the login page that lists login credentials for a client and a staff member. Please set these users up in UCM and enter their information here.<BR><BR>

<strong>More information about 'Demo Mode'</strong><BR>
    Demo mode disables emails and profile changes. It also puts up messages about various things, such as the overlay on the login page or notifications about the disabled functionalities. It is intended for educational purposes and should let people log in and see how the system works without needing to be an actual client.
</div>
</div>
<div class="right-box">
<form method="post">

</ul>
<ul style="padding: 10px;">
    <strong>Client Username</strong><BR>
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
<ul style="padding: 10px;">
    <strong>Admin Username</strong><BR>
    <input type="username" name="admin_email" placeholder="admin@example.com" style="width: 250px;" /><BR>
</ul>
<ul style="padding: 10px;">
    <strong>Admin Password</strong><BR>
    <input type="password" name="admin_pass" placeholder="password" style="width: 250px;" /><BR>
</ul>

</div>
    <div class="welcome">
    <input type="submit"  name="demo_settings_input" value="Continue" />
    
</form>
</div>
    <?php
if (isset($_POST['demo_settings_input'])) {

    $d_client_email = $_POST['client_email'];
    $d_client_pass = $_POST['client_pass'];
    $d_staff_email = $_POST['staff_email'];
    $d_staff_pass = $_POST['staff_pass'];
    $d_admin_email = $_POST['admin_email'];
    $d_admin_pass = $_POST['admin_pass'];
    
    $data = '<?php

define("DEMO_CLIENT_EMAIL", "' . $d_client_email . '");
define("DEMO_CLIENT_PASS", "' . $d_client_pass . '");
define("DEMO_STAFF_EMAIL", "' . $d_staff_email . '");
define("DEMO_STAFF_PASS", "' . $d_staff_pass . '");
define("DEMO_ADMIN_EMAIL", "' . $d_admin_email . '");
define("DEMO_ADMIN_PASS", "' . $d_admin_pass . '");

?>
';

file_put_contents('config/config.php', $data, FILE_APPEND);
    
    if (isset($_GET['section']) && $_GET['section'] < 3) {
            echo "<script>window.location = 'install.php?section=3'</script>";
        } elseif (!isset($_GET['section'])) {
            echo "<script>window.location = 'install.php?section=3'</script>";
        }
    
}
} else {
        
        if (isset($_GET['section']) && $_GET['section'] < 3) {
            echo "<script>window.location = 'install.php?section=3'</script>";
        } elseif (!isset($_GET['section'])) {
            echo "<script>window.location = 'install.php?section=3'</script>";
        }
}
        } else { ?>
        <div class="welcome">
            <h2>Oh No! There was an error...</h2>
            There was an error creating the config file. Please try the instalation again.
        </div>
    <?php
    }
    
}




// --- End Section 2.5 ---
   
// --- Start Section 3 ---

if (isset($_GET['section']) && $_GET['section'] == 3) {
    $scp_config = 'config/config.php';
    if (file_exists($scp_config)) {
        require ('config/config.php'); ?>
        <div class="wrap-header">
            <h2 style="text-align: center;">All Finished!</h2>
        </div>
        <div style="max-width: 600px; margin: 10px auto;">
            Now that you're finished with configuration, please press the button below to go to your new Client Portal site.
            <BR><BR>
                <center>
            <strong>Caution</strong>
                </center>
                It is recommended that you delete this installer (install.php) when you are finished for security purposes. If you don't, anyone could go to your site (eg: www.yoursite.com/clients/install.php) and re-run this file.
            <br>
    <?php if (constant('DEMO_MODE') == 'on') { ?>
            <BR><strong>NOTE:</strong> This installation was set up as a Demo. You can change this at any time by running the setup again and unchecking the "Demo" checkbox. You will need to fill out the other fields again as well.
    <?php } ?>
            <BR><BR>
            <div class="welcome">
                <img src="<?php echo constant('LOGO_IMG'); ?>" style="max-width: 300px; margin: 10px auto;">
            <form action="index.php" method="get">
                <input type="submit" value="Go to my new site!" name="Submit" />
            </form>
            </div>
        </div>
    <?php
    } else { ?>
        <div class="welcome">
            <h2>Oh No! There was an error...</h2>
            There was an error creating the config file. Please try the instalation again.
        </div>
    <?php
    }
}

// --- End Section 3 ---
?>
    
    
    
</html>