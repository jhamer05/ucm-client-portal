<div class="wrap-header">
    <h2 class="wrap-title">Profile Settings</h2>
</div>
<div class="left-box" style="background-color: #fff; border: 0px; padding: 2px;">
    <br>
    <center>
    <a href="http://www.gravatar.com">
    <img src="<?php echo $Controller->avatar($_SESSION['email'], '200px'); ?>" alt="avatar" style="border: 3px solid e0e0e0;">        
    </a>
    <h3>To change your avatar image <BR>please visit <a href="http://gravatar.com">Gravatar.com</a></h3>
    </center>
            <div style="
                    margin: 10px auto;
                    -webkit-border-radius: 5px;
                    -moz-border-radius: 5px;
                    border-radius: 5px;
                    border: 1px solid #cccccc;
                    max-width: 500px;
                    text-align: center;
                    ">
        <?php
            $user_query = $Controller->get_user_info($_SESSION['user_id']); 
            $num_results = $user_query->num_rows; 
            if( $num_results > 0){ 
                $row_u = $user_query->fetch_assoc(); }
        ?>
        <table style="width: 100%; border: 2px solid #f0f0f0; padding: 5px; margin: 0 auto;">
            <tr style="background-color: #f0f0f0;">
                <td style="text-align: right; padding: 5px;">
                    Company Name:
                </td>
                <td style="text-align: right; padding: 5px;"><?php
                    $company_query = $Controller->get_customer_info(); 
                    $num_results = $company_query->num_rows; 
                    if( $num_results > 0){ 
                    $row = $company_query->fetch_assoc(); 
                    echo $row['customer_name']; } ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right; padding: 5px;">
                    Your Name:
                </td>
                <td style="text-align: right; padding: 5px;">
                    <?php echo $row_u['name'] . ' ' . $row_u['last_name']; ?>
                </td>
            </tr>
            <tr style="text-align: right; background-color: #f0f0f0;">
                <td style="text-align: right; padding: 5px;">
                    Email:
                </td>
                <td style="padding: 5px;">
                    <?php echo $row_u['email']; ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right; padding: 5px;">
                    Phone:
                </td>
                <td style="text-align: right; padding: 5px;">
                    <?php 
                    echo $row_u['phone']; 
                    ?>
                </td>
            </tr>
        </table> 
        </div>

<?php if (constant('DEMO_MODE') == 'on') {
        echo "
    <div style='
            background-color: #f4f4f4; 
            background: rgba(255, 255, 255, 0.9); 
            padding: 4px; 
            border: 1px solid #d8d8d8;
            box-shadow: 2px 2px 4px #808080;'>
        <p><strong>This page has been disabled for the demo.</strong><BR> You can still view it and submit the form but nothing will be written to the database.</p>
    </div>
    "; } ?>
    
</div>
<div class="right-box">
    <div style="padding: 10px;">
        Hello, <?php echo $row_u['name']; ?>. This is your profile page. You can use this page to update your information or change your password.
        <BR><BR>
        <HR>
        <BR>
        Please use the form below if you with to update information such as your email address or password.<BR>
        <strong>NOTE:</strong> If you change your email address, you'll log in using that address in the future.
    
<form id="form" method="post">

        <div style="
                    margin: 10px auto;
                    -webkit-border-radius: 5px;
                    -moz-border-radius: 5px;
                    border-radius: 5px;
                    border: 1px solid #cccccc;
                    max-width: 500px;
                    text-align: center;
                    min-width: 285px;
                    ">
        <table style="width: 100%; border: 2px solid #f0f0f0; padding: 5px; margin: 0 auto;">
            <tr style="background-color: #f0f0f0;">
                <td style="text-align: right; padding: 5px;">
                    Company Name:
                </td>
                <td style="text-align: right; padding: 12px;"><?php
                    $company_query = $Controller->get_customer_info(); 
                    $num_results = $company_query->num_rows; 
                    if( $num_results > 0){ 
                    $row = $company_query->fetch_assoc(); 
                    echo $row['customer_name']; } ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right; padding: 5px;">
                    Your Name:
                </td>
                <td style="text-align: right; padding: 12px;">
                    <?php echo $row_u['name'] . ' ' . $row_u['last_name']; ?>
                </td>
            </tr>
            <tr style="text-align: right; background-color: #f0f0f0;">
                <td style="text-align: right; padding: 5px;">
                    Email:
                </td>
                <td style="padding: 5px; padding-top: 10px; padding-bottom: 0px;">
                    <input id="login_input_username" class="login_input" type="username" name="email" />
                </td>
            </tr>
            <tr style="text-align: right; background-color: #fff;">
                <td style="text-align: right; padding: 5px;">
                    Phone:
                </td>
                <td style="padding: 5px; padding-top: 10px; padding-bottom: 0px;">
                    <input id="login_input_username" class="login_input" type="username" name="phone" />
                </td>
            </tr>
            <tr style="text-align: right; background-color: #f0f0f0;">
                <td style="text-align: right; padding: 5px;">
                    New Password:
                </td>
                <td style="padding: 5px; padding-top: 10px; padding-bottom: 0px;">
                    <input id="login_input_username" class="login_input" type="password" name="new_pass" />
                </td>
            </tr>
            <tr style="text-align: right; background-color: #fff;">
                <td style="text-align: right; padding: 5px;">
                    (Again):
                </td>
                <td style="padding: 5px; padding-top: 10px; padding-bottom: 0px;">
                    <input id="login_input_username" class="login_input" type="password" name="new_pass2" />
                </td>
            </tr>
            <tr style="text-align: right; background-color: #f0f0f0; vertical-align: middle;">
                <td style="text-align: right; padding: 5px;">
                    <span style="font-size: 16; font-weight: 700; color: b60000;">*</span> Old Password:
                </td>
                <td style="padding: 5px; padding-top: 10px; padding-bottom: 0px;">
                    <input id="login_input_username" class="login_input" type="password" name="password" required />
                </td>
            </tr>
        </table> 
        </div>
        
        
    </div>

    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <table style="width: 85%; margin: 0 auto;">
                <tr>
                    <td style='text-align: left; width: 100%; padding-right: 5px; vertical-align: center;'>
                        <span style="font-size: 10; font-weight: 600; color: b60000;">* Indicates Required Field</span>
                    </td>
                    <td>
                    <input type="submit" id="submit" name="update_profile" value="Update Information">
                    </td>
                </tr>
            </table>
</form>
</div>
<BR><BR>
<div style="text-align: center;">
    <form action="index.php" method="get">
        <input type="submit" value="Finished" style="float: none;" />
    </form>
</div>
</div>
<BR><BR>