<?php
session_start();
$config_file = 'config/config.php';
if (file_exists($config_file)) {
?>
<div class="page-row">
<?php include("views/header.php"); ?>
</div>
<!-- <div style="min-height: 80%; position: relative; padding-right: 5px; padding-left: 5px;"> -->
<div class="page-row page-row-expanded"> <!--style="padding-right: 5px; padding-left: 5px;"> -->
<?php
/*
 * Simple Client Portal for UCM
 * http://jquery.com/
 *
 * Copyright © 2014 JCH Design, LLC
 * Dual licensed under the MIT and GPL licenses.
 * http://jchdesign.com/simple-client-portal/
 *
 * Date: 2014-11-11 (Tue, 11 Nov 2014)
 * Version: 0.2
 */

//I'm not done testing yet. Will incluede this function later
// checking for minimum PHP version
/*
if (version_compare(PHP_VERSION, '5.4.34', '<')) {
    exit("Sorry, but your PHP instalation is too old! Please update to PHP 5.4.34 or higher");
} else if (version_compare(PHP_VERSION, '5.6.0', '<')) {
    print "This was built and tested on PHP 5.6.0RC2 in an attempt at forward compatibility.<BR>It 'should' work on 5.5 without any problems. 5.4 is solid but the further back you go, the less likely it will work fully. Just update though...";
}
*/
?>
<div style="border: 0px solid; margin-top: 50px;"> <!-- style="padding: 5px;"> -->

<?php   if (isset($_SESSION['customer_id'])) { ?>
                
    <?php $customer_query = $Controller->get_customer_info(); ?>
    <?php $num_results = $customer_query->num_rows; ?>
    <?php if( $num_results > 0){ ?>
    <?php $row = $customer_query->fetch_assoc(); ?>

        <?php 
            if ($row['credit'] > 0) {
                echo '<div class="account-status">';
                echo "You have <font style='color: #00b600; font-weight: 600;'>$";
                echo $row['credit'];
                echo "</font>&nbsp of credit on your account.<BR>";
                echo '</div>';
            }
            if ($row['total_due'] > 0) {
                echo '<div class="account-status">';
                echo "You still owe <font style='color: #d00000; font-weight: 600;'>$";
                echo $row['total_due'];
                echo ".</font> Please check your <a href='index.php?tab_id=3'>Invoices</a>.<BR>";
                echo '</div>';
            }
            if (file_exists('custom/style-config.php')) {
                require_once('custom/style-config.php');
                if (defined('WRAP_WIDTH') && constant('WRAP_WIDTH') == '100%') {
                    $full_width = 'true';
                } else {
                    $full_width = 'false';
                }
            } else {
                $full_width = 'false';
            }
            
            if ($row['total_due'] <= 0 && $row['credit'] <= 0 && $full_width == 'false') {
                echo '<div class="account-status list-large-screen">';
                echo '</div>';
            }
    
    ?>

    <?php } ?>
<?php } ?>

<div class="wrap">
<?php
if ($login->isUserLoggedIn() == true) {
    $user_id = $_SESSION['user_id'];
    $user_info_query = $Controller->get_user_info($user_id);
    $user_info = $user_info_query->fetch_assoc();
}
if ($login->isUserLoggedIn() == true) {
    if (($user_info['name'] == '' || $user_info['last_name'] == '') && $_SESSION['user_id'] != '1') {
        include('views/new-user-setup.php');
    } else {
// Start logged in in view
?><div class="tab-content"><?php
    if (isset($_GET['project_id']) && !isset($_GET['page'])) {
        include('views/project.php');
    } elseif (isset($_GET['invoice_id']) && !isset($_GET['page'])) {
        include('views/invoice.php');
    } elseif (isset($_GET['quote_id']) && !isset($_GET['page'])) {
        include('views/quote.php');
    } elseif (isset($_GET['page']) && $_GET['page'] == 'contact') { 
                include("classes/post-notification.php");
    } elseif (isset($_GET['page']) && $_GET['page'] == 'profile') { 
                include("views/profile.php");
    } elseif (isset($_GET['page']) && $_GET['page'] == 'admin') { 
                include("views/admin.php");
    } elseif (isset($_GET['page']) && $_GET['page'] == 'css-write') { 
                include("views/admin/custom-css-write.php");
    } elseif (isset($_GET['page']) && $_GET['page'] == 'staff') { 
                include("views/staff-tools.php");
    } elseif (isset($_GET['page']) && $_GET['page'] == 'send') { 
                include("classes/quote-message.php");
    } elseif (isset($_GET['page']) && $_GET['page'] == 'invite-user') { 
                include("views/invite-user.php");
    //} elseif (isset($_GET['page']) && $_GET['page'] == 'user-update') { 
    //            include("classes/user-info-update-message.php");
    } elseif (isset($_GET['page']) && $_GET['page'] == 'login-select') { 
        include("views/login-select.php");
        
    } else { ?>

<div class="wrap-header">
<h2 class="wrap-title">Dashboard</h2>
</div>
<div class='welcome'>
<?php if (file_exists('custom/options-config.php')) {
        require_once('custom/options-config.php');
        if (constant('DISPLAY_WELCOME_MESSAGE') == 'yes') {
            echo  '<h2>' . constant('WELCOME_TITLE') . '</h2>';
            echo constant('WELCOME_MESSAGE');
        }
    } else { ?>
    <h2>Welcome to the Client Portal</h2> This is a place where you can view and comment of the progress of your projects.
    <?php } ?>
</div>
<div class="tabs">
    <ul class="tab-links">
        <li>
        <?php $quote_query = $Controller->quote_list(); ?>
        <?php $num_results1 = $quote_query->num_rows; ?>
        <?php if( $num_results1 > 0){ ?>
            <?php
            if (isset($_GET['tab_id']) && $_GET['tab_id'] == 1) { 
                echo "<li class='active'>"; 
            } elseif (!isset($_GET['tab_id'])) { 
                echo "<li >"; 
            } else { 
                echo "<li>"; }
            ?>
        <a href="#tab1">Quotes</a></li>
        <?php } ?>
        <?php
            if (isset($_GET['tab_id']) && $_GET['tab_id'] == 2) { 
                echo "<li class='active'>"; 
            } elseif (!isset($_GET['tab_id'])) { 
            echo "<li class='active'>"; 
            } else { 
                echo "<li>"; }
            ?>
        <a href="#tab2">Projects</a></li>
        <?php $invoice_query = $Controller->invoice_list(); ?>
        <?php $num_results2 = $invoice_query->num_rows; ?>
        <?php if( $num_results2 > 0){ ?>
        <?php
            if (isset($_GET['tab_id']) && $_GET['tab_id'] == 3) { 
                echo "<li class='active'>"; 
            } else { 
                echo "<li>"; }
            ?>
        <a href="#tab3">Invoices</a></li>
        <?php } ?>
    </ul>
 
    <div class="tab-content">
        <?php $quote_query = $Controller->quote_list(); ?>
        <?php $num_results3 = $quote_query->num_rows; ?>
        <?php if( $num_results3 > 0){ ?>
        <?php
            if (isset($_GET['tab_id']) && $_GET['tab_id'] == 1) { 
                echo "<div id='tab1' class='tab active'>"; 
                include('views/quotes.php');
                echo '</div>';
            } elseif (!isset($_GET['tab_id'])) { 
                echo "<div id='tab1' class='tab'>";
                include('views/quotes.php');
                echo '</div>';
            } else { 
                echo "<div id='tab1' class='tab'>"; 
                include('views/quotes.php');
                echo '</div>';
            }
            ?>
        <?php } ?>
        <?php
            if (isset($_GET['tab_id']) && $_GET['tab_id'] == 2) { 
                echo "<div id='tab2' class='tab active'>"; 
                include('views/projects.php');
                echo '</div>';
            } elseif (!isset($_GET['tab_id'])) { 
                echo "<div id='tab2' class='tab active'>";
                include('views/projects.php');
                echo '</div>';
            } else { 
                echo "<div id='tab2' class='tab'>"; 
                include('views/projects.php');
                echo '</div>';
            }
            ?>
        <?php $invoice_query = $Controller->invoice_list(); ?>
        <?php $num_results4 = $invoice_query->num_rows; ?>
        <?php if( $num_results4 > 0){ ?>
        <?php
            if (isset($_GET['tab_id']) && $_GET['tab_id'] == 3) { 
                echo "<div id='tab3' class='tab active'>";
                include("views/invoices.php");
                echo '</div>';
            } else { 
                echo "<div id='tab3' class='tab'>";
                include("views/invoices.php");
                echo '</div>';
            }
            ?>
        <?php } ?>
    </div>
</div>

        <?php } ?>
    </div>
    <?php } ?>
    </div>
</div>
<?php
    if (defined('WRAP_WIDTH') && constant('WRAP_WIDTH') != '100%') {
        echo '<BR>';
    }
    ?>
</div>
<div class="page-row">
<?php
if (file_exists('custom/options-config.php')) {
    require_once('custom/options-config.php');
    if (constant('DISPLAY_FOOTER') == 'yes') {
        //echo '<footer>';
        include("views/footer.php");
        //echo '</footer>';
        } 
}
?>
</div>
<?php

} else {
    // Show log in screen
echo '<div class="login-wrap">';
echo "<div class='welcome'>
    <h2>Welcome to the Client Portal.</h2>
     <p class='welcome' style='text-align: left;'>Please log in with your email address and password. <BR>If you do not yet have a password, you will recieve login credentials via email once your first project is started.</p>
    </div>
    <BR>";
include("views/not_logged_in.php"); 
echo '</div>';
} 
} else {
    echo "<script>window.location = 'install.php'</script>";
}
?>