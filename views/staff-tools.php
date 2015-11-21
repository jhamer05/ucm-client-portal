<?php require_once('custom/options-config.php'); ?>

<?php if (constant('STAFF_TOOLS') == 'on') { ?>
<script type="text/javascript" src="js/jscolor/jscolor.js"></script>
<div class="wrap-header">
    <h2 class="wrap-title">Staff Tools (Preview)</h2>
</div>
<?php if ($_SESSION['is_staff'] == 1) { ?>

<div class="left-box" style="border: 0px; padding: 2px;">
<div class="inner">
<div class="tabs">
    <div class="tab-content">
        <div id='tab1'
             <?php 
                if (isset($_GET['staff_tab']) && $_GET['staff_tab'] == 1) {
                    echo"class='tab active'";
                } elseif (!isset($_GET['staff_tab'])) {
                    echo"class='tab active'";
                } else {
                    echo"class='tab'";
                } ?> >
            <BR>
            <h2 style="text-align: center;">Edit a Quote</h2>
            On this page you can select a quote and edit it's tasks. Once a quote has been approved, it will no longer be editable.
            <BR><BR>
            <strong>NOTE:</strong> Currently you cannot add a new task or quote from this page. This will come later but for now please continue to use UCM for this.
            <BR><BR><BR><BR>
            <HR>
            Preview Notes: This is a preview of things to come. For some reason this section and the admin section have taken a lot more time to create than anticipated. As such, the features are currently limited and these sections are considered to be in "preview" status.
            <BR><BR>
            A major feature of this page will be the ability to create quotes and tasks, then convert them into projects as can be done in UCM.
            <BR><BR>
        </div>
        <div id='tab2'
             <?php 
                if (isset($_GET['staff_tab']) && $_GET['staff_tab'] == 2) {
                    echo"class='tab active'";
                } else {
                    echo"class='tab'";
                } ?> >
            <BR>
            <h2 style="text-align: center;">Edit a Project</h2>
            On this page you can select a project and edit it's tasks. This is basically the same setup as the "Quotes" tab.
            <BR><BR>
            <strong>NOTE:</strong> Currently you cannot add a new task or project from this page. This will come later but for now please continue to use UCM for this.
            <BR><BR><BR><BR>
            <HR>
            Preview Notes: This is a preview of things to come. For some reason this section and the admin section have taken a lot more time to create than anticipated. As such, the features are currently limited and these sections are considered to be in "preview" status.
            <BR><BR>
            A major feature of this page will be the task timer. Staff members will come to this page, select a project they are working on, and start a timer. This will then fill in the "Hours" field when the timer is stopped. Active timers will be displayed in the site header. There will also be the ability to create projects and upload new files.
            <BR><BR>
        </div>
        <div id='tab3'
             <?php 
                if (isset($_GET['staff_tab']) && $_GET['staff_tab'] == 3) {
                    echo"class='tab active'";
                } else {
                    echo"class='tab'";
                } ?> >
            <BR>
            <h2 style="text-align: center;">Eit an Invoice</h2>
            On this page you can add or edit an invoice for completed tasks from a project. Select the project from a list of open jobs. Choose which tasks you would like to include on the invoice, then press "Create Invoice". 
            <BR><BR>
            To edit a current invoice select the "Invoice List" checkbox. This will display a list of unpaid invoices. You can then edit the tasks on the invoice as you would for a quote or project.<BR><BR><BR><BR>
            <HR>
            Preview Notes: This is a preview of things to come. For some reason this section and the admin section have taken a lot more time to create than anticipated. As such, the features are currently limited and these sections are considered to be in "preview" status.
            <BR><BR>
            <!-- A major feature of this page will be -->
            <BR><BR>
        </div>
        <div id='tab4'
             <?php 
                if (isset($_GET['staff_tab']) && $_GET['staff_tab'] == 4) {
                    echo"class='tab active'";
                } else {
                    echo"class='tab'";
                } ?> >
            <BR>
            <h2 style="text-align: center;">Client Info</h2>
            On this page you can view and edit client information. Currently you can fill in various fields for client details and reset a client's password. Client password resets will generate a random password and email it to the client.
            <BR><BR>
            <strong>NOTE: </strong>You only have access to clients from customers to which you have access.
            <BR><BR><BR><BR>
            <HR>
            Preview Notes: This is a preview of things to come. For some reason this section and the admin section have taken a lot more time to create than anticipated. As such, the features are currently limited and these sections are considered to be in "preview" status.
            <BR><BR>
            An upcoming feature of this page will be the ability to create new clients. The Administrator will also be able to create new customers. There will also be more client information listed on this page. Staff members will be able to quickly see things like outstanding payments, subscription status, or which projects are due for each client.
            <BR><BR>
        </div>
    </div>
</div>
</div>
</div>
<div class="right-box">

    
    
<BR>
<div class="tabs">
    <ul class="tab-links" style="margin-left: 10px;">
        <li 
             <?php 
                if (isset($_GET['staff_tab']) && $_GET['staff_tab'] == 1) {
                    echo"class='active'";
                } elseif (!isset($_GET['staff_tab'])) {
                    echo"class='active'";
                } else {
                    echo"";
                } ?> >
            <a href="#tab1">Quotes</a></li>
        <li
             <?php 
                if (isset($_GET['staff_tab']) && $_GET['staff_tab'] == 2) {
                    echo"class='active'";
                } else {
                    echo"";
                } ?> >
            <a href="#tab2">Projects</a></li>
        <li
             <?php 
                if (isset($_GET['staff_tab']) && $_GET['staff_tab'] == 3) {
                    echo"class='active'";
                } else {
                    echo"";
                } ?> >
            <a href="#tab3">Invoices</a></li>
        <li
             <?php 
                if (isset($_GET['staff_tab']) && $_GET['staff_tab'] == 4) {
                    echo"class='active'";
                } else {
                    echo"";
                } ?> >
            <a href="#tab4">Clients</a></li>
    </ul>
    <div class="tab-content" style="border-top: 1px solid;">
        <div id='tab1'
             <?php 
                if (isset($_GET['staff_tab']) && $_GET['staff_tab'] == 1) {
                    echo"class='tab active'";
                } elseif (!isset($_GET['staff_tab'])) {
                    echo"class='tab active'";
                } else {
                    echo"class='tab'";
                } ?> >
            <?php include('staff/edit-quotes.php'); ?>
        </div>
        <div id='tab2'
             <?php 
                if (isset($_GET['staff_tab']) && $_GET['staff_tab'] == 2) {
                    echo"class='tab active'";
                } else {
                    echo"class='tab'";
                } ?> >
            <?php include('staff/edit-projects.php'); ?>
        </div>
        <div id='tab3'
             <?php 
                if (isset($_GET['staff_tab']) && $_GET['staff_tab'] == 3) {
                    echo"class='tab active'";
                } else {
                    echo"class='tab'";
                } ?> >
            <?php include('staff/edit-invoices.php'); ?>
        </div>
        <div id='tab4'
             <?php 
                if (isset($_GET['staff_tab']) && $_GET['staff_tab'] == 4) {
                    echo"class='tab active'";
                } else {
                    echo"class='tab'";
                } ?> >
            <?php include('staff/clients.php'); ?>
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
    <h2 style="text-align: center;">Please log in as a Staff Member</h2>
    This page is used to manage content and client information. Staff members have access to information for the clients to which they have been assigned. If you are recieving this message in error, please contact your administrator for help.
    
</div>
</div>


<?php } ?>
<?php } ?>