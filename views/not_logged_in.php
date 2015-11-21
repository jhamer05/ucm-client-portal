<?php
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo $error;
        }
    }
?><BR>

<div class="login-box">
    <div class="login">
<!-- login form box -->
<form method="post" action="index.php" name="loginform">

    <label for="login_input_username">Username (Email)</label>
    <input id="login_input_username" class="login_input" type="username" name="email" 
           <?php 
                if (constant('DEMO_MODE') == 'on') {
                echo "value='client1@example.com'";
                } ?> required />
    
    <label for="login_input_password">Password</label>
    <input id="login_input_password" class="login_input" type="password" name="user_password" autocomplete="off" 
           <?php 
                if (constant('DEMO_MODE') == 'on') {
                echo "value='client'";
                } ?> required />
    <div style="text-align: center;">
    <input type="submit"  name="login" value="Log in" />
    </div>
</form>
    
    </div>
</div>


<?php
        if ($login->messages) {
        foreach ($login->messages as $message) {
            echo $message;
        }
    }
}
?>
<BR>