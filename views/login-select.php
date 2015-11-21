<?php /*
require 'classes/PHPMailerAutoload.php';
$Controller = new Controller(); */
?>

<?php

class LoginSelect {
    function select_company()
    {
        
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        $query = "
        SELECT      u.email,
					u.user_id,
					c.customer_id,
					u.customer_id,
					c.customer_name
        FROM        `"._DB_PREFIX."user` AS u
        LEFT JOIN	`"._DB_PREFIX."customer` AS c
        ON			u.customer_id = c.customer_id
        WHERE       email = '" . $_SESSION['email'] . "'
        ;";
        
        $result = $this->db_connection->query( $query ); 
        return $result;

    }
    
}

?>
<?php 
$LoginSelect = new LoginSelect();
$company_query = $LoginSelect->select_company(); 
$num_results = $company_query->num_rows; 
if( $num_results > 0){ 
    //$row = $company_query->fetch_assoc(); 
//}
?>

<div class="wrap-header">
    <h2 class="wrap-title">Login</h2>
</div>
<div class="welcome">
Your email address is listed under more than one company. Please select which account you'd like to use. 
<BR>You can change this at any time by logging out and returning to this page.
</div>
<BR>
<div class="login-box">
    <form method="post">
        <center>
    <select type="dropdown" name="customer_id">
    <?php while($row = $company_query->fetch_assoc()){ ?>
    <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['customer_name']; ?></option>
    <?php } ?>
    </select>
    <BR><BR>
    <input type="submit" name="company_select_submit" value="Submit">
        </center>
    </form>
</div>
<?php } ?>

<?php
if (isset($_POST['company_select_submit'])) {
    $_SESSION['customer_id'] = $_POST['customer_id'];
    echo "<script>window.location = 'index.php'</script>";
}
?>



<BR><BR>
</div>