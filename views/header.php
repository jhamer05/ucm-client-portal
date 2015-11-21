<?php
/*
 * Simple Client Portal for UCM
 * http://jquery.com/
 *
 * Copyright © 2014 JCH Design, LLC
 * Dual licensed under the MIT and GPL licenses.
 * http://jchdesign.com/simple-client-portal/
 *
 * Date: 2014-11-07 (Fri, 07 Nov 2014)
 * Version: 0.1
 */
?>

<?php
    //require_once('css/style.php');
    require_once('config/config.php');
    require_once('classes/Controller.php');
    // Previously used as a workaround. May be causeing problems. Requires PHP 5.4+.
    //if (session_status() == PHP_SESSION_NONE) {
    //    session_start();
    //}
?>
<!-- <head> -->

	<meta charset="UTF-8" />
    <title><?php echo constant('SITE_TITLE'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- Use JQuery 1.x for older browsers. 2.x is faster. -->
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/mobile.css">
	<link rel="stylesheet" href="custom/custom.css">
	<script src="js/post.js"></script>
	<script src="js/tabs.js"></script>
	<script src="js/pagefade.js"></script>
	<script src="js/menu.js"></script>
	<script src="js/featherlight.js"></script><!-- </head> -->
<div class="header">
<?php
if(!class_exists('Login')){ include ('classes/Login.php'); }
$login = new Login();
$Controller = new Controller();
?>
<?php if ($login->isUserLoggedIn() == true) { ?>
<!-- <div class="header"> -->
    <table style="width: 100%;">
        <tr>
            <td class="header-text" style="vertical-align: top; width: 50%;">
                <a href="index.php?page=profile">
                <div class="header-avatar">
                    <img src="<?php echo $Controller->avatar($_SESSION['email'], '80px'); ?>" alt="avatar">        
                    </div></a><span class="header-text" style="font-size: 12px;">
                <?php
    $user_id = $_SESSION['user_id'];
    $user_info_query = $Controller->get_user_info($user_id);
    $user_info = $user_info_query->fetch_assoc();                        
                ?>
                Hello, <BR><?php echo $user_info['name']; ?>.</span>
            </td>
            <td class='customer-name-header header-text' style="vertical-align: center; text-align: right; width: 100%;"> 
        <?php   if (isset($_SESSION['customer_id'])) { ?>
                
    <?php $customer_query = $Controller->get_customer_info(); ?>
    <?php $num_results = $customer_query->num_rows; ?>
    <?php if( $num_results > 0){ ?>
    <?php $row = $customer_query->fetch_assoc(); ?>
                <?php
                    echo "<span class='customer-name-header header-text'>";
                    echo $row['customer_name'];
                    echo "&nbsp;</span>";
                ?>
            <?php } ?>
        <?php } ?>
                
            </td>
            <td class="list-large-screen" style="width: 40px; vertical-align: center; text-align: right;">
                <div class="home-button" style="text-align: right;">
                    <a href="index.php"><img src="images/icons/home_icon.png"></a>
                </div>
            </td>
            <td style="width: 40px; vertical-align: center; text-align: right;">
                <a href="#menu" class="menu-link"><div class="menu-img"></div></a>
            </td>
        </tr>
    </table>
</div>

<nav id="menu" class="panel" role="navigation">
    <a href="index.php"><div class="menu-item">
        <img src="images/icons/home_icon.png">Home</div></a>
    <a href="index.php?tab_id=1"><div class="menu-item">
        <img src="images/icons/quote_icon.png">Quotes</div></a>
    <a href="index.php?tab_id=2"><div class="menu-item">
        <img src="images/icons/project_icon.png">Projects</div></a>
    <a href="index.php?tab_id=3"><div class="menu-item">
        <img src="images/icons/invoice_icon.png">Invoices</div></a>
    <a href="<?php echo MAIN_SITE; ?>"><div class="menu-item">
        <img src="images/icons/leave_icon.png">Main Site</div></a>
<!-- Still working on a contact page. Not necisary right now.   May come later as part of the ticketing system. -->
<!-- <a href="index.php?page=contact"><div class="menu-item"><img src="images/email_icon.png">Contact</div></a> -->
<!-- STAFF TOOLS -->
    
    <?php if (file_exists('custom/options-config.php')) {
        require_once('custom/options-config.php');  ?>
    <?php if (constant('STAFF_TOOLS') == 'on' && $_SESSION['is_staff'] == 1) { ?>
    <a href="index.php?page=staff"><div class="menu-item">
        <img src="images/icons/tools_icon.png">Staff Tools</div></a>
    <?php } } ?>
    
    
    <?php if ($_SESSION['user_id'] == 1) {?>
    <a href="index.php?page=admin"><div class="menu-item">
        <img src="images/icons/settings_icon.png">Admin / Settings</div></a>
    <?php } ?>
    <a href="index.php?logout"><div class="menu-item">
        <img src="images/icons/logout_icon.png">Logout</div></a>
</nav>
<script>
    $(document).ready(function() {
        $('.menu-link').bigSlide();
    });
</script>
<!-- Don't need now that there is a profile page
<div class="front-info">
<h3>Avatar imgages are pulled from <a href="http://gravatar.com">Gravatar.com</a></h3> 
</div>-->

<?php } else { ?>
<!-- <div class="header"> -->
    <a href="<?php echo MAIN_SITE; ?>"><img src="images/icons/leave_icon.png" style="width: 40px;"></a>
</div>
<?php 
if (constant('DEMO_MODE') == 'on') {
    include ('demo-login.php');
    } ?>
<BR>
<?php } ?>
