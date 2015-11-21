<BR><BR>
<?php
if (!isset($Controller)) {
    $Controller = new Controller();
}


$user_id = $_SESSION['user_id'];
$user_info_query = $Controller->get_user_info($user_id);
$user_info = $user_info_query->fetch_assoc();
    
if ($user_info['name'] == '' || $user_info['last_name'] == '') { ?>
        <div class='due-date' style='background-color: #909090; color: f5f5f5; font-size: 20px; font-weight: 700;'>
        User Info Setup
    </div><BR>
    <div style="width: 75%; margin: 0 auto;">
    This page is intended for first time users to enter their name if it has not already been done. Once an account is created, the Name on the account or the company with which it is associated cannot be changed by the user. This helps to keep the chaos to a minimum and keep things organized. 
        <BR><BR>
            <strong>NOTE:</strong> Other information can be changed at any time in the "Profile" section by clicking the icon in the top left of the screen.
        <BR><BR>
        If you wish to change this information, please contact an administrator or member of the staff for help.
        <HR style="margin: 10px;">
            
        <form method="post">
            <center>
            <table style="margin: 0 auto: border: 0px solid; ">
            <TR style="font-size: 18px; font-weight: 600;">
                <TD>
                    <span style="color: b60000;">&#42;</span>First Name:&nbsp;
                </TD>
                <TD>
            <input id="login_input_username" class="login_input" type="username" name="name" required/>
                </TD>
            </TR>
                <TR>
                </TR>
            <TR style="font-size: 18px; font-weight: 600;">
                <TD>
                    <span style="color: b60000;">&#42;</span>Last Name:&nbsp;
                </TD>
                <TD>
            <input id="login_input_username" class="login_input" type="username" name="last_name" required/>
                </TD>
            </TR>
        </table>
            </center><BR>
            <center><span style="color: b60000;">Fields marked with a ( &#42; ) are required.</span></center>
            <HR style="margin: 10px;">
                <center>
            <input type="submit" style="padding: 4px; width: auto;" 
                       name="proceed" 
                       value="Proceed"/>
                </center>
                <BR>
        </form>
            
<?php 
if (isset($_POST['proceed'])) {
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];


    
    if ($user_info['customer_id'] != '') {
        $customer_id = $user_info['customer_id'];
    } else {
        $customer_id = '0';
    }
    if ($user_info['is_staff'] != '') {
        $is_staff = $user_info['is_staff'];
    } else {
        $is_staff = '0';
    }

/*
    if ($user_info['name'] != '') {
        $name = $user_info['name'];
    } else {
        $name = '';
    }
    if ($user_info['last_name'] != '') {
        $last_name = $user_info['last_name'];
    } else {
        $last_name = '';
    }
*/

    if ($user_info['email'] != '') {
        $email = $user_info['email'];
    } else {
        $email = $_POST['email'];
    }


    if ($user_info['password'] != '') {
        $password = $user_info['password'];
    } else {
        $password = $Controller->randomPassword();
    }


    if ($user_info['phone'] != '') {
        $phone = $user_info['phone'];
    } else {
        $phone = '';
    }


    if ($user_info['date_created'] != '') {
        $date_created = $user_info['date_created'];
    } else {
        $date_created = 'NOW()';
    }
    
    if ($user_info['special_access'] != '') {
        $special_access_read = $user_info['special_access'];
        $special_access_write = $special_access_read;
    } else {
        $special_access_write = $special_access_new;
    }

$Controller->update_user($customer_id, $is_staff, $email, $password, $name, $last_name, $phone, $date_created, $special_access_write, $user_id);

echo "<script>document.location = 'index.php'</script>";
    
}

} else { ?>
<div class='due-date' style='background-color: #909090; color: f5f5f5; font-size: 20px; font-weight: 700;'>
        User Info Already Created
    </div><BR>
    <div style="width: 75%; margin: 0 auto;">
    This page is intended for first time users to enter their name if it has not already been done. Once an account is created, the Name on the account or the company with which it is associated cannot be changed by the user. This helps to keep the chaos to a minimum and keep things organized. 
        <BR><BR>
        If you wish to change this information, please contact an administrator or member of the staff for help.
        <BR><BR>
<?php }
?>