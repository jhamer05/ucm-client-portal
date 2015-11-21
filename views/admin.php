<script type="text/javascript" src="js/jscolor/jscolor.js"></script>
<div class="wrap-header">
    <h2 class="wrap-title">Admin / Settings</h2>
</div>
<?php if ($_SESSION['user_id'] == 1) { ?>

<div class="left-box" style="border: 0px; padding: 2px;">
<div class="inner">
<div class="tabs">
    <div class="tab-content">
        <div id='tab1'
             <?php 
                if (isset($_GET['admin_tab']) && $_GET['admin_tab'] == 1) {
                    echo"class='tab active'";
                } elseif (!isset($_GET['admin_tab'])) {
                    echo"class='tab active'";
                } else {
                    echo"class='tab'";
                } ?> >
            <BR>
            <h2 style="text-align: center;">Colors &amp; Customization</h2>
            In this section you can customize the look and feel of the system to suit your needs. There are several input boxes in this form to change the colors and borders of just about everything on the site.
            <BR><BR>
            Please either choose a preset theme or select the "Use custome color settings" checkbox to have more controll over specific colors.
            <BR><BR>
            In the future, there will be more settings for things like page and box widths, text alignments, image styling, etc. This will likely be in a seperate tab in the admin panel.
            <BR><BR>
            <strong>NOTE:</strong> If you choose a theme or change settings it will overwrite the current custom styles.
            <BR><BR><BR><BR>
            <strong>You may have to refresh this page to see changes.</strong><BR> Changes will take affect imediately but your browser may store certain data for display purposes. Please refresh the page or delete the website data in your browser settings if you don't see the changes.
            <BR><BR>
        </div>
        <div id='tab2'
             <?php 
                if (isset($_GET['admin_tab']) && $_GET['admin_tab'] == 2) {
                    echo"class='tab active'";
                } else {
                    echo"class='tab'";
                } ?> >
            <BR>
            <h2 style="text-align: center;">Options</h2>
            In this section you can choose various options to further customize the client portal. For now the only options available are for the welcome message and optional footer, but more will come with future updates.
            <BR><BR>
            <strong>NOTE:</strong> The "Custom Content" boxes for the footer will accept HTML input so you can put just about anything you want in them.
            <BR><BR><BR><BR>
            <strong>You may have to refresh this page to see changes.</strong><BR> Changes will take affect imediately but your browser may store certain data for display purposes. Please refresh the page or delete the website data in your browser settings if you don't see the changes.
            <BR>
            <?php if (constant('DEMO_MODE') == 'on') {
        echo "
    <div style='
            background-color: #f4f4f4; 
            background: rgba(255, 255, 255, 0.9); 
            padding: 4px; 
            border: 1px solid #d8d8d8;
            box-shadow: 2px 2px 4px #808080;'>
        <p><strong>This page has been disabled for the demo.</strong><BR> You can still view it and submit the form but nothing will be written to the config files.</p>
    </div>
    "; } ?>
            <BR>
        </div>
        <div id='tab3'
             <?php 
                if (isset($_GET['admin_tab']) && $_GET['admin_tab'] == 3) {
                    echo"class='tab active'";
                } else {
                    echo"class='tab'";
                } ?> >
            <BR>
            <h2 style="text-align: center;">System Settings</h2>
            In this section you can change settings such as the site title and time zone. These settings should have already been created during the installation process but should you need to change them, this is the place to do it.
            <BR><BR>
            Updates can be installed by clicking the "Check for Updates" button. At this time there is no automatic system in place for downloads. You will have to download the package manually but the system will install it for you.
            <BR><BR>
            <strong>NOTE:</strong> In the future, there may be more options here as well for features that have not yet been made.
            <BR><BR><BR><BR>
            <strong>You may have to refresh this page to see changes.</strong><BR> Changes will take affect imediately but your browser may store certain data for display purposes. Please refresh the page or delete the website data in your browser settings if you don't see the changes.
            <BR>
            <?php if (constant('DEMO_MODE') == 'on') {
        echo "
    <div style='
            background-color: #f4f4f4; 
            background: rgba(255, 255, 255, 0.9); 
            padding: 4px; 
            border: 1px solid #d8d8d8;
            box-shadow: 2px 2px 4px #808080;'>
        <p><strong>This page has been disabled for the demo.</strong><BR> You can still view it and submit the form but nothing will be written to the config files.</p>
    </div>
    "; } ?>
            <BR>
        </div>
    </div>
</div>
</div>
</div>
<div class="right-box">

    
    
<BR>
<div class="tabs">
    <ul class="tab-links">
        <li 
             <?php 
                if (isset($_GET['admin_tab']) && $_GET['admin_tab'] == 1) {
                    echo"class='active'";
                } elseif (!isset($_GET['admin_tab'])) {
                    echo"class='active'";
                } else {
                    echo"";
                } ?> >
            <a href="index.php?page=admin&admin_tab=1">Themes</a></li>
        <li
             <?php 
                if (isset($_GET['admin_tab']) && $_GET['admin_tab'] == 2) {
                    echo"class='active'";
                } else {
                    echo"";
                } ?> >
            <a href="index.php?page=admin&admin_tab=2">Options</a></li>
        <li
             <?php 
                if (isset($_GET['admin_tab']) && $_GET['admin_tab'] == 3) {
                    echo"class='active'";
                } else {
                    echo"";
                } ?> >
            <a href="index.php?page=admin&admin_tab=3">Settings</a></li>
    </ul>
    <div class="tab-content" style="border-top: 1px solid;">
        <div id='tab1' 
             <?php 
                if (isset($_GET['admin_tab']) && $_GET['admin_tab'] == 1) {
                    echo"class='tab active'";
                } elseif (!isset($_GET['admin_tab'])) {
                    echo"class='tab active'";
                } else {
                    echo"class='tab'";
                } ?> >
            <BR>
            <?php include('admin/theme-settings.php'); ?>
        </div>
        <div id='tab2'
             <?php 
                if (isset($_GET['admin_tab']) && $_GET['admin_tab'] == 2) {
                    echo"class='tab active'";
                } else {
                    echo"class='tab'";
                } ?> >
            <?php include('admin/system-options.php'); ?>
        </div>
        <div id='tab3'
             <?php 
                if (isset($_GET['admin_tab']) && $_GET['admin_tab'] == 3) {
                    echo"class='tab active'";
                } else {
                    echo"class='tab'";
                } ?> >
            <?php 
                if (isset($_POST['update_page']) || isset($_GET['update_page'])) {
                    include('admin/update/updater.php');
                    //<script>window.location = 'index.php?page=update'</script>
                } else {
                    include('admin/system-settings.php'); 
                }
            ?>
        </div>
    </div>
</div>
    
</div>
</div>
</div>
<?php 
} else {
?>

<div class="welcome">
    <h2 style="text-align: center;">Please log in as the administrator</h2>
    This page controls various system settings. It is only usable by the system administrator. Please log in as the admin to continue.
    
</div>
</div>



<?php } ?>