<BR>
<?php if ($_SESSION['user_id'] == 1) { ?>
<?php
if (file_exists('custom/options-config.php')) {
    require_once('custom/options-config.php');
} else {
    copy ('views/admin/default-options.php', 'custom/options-config.php');
    require_once('custom/options-config.php');
}
?>

<?php if (file_exists('custom/options-config.php')) { ?>

<form method="post">
    

<?php // ------ Welcome Message Checkbox ------ // ?>
<input type="checkbox" id="welcomeCheckbox" name="display_welcome_message" value="yes" 
       <?php 
            if (constant('DISPLAY_WELCOME_MESSAGE') == 'yes') {
                echo 'checked';
            }?> 
       > Show Welcome Message<BR>
<script>
$(document).ready(function () {
     $('#welcomeCheckbox').click(function () {
         var $this = $(this);
         if ($this.is(':checked')) {
             $('#welcomeOptions').fadeIn();
             $('#welcomeOptions').show();
         } else {
             $('#welcomeOptions').fadeIn();
             $('#welcomeOptions').hide();
         }
     });
 });    
</script>
<div id="welcomeOptions" style="display: none;">
<BR>

<table style="width: 100%; border: 1px solid;">
    <tr class="wrap-header"><td style="padding: 2px;">
<h2 class="wrap-title" style="font-size: 18px; text-align: left;">WELCOME MESSAGE:</h2>
    </td></tr>
    <tr><td style="padding: 2px;">
<div style="text-align: center;">
    Title:<BR>
<input type="username" style="width: 80%; text-align: center;" 
       name="welcome_title" value="<?php echo constant('WELCOME_TITLE') ?>"><BR>
    Message:
<textarea name="welcome_message"><?php echo constant('WELCOME_MESSAGE') ?></textarea>
</div>
    </td></tr>
</table>
</div>
    
    
<BR>
    
<?php // ------ Footer Checkbox ------ // ?>
<input type="checkbox" id="footerCheckbox" name="display_footer" value="yes"
       <?php 
            if (constant('DISPLAY_FOOTER') == 'yes') {
                echo 'checked';
            }?> 
       > Enable Footer<BR>
<script>
$(document).ready(function () {
     $('#footerCheckbox').click(function () {
         var $this = $(this);
         if ($this.is(':checked')) {
             $('#footerOptions').fadeIn();
             $('#footerOptions').show();
         } else {
             $('#footerOptions').fadeIn();
             $('#footerOptions').hide();
         }
     });
 });    
</script>
<div id="footerOptions" style="display: none;">
<BR>
<table style="width: 100%; border: 1px solid;">
    <tr class="wrap-header"><td style="padding: 2px;">
<h2 class="wrap-title" style="font-size: 18px; text-align: left;">FOOTER:</h2>
    </td></tr>
    <tr><td style="padding: 2px;">
        
    <table style="width: 100%; margin: 0 auto;">
        <tr>
            <td>
                <div style="padding: 10px;">
            Colors:
                </div>
            </td>
            <td>
            </td>
        </tr><tr>
            <td style="width: 50%; text-align: center;">
Footer Color<BR>
<input class="color" name="footer_bg" 
       value="<?php echo constant('FOOTER_BG'); ?>"> 
            </td>
            <td style="width: 50%; text-align: center;">
Footer Text Color<BR>
<input class="color" name="footer_text" 
       value="<?php echo constant('FOOTER_TEXT'); ?>"> 
            </td>
        </tr>
    </table>
<HR style="margin-bottom: 8px;">
    <table style="width: 100%; margin: 0 auto;">
        <tr>
            <td>
                <div style="padding: 10px;">
            Copyright Info:
                </div>
            </td>
            <td>
            </td>
            <td>
                Below Custom Boxes?
                <input type="checkbox" id="copyrightCheckbox" name="copyright_position_below" value="yes" 
                       <?php 
                            if (constant('COPYRIGHT_POSITION_BELOW') == 'yes') {
                                echo 'checked';
                            }?> >
            </td>
        </tr><tr>
            <td style="width: 33%; text-align: center;">
    Left<BR>
    <input type="radio" name="copyright_position" value="left" style="margin-bottom: 8px;">
            </td>
            <td style="width: 33%; text-align: center;">
    Center<BR>
    <input type="radio" name="copyright_position" value="center" style="margin-bottom: 8px;">
            </td>
            <td style="width: 33%; text-align: center;">
    Right<BR>
    <input type="radio" name="copyright_position" value="right" style="margin-bottom: 8px;">
            </td>
        </tr>
    </table>   
<center>
<input type="username" name="copyright_message" value="<?php echo constant('COPYRIGHT_MESSAGE') ?>">
</center>
    <HR>
    <table style="width: 100%; margin: 0 auto;">
        <tr>
            <td>
                <div style="padding: 10px;">
            Custom Content #1:
                </div>
            </td>
            <td>
            </td>
        </tr><tr>
            <td style="width: 33%; text-align: center;">
    Left<BR>
    <input type="radio" name="footer_custom_1_position" value="left" style="margin-bottom: 8px;">
            </td>
            <td style="width: 33%; text-align: center;">
    Center<BR>
    <input type="radio" name="footer_custom_1_position" value="center" style="margin-bottom: 8px;">
            </td>
            <td style="width: 33%; text-align: center;">
    Right<BR>
    <input type="radio" name="footer_custom_1_position" value="right" style="margin-bottom: 8px;">
            </td>
        </tr>
    </table>
<textarea name="footer_custom_1"><?php echo constant('FOOTER_CUSTOM_1') ?></textarea>        
<HR>
    <table style="width: 100%; margin: 0 auto;">
        <tr>
            <td>
                <div style="padding: 10px;">
            Custom Content #2:
                </div>
            </td>
            <td>
            </td>
        </tr><tr>
            <td style="width: 33%; text-align: center;">
    Left<BR>
    <input type="radio" name="footer_custom_2_position" value="left" style="margin-bottom: 8px;">
            </td>
            <td style="width: 33%; text-align: center;">
    Center<BR>
    <input type="radio" name="footer_custom_2_position" value="center" style="margin-bottom: 8px;">
            </td>
            <td style="width: 33%; text-align: center;">
    Right<BR>
    <input type="radio" name="footer_custom_2_position" value="right" style="margin-bottom: 8px;">
            </td>
        </tr>
    </table>
<textarea name="footer_custom_2"><?php echo constant('FOOTER_CUSTOM_2') ?></textarea>        
<HR>
    <table style="width: 100%; margin: 0 auto;">
        <tr>
            <td>
                <div style="padding: 10px;">
            Custom Content #3:
                </div>
            </td>
            <td>
            </td>
        </tr><tr>
            <td style="width: 33%; text-align: center;">
    Left<BR>
    <input type="radio" name="footer_custom_3_position" value="left" style="margin-bottom: 8px;">
            </td>
            <td style="width: 33%; text-align: center;">
    Center<BR>
    <input type="radio" name="footer_custom_3_position" value="center" style="margin-bottom: 8px;">
            </td>
            <td style="width: 33%; text-align: center;">
    Right<BR>
    <input type="radio" name="footer_custom_3_position" value="right" style="margin-bottom: 8px;">
            </td>
        </tr>
    </table>
<textarea name="footer_custom_3"><?php echo constant('FOOTER_CUSTOM_3') ?></textarea>        

        
    </td></tr>
</table>
       <!-- <hr style="margin: 10px;"> -->
    
</div>
<BR>
    
<?php // ------ Staff Tools Checkbox ------ // ?>
<input type="checkbox" id="staffToolsCheckbox" name="staff_tools" value="on" 
       <?php 
            if (constant('STAFF_TOOLS') == 'on') {
                echo 'checked';
            }?> 
       > Enable Staff Tools (Experimental)<BR>
<script>
$(document).ready(function () {
     $('#staffToolsCheckbox').click(function () {
         var $this = $(this);
         if ($this.is(':checked')) {
             $('#staffToolsOptions').fadeIn();
             $('#staffToolsOptions').show();
         } else {
             $('#staffToolsOptions').fadeIn();
             $('#staffToolsOptions').hide();
         }
     });
 });    
</script>
<div id="staffToolsOptions" style="display: none;">
<BR>
    <table style="width: 100%; border: 1px solid;">
    <tr class="wrap-header"><td style="padding: 2px;">
<h2 class="wrap-title" style="font-size: 18px; text-align: left;">STAFF TOOLS (Experimental):</h2>
    </td></tr>
    <tr><td style="padding: 2px;">
        
    <div class="welcome" style="border: 2px solid;">
    <strong>!WARNING!</strong><BR>
        This feature is not yet complete. Things may be broken or features missing. This is currently a preview of things to come and is missing most of the upcoming functionality.
    </div>
    <BR>
    This will add a new item in the main menu accesible by staff members. It is a section for staff members to gain access to various tools such as a task timer and the ability to edit quotes, send messages, reset passwords, etc.<BR> <BR>
        <center>
        <img src="views/admin/themes/previews/staff-tools-preview.jpg" width="90%" style="margin: 0 auto;">
        </center>    
        
    </td></tr>
</table>
</div>
<BR>

    
<?php // ------ Project Sharing Checkbox ------ // ?>
<input type="checkbox" id="ProjectSharingCheckbox" name="project_sharing" value="on" 
       <?php 
            if (defined('PROJECT_SHARING') && constant('PROJECT_SHARING') == 'on') {
                echo 'checked';
            }?> 
       > Enable Project Sharing?<BR>
<script>
$(document).ready(function () {
     $('#ProjectSharingCheckbox').click(function () {
         var $this = $(this);
         if ($this.is(':checked')) {
             $('#ProjectSharingOptions').fadeIn();
             $('#ProjectSharingOptions').show();
         } else {
             $('#ProjectSharingOptions').fadeIn();
             $('#ProjectSharingOptions').hide();
         }
     });
 });    
</script>
<div id="ProjectSharingOptions" style="display: none;">
<BR>
    <table style="width: 100%; border: 1px solid;">
    <tr class="wrap-header"><td style="padding: 2px;">
<h2 class="wrap-title" style="font-size: 18px; text-align: left;">PROJECT SHARING:</h2>
    </td></tr>
    <tr><td style="padding: 2px;">

    <div class="welcome" style="border: 2px solid; text-align: center;">
    <strong>!WARNING!</strong><BR>
        <p style='text-align: left;'>
        This Feature will write a new column to the database. This will not affect UCM and should not cause any problems with it. The new column contains a list of numbers for special access to shared projects. It also effectively gives clients the ability to create new (though limited) users.<BR><BR>
        More information can be found on <a href="http://ucmclientportal.com/">UCMClientPortal.com</a>.<BR>
        </p>
    </div>
    <BR>
    This option adds a field to the bottom of each project page that clients can use to invite others to view the project. If the person invited doesn't have an account, a new one will be created. They will only have access to the shared project and will not be able to see the rest of your client's projects.<BR> <BR>
        <center>
        <img src="views/admin/themes/previews/invite-preview.jpg" width="90%">
        </center>
        
    </td></tr>
</table>

</div>
<BR>
    
    
<center>
<input type="submit" name="options_submit" value="Submit">
</center>
</form>

<?php
if (isset($_POST['options_submit'])) {

if (isset($_POST['display_welcome_message'])) {        
    $display_welcome_message = $_POST['display_welcome_message'];
} else {
    $display_welcome_message = 'no';
} 
if (isset($_POST['welcome_title']) && $_POST['welcome_title'] != '') {        
    $welcome_title = $_POST['welcome_title'];
} else {
    $welcome_title = 'Welcome to the Client Portal';
}     
if (isset($_POST['welcome_message']) && $_POST['welcome_message'] != '') {   
    $welcome_message = htmlspecialchars($_POST['welcome_message'], ENT_QUOTES);
    //$welcome_message = $_POST['welcome_message'];
} else {
    $welcome_message = 'This is a place where you can view and comment of the progress of your projects.';
}     
    
// Footer Settings
if (isset($_POST['display_footer'])) {        
    $display_footer = $_POST['display_footer'];
} else {
    $display_footer = 'no';
}         
if (isset($_POST['footer_bg'])) {        
    $footer_bg = $_POST['footer_bg'];
} else {
    $footer_bg = '404040';
}         
if (isset($_POST['footer_text'])) {        
    $footer_text = $_POST['footer_text'];
} else {
    $footer_text = 'f5f5f5';
}     
    
// Footer Copyright Info
if (isset($_POST['copyright_position'])) {        
    $copyright_position = $_POST['copyright_position'];
} elseif (defined('COPYRIGHT_POSITION')) {
    $copyright_position = constant('COPYRIGHT_POSITION');  
} else {
    $copyright_position = 'left';
}   
if (isset($_POST['copyright_position_below'])) {        
    $copyright_position_below = $_POST['copyright_position_below'];
} else {
    $copyright_position_below = 'no';
}
if (isset($_POST['copyright_message']) && $_POST['copyright_message'] != '') {        
    $copyright_message = $_POST['copyright_message'];
} else {
    $copyright_message = 'Copyright &copy; 2014 JCH Design, LLC';
}

// Custom Footer Content #1
if (isset($_POST['footer_custom_1_position'])) {        
    $footer_custom_1_position = $_POST['footer_custom_1_position'];
} elseif (defined('FOOTER_CUSTOM_1_POSITION')) {
    $footer_custom_1_position = constant('FOOTER_CUSTOM_1_POSITION');  
} else {
    $footer_custom_1_position = 'left';
}   
if (isset($_POST['footer_custom_1']) && $_POST['footer_custom_1'] != '') {        
    $footer_custom_1 = htmlspecialchars($_POST['footer_custom_1'], ENT_QUOTES);
} else {
    $footer_custom_1 = '';
}

// Custom Footer Content #2
if (isset($_POST['footer_custom_2_position'])) {        
    $footer_custom_2_position = $_POST['footer_custom_2_position'];
} elseif (defined('FOOTER_CUSTOM_2_POSITION')) {
    $footer_custom_2_position = constant('FOOTER_CUSTOM_2_POSITION');  
} else {
    $footer_custom_2_position = 'center';
}   
if (isset($_POST['footer_custom_2']) && $_POST['footer_custom_2'] != '') {        
    $footer_custom_2 = htmlspecialchars($_POST['footer_custom_2'], ENT_QUOTES);
} else {
    $footer_custom_2 = '';
}
 
// Custom Footer Content #3
if (isset($_POST['footer_custom_3_position'])) {        
    $footer_custom_3_position = $_POST['footer_custom_3_position'];
} elseif (defined('FOOTER_CUSTOM_3_POSITION')) {
    $footer_custom_3_position = constant('FOOTER_CUSTOM_3_POSITION');  
} else {
    $footer_custom_3_position = 'right';
}   
if (isset($_POST['footer_custom_3']) && $_POST['footer_custom_3'] != '') {        
    $footer_custom_3 = htmlspecialchars($_POST['footer_custom_3'], ENT_QUOTES);
} else {
    $footer_custom_3 = '';
}

                                
if (isset($_POST['staff_tools'])) {        
    $staff_tools = $_POST['staff_tools'];
} else {
    $staff_tools = 'off';
}     
    
if (isset($_POST['project_sharing'])) {        
    $project_sharing = $_POST['project_sharing'];
} else {
    $project_sharing = 'off';
}
                               
if (constant('DEMO_MODE') != 'on') {
file_put_contents('custom/options-config.php', '<?php

define("DISPLAY_WELCOME_MESSAGE", "' . $display_welcome_message . '");
define("WELCOME_TITLE", "' . $welcome_title . '");
define("WELCOME_MESSAGE", "' . $welcome_message . '");

define("DISPLAY_FOOTER", "' . $display_footer . '");
define("FOOTER_BG", "' . $footer_bg . '");
define("FOOTER_TEXT", "' . $footer_text . '");
define("COPYRIGHT_POSITION", "' . $copyright_position . '");
define("COPYRIGHT_MESSAGE", "' . $copyright_message . '");
define("COPYRIGHT_POSITION_BELOW", "' . $copyright_position_below . '");

define("FOOTER_CUSTOM_1_POSITION", "' . $footer_custom_1_position . '");
define("FOOTER_CUSTOM_1", "' . $footer_custom_1 . '");
define("FOOTER_CUSTOM_2_POSITION", "' . $footer_custom_2_position . '");
define("FOOTER_CUSTOM_2", "' . $footer_custom_2 . '");
define("FOOTER_CUSTOM_3_POSITION", "' . $footer_custom_3_position . '");
define("FOOTER_CUSTOM_3", "' . $footer_custom_3 . '");

define("STAFF_TOOLS", "' . $staff_tools . '");
define("PROJECT_SHARING", "' . $project_sharing . '");

?>
');
}
    
}
    
    
?>



<?php
}
                                                    
} else {
?>
<div class="wrap-header">
    <h2 class="wrap-title">Admin</h2>
</div>
<div class="welcome">
    <h2 style="text-align: center;">Please log in as the administrator</h2>
    This page controls various system settings. It is only usable by the system administrator. Please log in as the admin to continue.
    
</div>



<?php } ?>