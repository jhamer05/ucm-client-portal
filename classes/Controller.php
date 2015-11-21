<?php
if (isset($_POST['submit_comment'])){
    //session_start();
    require_once("config/config.php");
    require_once("Login.php");
    $Controller = new Controller();
    $Controller->ajax_project_comments_submit();
}

if (isset($_POST['update_profile'])){
    require_once("config/config.php");
    require_once("Login.php");
    //require_once("../config/config.php");
    //require_once("login.php");
    $Controller = new Controller();
    $Controller->update_profile();
}

if (isset($_POST['update_user_staff'])){
    require_once("config/config.php");
    require_once("Login.php");
    //require_once("../config/config.php");
    //require_once("login.php");
    $Controller = new Controller();
    $Controller->update_user_staff();
}

if (isset($_POST['quote_task_submit'])){
    require_once("config/config.php");
    require_once("Login.php");
    //require_once("../config/config.php");
    //require_once("login.php");
    $Controller = new Controller();
    //$_GET['quote_id'] = $_GET['quote'];
    $Controller->write_quote();
}

if (isset($_POST['project_task_submit'])){
    require_once("config/config.php");
    require_once("Login.php");
    //require_once("../config/config.php");
    //require_once("login.php");
    $Controller = new Controller();
    //$_GET['quote_id'] = $_GET['quote'];
    $Controller->write_project();
}



class Controller
{

// --- GENERAL --- //   
    function rrmdir($dir) { 
       if (is_dir($dir)) { 
         $objects = scandir($dir); 
         foreach ($objects as $object) { 
           if ($object != "." && $object != "..") { 
             if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
           } 
         } 
         reset($objects); 
         rmdir($dir); 
       } 
    } 
    function Delete($path) {
            if (is_dir($path) === true) {
                $files = array_diff(scandir($path), array('.', '..'));
                foreach ($files as $file) {
                    Delete(realpath($path) . '/' . $file);
                }
                return rmdir($path);
            }
            else if (is_file($path) === true) {
                return unlink($path);
            }
            return false;
        }
    
    function check_for_thumb($src) {
        $image_name = pathinfo($src, PATHINFO_FILENAME);
        $files = glob("images/project_thumbnails/$image_name.*"); 
        if (count($files) > 0) {
            foreach ($files as $file)
             {
                $info = pathinfo($file);
                $ext = $info["extension"];
             }
        $image_path = 'images/project_thumbnails/' . $image_name . '.' . $ext;
        }
        if (isset($image_path) && file_exists($image_path)) {
            return 'true';
            //echo 'File Exists!';
        } else {
            return 'false';
            //echo 'File Does Not Exist!';
        }
    }
    
    
    function retrieve_thumb($src) {
        $image_name = pathinfo($src, PATHINFO_FILENAME);
        $files = glob("images/project_thumbnails/$image_name.*"); 
        if (count($files) > 0) {
            foreach ($files as $file)
             {
                $info = pathinfo($file);
                $ext = $info["extension"];
             }
        $image_path = 'images/project_thumbnails/' . $image_name . '.' . $ext;
                
        if (file_exists($image_path)) {
            return $image_path;
        } else {
            return 'images/no-image.jpg';
        }
        } else {
            return 'images/no-image.jpg';
        }
    }
    
    
    function generate_thumb($src, $width = '150') {
        $image_name = basename($src);

        $image_info = getImageSize($src);
        switch($image_info['mime']) {
            case 'image/jpg':
                $image = @imagecreatefromjpeg($src);
                $image_type = 'jpg';
            break;
            case 'image/jpeg':
                $image = @imagecreatefromjpeg($src);
                $image_type = 'jpg';
            break;
            case 'image/gif':
                $image = @imagecreatefromgif($src);
                $image_type = 'gif';
            break;
            case 'image/png':
                $image = @imagecreatefrompng($src);
                $image_type = 'png';
            break;
        }

        if (!isset($image_type)) {
            return 'false';
        } else {
            $image_path = 'images/project_thumbnails/' . $image_name . '.' . $image_type;
            
            $orig_width = imagesx($image);
            $orig_height = imagesy($image);
            $height = (($orig_height * $width) / $orig_width);

            $thumb_image = @ImageCreateTrueColor($width, $height);

            if ($image_type == 'png' || $image_type == 'gif') {
                imagealphablending($thumb_image, false);
            }
            
            ImageCopyResampled($thumb_image, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
            //echo '<BR><BR>Coppied!<BR><BR>';
            
            
            if ($image_type == 'png' || $image_type == 'gif') {
                ImageSaveAlpha($thumb_image, true);
            } else {
                if (function_exists('imageconvolution')) {
                    $sharpen = array(array( -1, -1, -1 ),
                                     array( -1, 34, -1 ),
                                     array( -1, -1, -1 )
                    );
                    $amount = array_sum(array_map('array_sum', $sharpen));
                    imageconvolution($thumb_image, $sharpen, $amount, 0);
                    //echo '<BR><BR>Sharpened!<BR><BR>';
                }

            }


            switch($image_type) {
                case 'jpg':
                    ob_start();
                    imagejpeg($thumb_image, $image_path, 80);
                    header('Content-type: image/jpeg'); 
                    imagejpeg($thumb_image, NULL, 80);	
                    ob_clean();
                break;
                case 'gif':
                    ob_start();
                    imagegif($thumb_image, $image_path);
                    header('Content-type: image/gif'); 
                    imagegif($thumb_image, NULL);
                    ob_clean();
                break;
                case 'png':
                    ob_start();
                    imagepng($thumb_image, $image_path);
                    header('Content-type: image/png');
                    imagepng($thumb_image, NULL);
                    ob_clean();
                break;
            }
            //echo '<BR><BR>Written!<BR><BR>';

            imagedestroy($image);
            imagedestroy($thumb_image);

        }     
    }
    
    
    
    
    
    
    
    function get_general_currency_data() {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        $query = "
        SELECT
                    (SELECT		case when u.key = 'currency_decimal_places' then u.val end as email_smtp_auth
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'currency_decimal_places' then u.val end) != 'NULL') AS currency_decimal_places,
                    (SELECT		case when u.key = 'currency_decimal_separator' then u.val end
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'currency_decimal_separator' then u.val end) != 'NULL') AS currency_decimal_separator,
                    (SELECT		case when u.key = 'currency_thousand_separator' then u.val end
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'currency_thousand_separator' then u.val end) != 'NULL') AS currency_thousand_separator,
                    (SELECT		case when u.key = 'default_currency_id' then u.val end
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'default_currency_id' then u.val end) != 'NULL') AS default_currency_id,
                    y.currency_id,
                    y.code,
                    y.symbol
        FROM		`"._DB_PREFIX."config` AS g
        LEFT JOIN   `"._DB_PREFIX."currency` AS y
        ON			(SELECT		case when u.key = 'default_currency_id' then u.val end
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'default_currency_id' then u.val end) != 'NULL') = y.currency_id
        WHERE		y.currency_id = (SELECT		case when u.key = 'default_currency_id' then u.val end
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'default_currency_id' then u.val end) != 'NULL')
        LIMIT		1
        ;";
        
        $result = $this->db_connection->query( $query ); 
        return $result;
    }
    
    function get_project_currency_data($type, $id) {
        if ($type == 'quote'){
            $type_select = "LEFT JOIN	`"._DB_PREFIX."quote` AS q
                            ON			q.currency_id = y.currency_id
                            WHERE		q.quote_id = $id";
        } elseif ($type == 'project'){
            $type_select = "LEFT JOIN	`"._DB_PREFIX."job` AS q
                            ON			q.currency_id = y.currency_id
                            WHERE		q.job_id = $id";
        } elseif ($type == 'invoice'){
            $type_select = "LEFT JOIN	`"._DB_PREFIX."invoice` AS q
                            ON			q.currency_id = y.currency_id
                            WHERE		q.invoice_id = $id";
        }
        
        
        
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        $query = "
        SELECT
                    (SELECT		case when u.key = 'currency_decimal_places' then u.val end as email_smtp_auth
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'currency_decimal_places' then u.val end) != 'NULL') AS currency_decimal_places,
                    (SELECT		case when u.key = 'currency_decimal_separator' then u.val end
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'currency_decimal_separator' then u.val end) != 'NULL') AS currency_decimal_separator,
                    (SELECT		case when u.key = 'currency_thousand_separator' then u.val end
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'currency_thousand_separator' then u.val end) != 'NULL') AS currency_thousand_separator,
                    y.currency_id,
                    y.code,
                    y.symbol,
                    q.name
        FROM		`"._DB_PREFIX."config` AS g
        LEFT JOIN   `"._DB_PREFIX."currency` AS y
        ON			y.currency_id = y.currency_id
        $type_select
        LIMIT		1
        ;";
        
        $result = $this->db_connection->query( $query ); 
        return $result;
    }
    
    
// --- USERS & PASSWORDS --- //
    function special_access_column_check() {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        
        $column_query = "SELECT EXISTS
                                (SELECT * 
                                FROM information_schema.COLUMNS 
                                WHERE 
                                    TABLE_SCHEMA = '".DB_NAME."' 
                                AND TABLE_NAME = '`"._DB_PREFIX."user`' 
                                AND COLUMN_NAME = 'special_access')AS table_check";
        
        $result = $this->db_connection->query( $column_query ); 
        $row = $result->fetch_assoc();
        if ($row['table_check'] == 0) {
        $add_column = "ALTER TABLE `"._DB_PREFIX."user`
                            ADD special_access
                            TEXT
                            AFTER `date_updated`";
        $this->db_connection->query( $add_column );
        }
    }
    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    function add_user($customer_id, $is_staff, $email, $password, $name, $last_name, $phone, $date_created, $special_access_write) 
    {
        $Controller = new Controller();
        $Controller->special_access_column_check();
        
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        /* Testing Values...
        echo '$customer_id - ' . $customer_id . '<BR>';
        echo '$is_staff - ' . $is_staff . '<BR>';
        echo '$email - ' . $email . '<BR>';
        echo '$password - ' . $password . '<BR>';
        echo '$name - ' . $name . '<BR>';
        echo '$last_name - ' . $last_name . '<BR>';
        echo '$phone - ' . $phone . '<BR>';
        echo '$date_created - ' . $date_created . '<BR>';
        echo '$special_access_write - ' . $special_access_write . '<BR>';
        */
        $query = "  INSERT INTO 	`"._DB_PREFIX."user` 
                                    (customer_id, 
                                    is_staff,
                                    email,
                                    password,
                                    name,
                                    last_name,
                                    phone,
                                    date_created,
                                    special_access)
                    VALUES 
                                    ('$customer_id', 
                                    '$is_staff',
                                    '$email',
                                    '$password',
                                    '$name',
                                    '$last_name',
                                    '$phone',
                                    $date_created,
                                    '$special_access_write') 
                    ";
        
        $result = $this->db_connection->query( $query ); 
        return $result;
        /*if ($result) {
            echo "Success";
        } else {
            echo "There was an error writing to the database...";
        }*/
        
    }
    
    function update_user($customer_id, $is_staff, $email, $password, $name, $last_name, $phone, $date_created, $special_access_write, $user_id) 
    {
        $Controller = new Controller();
        $Controller->special_access_column_check();
        
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
echo "<BR>";
        //echo $customer_id . $is_staff . $email . $password . $name . $last_name . $phone . $date_created . $special_access_write;
echo "<BR>";
        
        $query = "  UPDATE       	`"._DB_PREFIX."user` 
                    SET             customer_id = '$customer_id',
                                    is_staff = '$is_staff',
                                    email = '$email',
                                    password = '$password',
                                    name = '$name',
                                    last_name = '$last_name',
                                    phone = '$phone',
                                    date_created = '$date_created',
                                    date_updated = NOW(),
                                    special_access = '$special_access_write'
                    WHERE           user_id = $user_id
                    ";
        
        $result = $this->db_connection->query( $query ); 
        return $result;
        //$row = $result->fetch_assoc();
        //    echo $row['table_check'];
        
    }
    
    
    
    function update_profile() {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                    if ($this->db_connection->connect_error) {
                        die("Connection failed: " . $this->db_connection->connect_error);
                    } 

            
           
        
        $user_query = $this->get_user_info($_POST['user_id']); 
        $num_results = $user_query->num_rows; 
        if( $num_results > 0){ 
            $row = $user_query->fetch_assoc(); }
                    
            $pass_check = $row['password'];
        
            echo "<div style='
            position: absolute;
            z-index: 999;
            width: 90%;
            margin-top: 50px;
            margin-bottom: 50px;
            margin-left: 4%;
            background-color: #f4f4f4; 
            background: rgba(255, 255, 255, 0.9); 
            color: #303030;
            padding: 4px; 
            border: 1px solid #d8d8d8; 
            text-align: center;
            box-shadow: 2px 2px 4px #808080;'>";
        
            $user_id = mysqli_real_escape_string($this->db_connection, $_POST['user_id']);
            if ($_POST['email'] != '') {
                $posted_email = $_POST['email'];
                $all_user_query = "
                    SELECT      *
                    FROM        `"._DB_PREFIX."user`
                    WHERE       email = '$posted_email'
                    AND         user_id != $user_id
                    ;";
                $result1 = $this->db_connection->query( $all_user_query );
                $num_results1 = $result1->num_rows; 
                if( $num_results1 > 0){ 
                    echo '<strong>ERROR: </strong>This email address is already in use by another user. Please choose a different address.<BR>';
                    $email = $row['email'];
                } else {
                $email = mysqli_real_escape_string($this->db_connection, $_POST['email']);
                }
            } else {
                $email = $row['email'];
            }
            if ($_POST['phone'] != '') {
                $phone = mysqli_real_escape_string($this->db_connection, $_POST['phone']);
            } else {
                $phone = $row['phone'];
            }
            if ($_POST['new_pass'] != '') {
                if ($_POST['new_pass2'] != '') {
                    if ($_POST['new_pass'] = $_POST['new_pass2']) {
                        $new_pass = mysqli_real_escape_string($this->db_connection, $_POST['new_pass']);
                        $enc_new_pass = md5($new_pass);
                    } else {
                        echo '<strong>ERROR: </strong>Sorry, but the new passwords did not match.<BR>';
                    }
                } else {
                    echo '<strong>ERROR: </strong>Sorry, but you need to enter the new password twice.<BR>';
                }
            } else {
                $enc_new_pass = $row['password'];
            }
            
            if (isset($_POST['password']) && $_POST['password'] != '') {
                $password = mysqli_real_escape_string($this->db_connection, $_POST['password']);
                $enc_pass = md5($password);
            } else {
                echo '<strong>ERROR: </strong>You need to enter your current password for security purposes.<BR>';
            }
            //$enc_pass = md5($password);
            //$enc_new_pass = md5($new_pass);

            //$comment = mysqli_real_escape_string($this->db_connection, $_POST['comment']);
        if (isset($enc_pass) && $enc_pass = $pass_check){
            if (constant('DEMO_MODE') == 'on') {
                $query = "";
            } else {
            $password = "password = '$enc_new_pass'";
            $query = "  UPDATE      `"._DB_PREFIX."user` 
                        SET         email = '$email',
                                    phone = '$phone',
                                    $password
                        WHERE       user_id = '$user_id'
                        AND         password = '$enc_pass'
                        ";	
            
            $this->db_connection->query( $query );
            echo "<strong>Information updated succesfully</strong>";
            }
            
        } else {
            echo '<strong>ERROR: </strong>You may have entered your current password incorectly.<BR>';
        }
      echo "<BR><a href='index.php?page=profile'>Click Here</a> to dismis this notification.";
      echo "</div>";
    }
    
    
    
    
    function update_user_staff() {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                    if ($this->db_connection->connect_error) {
                        die("Connection failed: " . $this->db_connection->connect_error);
                    } 

        $user_query = $this->get_user_info($_POST['user_id']); 
        $num_results = $user_query->num_rows; 
        if( $num_results > 0){ 
            $row = $user_query->fetch_assoc(); 
                    
            //$pass_check = $row['password'];          
            $user_id = mysqli_real_escape_string($this->db_connection, $_POST['user_id']);
            
            
        if (isset($_POST['edit_client_info']) && $_POST['edit_client_info'] == '1') {

            if (isset($_POST['first_name']) && $_POST['first_name'] != '') {
                $first_name = mysqli_real_escape_string($this->db_connection, $_POST['first_name']);
            } else {
                $first_name = $row['name'];
            }
            if (isset($_POST['last_name']) && $_POST['last_name'] != '') {
                $last_name = mysqli_real_escape_string($this->db_connection, $_POST['last_name']);
            } else {
                $last_name = $row['last_name'];
            }
            if (isset($_POST['email']) && $_POST['email'] != '') {
                $email = mysqli_real_escape_string($this->db_connection, $_POST['email']);
            } else {
                $email = $row['email'];
            }
            if (isset($_POST['phone']) && $_POST['phone'] != '') {
                $phone = mysqli_real_escape_string($this->db_connection, $_POST['phone']);
            } else {
                $phone = $row['phone'];
            }
            
            $user_info = "  name = '$first_name',
                            last_name = '$last_name',
                            email = '$email',
                            phone = '$phone',";
            
        } else {
            $user_info = '';
        }
               
            
            
            if (isset($_POST['new_pass']) && $_POST['new_pass'] != '') {
                    $new_pass = mysqli_real_escape_string($this->db_connection, $_POST['new_pass']);
                    $enc_new_pass = md5($new_pass);
            } else {
                $new_pass = $row['password'];
                $enc_new_pass = $row['password'];
            }
            
            
        //if (isset($enc_pass) && $enc_pass = $pass_check){
            if (constant('DEMO_MODE') == 'on') {
                $query = "";
            } else {
            $query = "  UPDATE      `"._DB_PREFIX."user` 
                        SET         $user_info
                                    password = '$new_pass'
                        WHERE       user_id = '$user_id'
                        ";	
            
            $this->db_connection->query( $query );
            include ('views/staff/user-info-update-message.php');
            }
            
        //} else {
        //    echo 'There was an error. You may have entered your current password incorectly.';
        //}
            
      }
    }
    
// -------- GET INFO -------- //
    function get_customer_info($customer = 'NULL') {
        if ($customer != 'NULL') {
            $where_customer_id = "WHERE       c.customer_id = '" . $customer . "'";
        } else {
            $where_customer_id = "WHERE       c.customer_id = '" . $_SESSION['customer_id'] . "'";
        }
        
        
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        $query = "
        SELECT      *,
                    c_total_amount_due,
                    customer_name,
                    credit,
                    SUM(c_total_amount_due) AS total_due
        FROM        `"._DB_PREFIX."customer` AS c
        LEFT JOIN   `"._DB_PREFIX."invoice` AS i
        ON          i.customer_id = c.customer_id
        $where_customer_id
        ;";
        
        $result = $this->db_connection->query( $query ); 
        
        return $result;
        
    }
    
    function get_user_info($user_id='NULL') {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        if ($user_id != 'NULL'){
            $where = "WHERE       user_id = $user_id";
        } else {
            $where = "WHERE       user_id = '" . $_SESSION['user_id'] . "'";
        }
        $query = "
        SELECT      *
        FROM        `"._DB_PREFIX."user`
        $where
        ;";
        
        $result = $this->db_connection->query( $query ); 
        return $result;
    }
    
    
    
    
    function get_user_info_staff($user_id='NULL') {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        if ($_SESSION['user_id'] == 1) {
            $where_staff = "WHERE		u.user_id = u.user_id";
        } else {
            $where_staff = "WHERE		r.user_id = '" . $_SESSION['user_id'] . "'";
        }
        
        
        if ($user_id != 'NULL'){
            $and = "AND       u.user_id = $user_id";
        } else {
            $and = "";
        }
        $query = "
        SELECT		c.customer_id,
                    r.user_id AS related_user,
                    c.primary_user_id,
                    c.customer_name,
                    u.user_id AS user_id,
                    u.email,
                    u.name,
                    u.last_name,
                    u.phone,
                    u.password

        FROM		`"._DB_PREFIX."customer` AS c
        LEFT JOIN	`"._DB_PREFIX."user` AS u
        ON			c.customer_id = u.customer_id
        LEFT JOIN	`"._DB_PREFIX."customer_user_rel` AS r
        ON			c.customer_id = r.customer_id
        $where_staff
        $and
        ;";
        
        $result = $this->db_connection->query( $query ); 
        return $result;
    }
    
    
    
    
    
    
// -------- EMAIL -------- //
    function get_email_settings() {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        $query = "
        SELECT
                    (SELECT		case when u.key = 'email_smtp_auth' then u.val end as email_smtp_auth
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'email_smtp_auth' then u.val end) != 'NULL') AS email_smtp_auth,
                    (SELECT		case when u.key = 'email_smtp_hostname' then u.val end
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'email_smtp_hostname' then u.val end) != 'NULL') AS email_smtp_hostname,
                    (SELECT		case when u.key = 'email_smtp_password' then u.val end
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'email_smtp_password' then u.val end) != 'NULL') AS email_smtp_password,
                    (SELECT		case when u.key = 'email_smtp_username' then u.val end
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'email_smtp_username' then u.val end) != 'NULL') AS email_smtp_username
        FROM		`"._DB_PREFIX."config`
        LIMIT		1
        ;";
        
        $result = $this->db_connection->query( $query ); 
        return $result;
    }
    
    function get_email_info($job_id = 'NULL') {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        if (isset($job_id)) {
            $id = $job_id;
        } else {
            $id = $_GET['project_id'];
            //'" . $_GET['job_id'] . "'
        }
        $query = "
        SELECT      j.user_id AS staff_id,
                    j.job_id ,
                    j.customer_id,
                    u.email,
                    u.is_staff,
                    u.user_id
        FROM        `"._DB_PREFIX."job` AS j
        LEFT JOIN   `"._DB_PREFIX."user` AS u
        ON          u.customer_id = j.customer_id
        WHERE		j.job_id = $id
        AND			u.is_staff != 1
        AND			u.user_id != 1 
        LIMIT		1
        ;";
        
        $result = $this->db_connection->query( $query ); 
        return $result;
    }
    
    function get_email_info_contact() {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        $query = "
        SELECT      j.user_id,
                    j.job_id,
                    j.customer_id,
                    c.customer_id,
                    c.primary_user_id,
                    c.customer_name,
                    
                    email_smtp_username,
                    email_smtp_password
        FROM        `"._DB_PREFIX."job` AS j
        LEFT JOIN   `"._DB_PREFIX."customer` AS c
        ON          c.customer_id = j.customer_id
        LEFT JOIN   `"._DB_PREFIX."user` AS u
        ON          c.customer_id = j.customer_id
        WHERE       
        ;";
        
        $result = $this->db_connection->query( $query ); 
        return $result;
    }


 
    
// -------- PROJECTS -------- //
    function special_access($user_id) {
        $Controller = new Controller();
        $Controller->special_access_column_check();
        
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        
        $query = "SELECT    user_id,
                            special_access
                  FROM      `"._DB_PREFIX."user`
                  WHERE     user_id = $user_id";
        
        $result = $this->db_connection->query( $query ); 
        //$row = $result->fetch_assoc();
        //echo $row['special_access'];
        //echo "<strong>" . $user_id . "</strong>";
        return $result;
    }
    
    
    function project_get_invoice_id($project_id) {
        
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        if ($single == 1) {
            $select = "AND i.invoice_id = $id";
        } else {
            $select = '';
        }
        
        $query = "
        SELECT      *, i.name AS invoice_name, 
                    i.status AS invoice_status, 
                    i.date_due AS invoice_date_due,
                    i.date_create AS invoice_date_create,
                    u.name AS user_first,
                    ii.description AS item_description,
                    ii.amount AS item_amount
        FROM        `"._DB_PREFIX."invoice_item` AS ii 
        LEFT JOIN   `"._DB_PREFIX."task` AS t 
        ON          ii.task_id = t.task_id
        LEFT JOIN   `"._DB_PREFIX."invoice` AS i
        ON          i.invoice_id = ii.invoice_id
        LEFT JOIN   `"._DB_PREFIX."user` AS u
        ON          u.customer_id = i.customer_id
        LEFT JOIN   `"._DB_PREFIX."customer` AS c
        ON          c.customer_id = u.customer_id
        LEFT JOIN   `"._DB_PREFIX."job` AS j
        ON          j.job_id = t.job_id
        
        WHERE       j.job_id = $project_id
        GROUP BY    j.job_id
        ORDER BY    i.date_due DESC
        $limit
        ;";
        
        $result = $this->db_connection->query( $query ); 
        return $result;
    }
    
    
    function projects_list($limit='0,20', $single='0', $customer = 'NULL', $status = 'NULL')
    { 
        if ($customer != 'NULL') {
            if ($status != 'NULL' && $status == 'pastDue') {
                $p_status = "AND         j.date_due <= NOW()
                             AND         j.status != 'Completed'";
            } elseif ($status != 'NULL' && $status == 'inProgress') {
                $p_status = "AND         j.date_due >= NOW()
                             AND         j.status != 'Completed'";
            } else {
                $p_status = "";
            }
            $where_customer_id = "WHERE       c.customer_id = '" . $customer . "'
                                  $p_status
                                  GROUP BY    c.customer_id
                                  ";
        } else {
        
        
        $Controller = new Controller();
        $special_access_query = $Controller->special_access($_SESSION['user_id']);
            $row = $special_access_query->fetch_assoc();
            if ($row['special_access'] != 'NULL' && $row['special_access'] != '') {
                $special_access = $row['special_access'];
                $access = "OR (j.job_id IN ($special_access))";
            } else {
                $access = "";
            }
            
        $customer_id = $_SESSION['customer_id'];
        if ($_SESSION['is_staff'] == 1 && $_SESSION['user_id'] != 1) {
            $where_customer_id = "WHERE (user_id = '" . $_SESSION['user_id'] . "') $access";
        } elseif ($_SESSION['user_id'] == 1) {
            $where_customer_id = "WHERE j.customer_id = j.customer_id";
        } else {
            $where_customer_id = "WHERE (j.customer_id = $customer_id) $access";
        }
            
        }
            //SELECT * FROM mytable WHERE id IN (2, 5, 11);
        $user_id = $_SESSION['user_id'];
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($single == 1) {
            $select = "AND job_id = '" . $_GET['project_id'] . "'";
        } else {
            $select = '';
        }
            // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }
        
        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno) {
            //c.customer_name,
									//ii.invoice_id, ii.task_id AS i_task_id,
            $query = "  SELECT      c.customer_id,
                                    c.customer_name,
                                    j.job_id,
                                    j.customer_id,
                                    j.quote_id,
                                    j.hourly_rate,
                                    j.name,
                                    j.type,
                                    j.status,
                                    j.date_quote,
                                    j.date_start,
                                    j.date_due,
                                    j.date_done,
                                    j.date_completed,
                                    j.date_renew,
                                    j.renew_job_id,
                                    j.user_id,
                                    j.default_task_type,
                                    j.currency_id,
                                    j.total_percent_complete,
                                    j.description,
                                    j.create_user_id,
                                    j.update_user_id,
                                    j.date_created,
                                    j.date_updated
                                    
                        FROM        `"._DB_PREFIX."job` as j
                        LEFT JOIN   `"._DB_PREFIX."customer` as c
                        ON          c.customer_id = j.customer_id
                        
                        $where_customer_id 
                        $select 
                        GROUP BY    j.job_id
                        ORDER BY    j.date_created 
                        DESC 
                        LIMIT       $limit;";
/*

                        FROM        `"._DB_PREFIX."job` as j
                        LEFT JOIN   `"._DB_PREFIX."customer` as c
                        ON          c.customer_id = j.customer_id
                        LEFT JOIN   `"._DB_PREFIX."task` as t 
                        ON          t.job_id = j.job_id
                        LEFT JOIN   `"._DB_PREFIX."invoice_item` as ii 
                        ON          ii.task_id = t.task_id
                        */
            //$query = "SELECT * FROM `"._DB_PREFIX."job` $where_customer_id $select ORDER BY date_created DESC LIMIT $limit;";

            $result = $this->db_connection->query( $query );
            return $result;
        }
    }

// -------- PROJECT PAGE -------- //
    function display_project()
    {

        // Setup Database Connection
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
            // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }
        
        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno) {
            
        $Controller = new Controller();
        $special_access_query = $Controller->special_access($_SESSION['user_id']);
            $row = $special_access_query->fetch_assoc();
            if ($row['special_access'] != 'NULL' && $row['special_access'] != '') {
                $special_access = $row['special_access'];
                $access = "OR (job_id IN ($special_access))";
            } else {
                $access = "";
            }
            
            $query = "  SELECT      * 
                        FROM        `"._DB_PREFIX."job` 
                        WHERE       ((customer_id = '" . $_SESSION['customer_id'] . "')
                        $access)
                        AND         job_id = '" . $_GET['project_id'] . "';
                        ";
            //execute the query
            $result = $this->db_connection->query( $query );

            //get number of rows returned
            $num_results = $result->num_rows;
            //this will link us to our add.php to create new record
            //echo "<div><a href='add.php'>Create New Record</a></div>";
            if( $num_results > 0){ 
                //it means there's already a database record
                echo "<table border='1'>";//start table
                //creating our table heading
                echo "<tr>";
                echo "<th>Project Name</th>";
                echo "<th>Type</th>";
                echo "<th>Status</th>";
                echo "<th>TBD</th>";
                echo "<th>TBD</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                //loop to show each records
                while( $row = $result->fetch_assoc() ){
                //extract row
                //this will make $row['name'] to
                //just $name only
                extract($row);
                //creating new table row per record
                echo "<tr>";
                echo "<td>{$name}</td>";
                echo "<td>{$type}</td>";
                echo "<td>{$status}</td>";
                echo "<td>TBD</td>";
                echo "<td>TBD</td>";
                echo "<td>";
                //Link to view Project page
                echo "<a href='project.php?id={$job_id}'>View Project</a>";
                echo " / ";
                echo "</td>";
                echo "</tr>";
                }
                echo "</table>";//end table
                }else{
                //if database table is empty
                echo "<div class='nothing_found'><strong>You currently have no projects listed here.</strong><br>Once projects have been entered, this page will list the 15 most recent projects. You'll recive a notification when there is progress on any of them.</div>";
                
                }

                //disconnect from database
                $result->free();
                $this->db_connection->close();
        }
    }
    
    function get_project_description()
    {
        $Controller = new Controller();
        $special_access_query = $Controller->special_access($_SESSION['user_id']);
            $row = $special_access_query->fetch_assoc();
            if ($row['special_access'] != 'NULL' && $row['special_access'] != '') {
                $special_access = $row['special_access'];
                $access = "OR (job_id IN ($special_access))";
            } else {
                $access = "";
            }
            
        
        $customer_id = $_SESSION['customer_id'];
        if ($_SESSION['is_staff'] == 1) {
            $where_customer_id = "WHERE";
        } else {
            $where_customer_id = "WHERE ((customer_id = '" . $_SESSION['customer_id'] . "') $access) AND";
        }
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
            // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }
        
        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno) {
            
            $query = "  SELECT  * 
                        FROM    `"._DB_PREFIX."job` 
                        $where_customer_id
                                job_id = '" . $_GET['project_id'] . "';";
            //execute the query
            $result = $this->db_connection->query( $query );

            //get number of rows returned
            $num_results = $result->num_rows;
            
            //Check for entries
            if( $num_results > 0){ 

                    while( $row = $result->fetch_assoc() ){
                    //Extract Row (This changes "$row['name']" to just "$name")
                    extract($row);
                    //echo "<p>";
                    echo "<p>" . "{$description}" . "</p>";
                    //echo "</p>";
                    }
            }
                    else{
                    //if database table is empty
                    echo "<p><strong>There is no description for this project yet.</strong><br>This is probably because the project has just been started. Please check back soon.</p>";
                    
                    }
                //disconnect from database
                //$result->free();
                $this->db_connection->close();
        }
    }
    
    function display_project_latest_image($img_class='feature-project-image', $id='', $show_info='1', $url='0', $thumbnail='0', $generate='0')
    {
        $Controller = new Controller();
        $special_access_query = $Controller->special_access($_SESSION['user_id']);
            $row = $special_access_query->fetch_assoc();
            if ($row['special_access'] != 'NULL' && $row['special_access'] != '') {
                $special_access = $row['special_access'];
                $access = "OR (job_id IN ($special_access))";
            } else {
                $access = "";
            }
            
        
        if ($_SESSION['is_staff'] == 1) {
            $where_customer_id = "WHERE";
        } else {
            $where_customer_id = "WHERE ((customer_id = '" . $_SESSION['customer_id'] . "') $access) AND";
        }
        $ucm_url = $_GET['ucm_url'];
        $base_url = $_GET['base_url'];
        if ($id == '') {
            $job_id = $_GET['project_id'];
        }else {
            $job_id = $id;
        }
        // Setup Database Connection
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
            // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }
        
        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno) {
            
            $query = "  SELECT      * 
                        FROM        `"._DB_PREFIX."file` 
                        $where_customer_id 
                                    job_id = '" . $job_id . "' 
                        ORDER BY    file_id DESC 
                        LIMIT       1;";
            //execute the query
            $result = $this->db_connection->query( $query );

            //get number of rows returned
            $num_results = $result->num_rows;
            
            //Check for entries
            if( $num_results > 0){ 
                
                    while( $row = $result->fetch_assoc() ){
                    //Extract Row (This changes "$row['name']" to just "$name")
                    extract($row);
                        if ($generate == '1') {
                            $img_size = '200';
                            if ($this->check_for_thumb($file_path) == 'false') {
                                $this->generate_thumb($ucm_url . $file_path, $img_size);
                            }
                        }
                        
                        if ($thumbnail == '1') {
                            if ($this->check_for_thumb($file_path) == 'true') {
                                //if ($this->check_for_thumb($file_path) == 'false') {
                                //    $this->generate_thumb($ucm_url . $file_path, $img_size);
                                //}
                                $source = $this->retrieve_thumb($file_path);
                            } else {
                            $source = $ucm_url . $file_path;
                            }
                        } else {
                            $source = $ucm_url . $file_path;
                        }
                        
                        if ($url == '1') {
                            if ($thumbnail == '1') {
                                return $source;
                            } else {
                                return $ucm_url . $file_path;
                            }
                            //return $file_path;
                        } else {
                
                    echo "<a href='$ucm_url{$file_path}' data-featherlight='image'><img class='{$img_class}' src='$source'></a>";
                    }
                if ($show_info == '1') {
                echo "<div style='text-align: left; margin-left: 5px; margin-bottom: 15px;'>Name: {$file_name}<BR>Date Uploaded: {$date_created} </div>"; //<BR>Status: <strong>{$status}</strong></div>";
                }
                    }
                    
            }
                    else{
                    //if database table is empty
                    if ($show_info == '1') {
                    echo "<p><strong>There haven't been any files submitted for this project.</strong><br>When there is progress you'll recieve a notification and you can view the latest revisions here.<BR><img style='width: 100%;' src='$base_url/images/no-image.jpg'><BR><BR></p>";
                    }else {
                        if ($url == '1') {
                            return $base_url . '/images/no-image.jpg';
                            //return $file_path;
                        } else {
                        echo "<img style='width: 100%; height: 100%;' src='$base_url/images/no-image.jpg'>";
                        }
                    }
                    }
                //disconnect from database
                $result->free();
                $this->db_connection->close();
        }
    }

    function display_project_images($img_class='thumbnail')
    {
        $Controller = new Controller();
        $special_access_query = $Controller->special_access($_SESSION['user_id']);
            $row = $special_access_query->fetch_assoc();
            if ($row['special_access'] != 'NULL' && $row['special_access'] != '') {
                $special_access = $row['special_access'];
                $access = "OR (job_id IN ($special_access))";
            } else {
                $access = "";
            }
        
        //$customer_id = $_SESSION['customer_id'];
        if ($_SESSION['is_staff'] == 1) {
            $where_customer_id = "WHERE";
        } else {
            $where_customer_id = "WHERE ((customer_id = '" . $_SESSION['customer_id'] . "') $access) AND";
        }
        $ucm_url = $_GET['ucm_url'];
        // Setup Database Connection
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
            // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }
        
        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno) {
            
            $query = "  SELECT      * 
                        FROM        `"._DB_PREFIX."file` 
                        $where_customer_id 
                                    job_id = '" . $_GET['project_id'] . "' 
                        ORDER BY    file_id DESC 
                        LIMIT 1, 9;";
            //execute the query
            $result = $this->db_connection->query( $query );

            //get number of rows returned
            $num_results = $result->num_rows;
            
            //Check for entries
            if( $num_results > 0){ 
                
                    while( $row = $result->fetch_assoc() ){
                    //Extract Row (This changes "$row['name']" to just "$name")
                    extract($row);
                    
                    $img_size = '200';
                        
                    if($this->check_for_thumb($file_path)) {
                        if ($this->check_for_thumb($file_path) == 'false') {
                            $this->generate_thumb($ucm_url . $file_path, $img_size);
                        }
                        $source = $this->retrieve_thumb($file_path);
                        list($width, $height) = getimagesize($source);
                        if ($height > $width){
                            echo "<div class='thumbnail-div-tall'>";
                        } else {
                            echo "<div class='thumbnail-div'>";
                        }
                    } else {
                        $source = $ucm_url . $file_path;
                        echo "<div class='thumbnail-div'>";
                    }
                        
                    
                    echo "<a href='$ucm_url{$file_path}' data-featherlight='image'><img class='{$img_class}' src='$source'></a>";
                    echo "</div>";
                    
                    }
                
                    
            }
                    else{
                    //if database table is empty
                    echo "<div class='nothing_found'><strong>There are no other project files at this time.</strong><br>Previous revisions will be listed here if there are any.</div><BR><BR>";
                    
                    }
                //disconnect from database
                $result->free();
                $this->db_connection->close();
        }
    }
    
    function project_comments_list()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }
        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno) {
            
            $query = "  SELECT      * 
                        FROM        `"._DB_PREFIX."user` AS u 
                        LEFT JOIN   `"._DB_PREFIX."job_discussion` AS j 
                        ON          (u.user_id = j.user_id) 
                        WHERE       job_id = '" . $_GET['project_id'] . "';";
            //execute the query
            $result = $this->db_connection->query( $query );

            //get number of rows returned
            $num_results = $result->num_rows;
            
            //Check for entries
            if( $num_results > 0){ 
                echo "<div class='chat_container'>";
                echo "<div class='image_title'><strong>Comments</strong></div>";

                    while( $row = $result->fetch_assoc() ){
                    //Extract Row (This changes "$row['name']" to just "$name")
                    extract($row);
                        if ($job_discussion_id > 0){
                          
                    echo "<div style='
                    width: 40%; 
                    border: 1px solid #000000; 
                    margin: 5px; padding-bottom: 20px; 
                    padding-top: 5px; 
                    padding-left: 5px; 
                    padding-right: 5px; 
                    -webkit-border-radius: 8px;
                    -webkit-border-bottom-right-radius: 0;
                    -moz-border-radius: 8px;
                    -moz-border-radius-bottomright: 0;
                    border-radius: 8px;
                    border-bottom-right-radius: 0;'>
                    {$note}<BR>
                    <span style='
                    float: right; 
                    font-size: 10pt; 
                    font-style: italic;'>
                    <strong>-{$name} {$last_name}</strong></span></div>";

                echo "</div>";
                        }
                    }
            }
            
                    else{
                    //if database table is empty
                    //echo "<div class='nothing_found'><strong>There are no comments yet.</strong><br>Please leave a comment to let the designer know your thoughts.</div>";
                    
                    }
                //disconnect from database
                $result->free();
                $this->db_connection->close();
        }
    }
    
    function ajax_project_comments_query()
    {
        
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
                     
        $query = "  SELECT      * 
                    FROM        `"._DB_PREFIX."user` AS u 
                    LEFT JOIN   `"._DB_PREFIX."job_discussion` AS j 
                    ON          (u.user_id = j.user_id) 
                    WHERE       job_id = '" . $_GET['project_id'] . "' 
                    ORDER BY    job_discussion_id DESC;";
        $result = $this->db_connection->query( $query );
        return $result;
        
    }
    
    function ajax_project_comments_submit()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                    if ($this->db_connection->connect_error) {
                        die("Connection failed: " . $this->db_connection->connect_error);
                    } 

        if (!empty($_POST['user_id']) AND !empty($_POST['comment']) AND !empty($_POST['id']))
        {
            $user_id = mysqli_real_escape_string($this->db_connection, $_POST['user_id']);
            $comment = mysqli_real_escape_string($this->db_connection, $_POST['comment']);
            //$comment = mysqli_real_escape_string($this->db_connection, $_POST['comment']);

            $query = "INSERT INTO `"._DB_PREFIX."job_discussion` (job_id, user_id, note, create_user_id, date_created) VALUES ('" . $_POST['id'] . "', '" . $_POST['user_id'] . "', '" . $comment . "', '" . $_POST['user_id'] . "', NOW())";	
            $result = $this->db_connection->query( $query );
            
            include("classes/post-notification.php");
        } 
    }
    
    function project_task_list($single = '') {
        if ($_SESSION['is_staff'] == 1) {
            if(isset($single) && $single != '') {
                $where_customer_id = "WHERE task_id = '" . $single . "' AND";
            } else {
            $where_customer_id = "WHERE ";
            }
        } else {
            $where_customer_id = "WHERE       customer_id = '" . $_SESSION['customer_id'] . "' AND";
        }
            
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        $project_id = $_GET['project_id'];
        $query = "
        SELECT      t.job_id,
                    t.task_id,
                    t.task_order,
                    t.amount,
                    t.description,
                    t.long_description,
                    t.taxable,
                    t.fully_completed,
                    t.staff_hours,
                    t.staff_hours_mins,
                    t.hours,
                    t.hours_mins,
                    t.create_user_id,
                    t.update_user_id,
                    t.date_done,
                    t.date_due,
                    x.percent,
                    j.hourly_rate
        FROM        `"._DB_PREFIX."task` AS t
        LEFT JOIN   `"._DB_PREFIX."job` AS j
        ON          j.job_id = t.job_id
        LEFT JOIN   `"._DB_PREFIX."job_tax` AS x
        ON          x.job_id = t.job_id
        $where_customer_id
                    t.job_id = '" . $_GET['project_id'] . "'
        ORDER BY    task_order DESC
        ;";
        
        $result = $this->db_connection->query( $query ); 
        
        return $result;
    }
    
    function job_tax($project_id) {
        if ($_SESSION['is_staff'] == 1) {
            if(isset($single) && $single != '') {
                $where_customer_id = "WHERE task_id = '" . $single . "' AND";
            } else {
            $where_customer_id = "WHERE ";
            }
        } else {
            $where_customer_id = "WHERE       customer_id = '" . $_SESSION['customer_id'] . "' AND";
        }
            
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        $project_id = $_GET['project_id'];
        $query = "
        SELECT      t.job_id,
                    t.task_id,
                    t.task_order,
                    t.amount,
                    
                    x.percent,
                    j.hourly_rate,
                    SUM(t.hours) AS total_hours,
                    SUM(t.amount) AS total_amount,
                    (SELECT
                    SUM(t.amount) AS total_amount_taxable
                    FROM `"._DB_PREFIX."task` as t
                    WHERE t.hours = 0
                    AND  t.taxable = 1
                    AND t.job_id = $project_id) AS total_amount_taxable,
                    (SELECT
                    SUM(t.hours) AS total_hours_taxable
                    FROM `"._DB_PREFIX."task` as t
                    WHERE t.taxable = 1
                    AND t.job_id = $project_id) AS total_hours_taxable
        FROM        `"._DB_PREFIX."task` AS t
        LEFT JOIN   `"._DB_PREFIX."job` AS j
        ON          j.job_id = t.job_id
        LEFT JOIN   `"._DB_PREFIX."job_tax` AS x
        ON          x.job_id = t.job_id
        $where_customer_id
                    t.job_id = '" . $project_id . "'
        ORDER BY    task_order DESC
        ;";
        
        $result = $this->db_connection->query( $query ); 
        
        return $result;
    }
    
    function write_project() {
        
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        $project_task_id = $_POST['project_task_id'];
    $task_query = $this->project_task_list($project_task_id); 
    $task_results = $task_query->num_rows; 
    if( $task_results > 0){
      $row = $task_query->fetch_assoc();
      
        //if (isset($_POST['quote_task_id'])) {
            //$quote_task_id = $_POST['quote_task_id'];
        //} else {
        //    $quote_task_id = $row['quote_task_id'];
        //}
        $task_id = mysqli_real_escape_string($this->db_connection, $_POST['project_task_id']);
        $project_id = mysqli_real_escape_string($this->db_connection, $_POST['project_id']);
        $hours = mysqli_real_escape_string($this->db_connection, $_POST['hours']);
        $amount = mysqli_real_escape_string($this->db_connection, $_POST['amount']);
        if (isset($_POST['taxable'])) {
            $taxable = mysqli_real_escape_string($this->db_connection, $_POST['taxable']);
        } else {
            $taxable = 0;
        }
        if (isset($_POST['billable'])) {
            $billable = mysqli_real_escape_string($this->db_connection, $_POST['billable']);
        } else {
            $billable = 1;
        }
        $description = mysqli_real_escape_string($this->db_connection, $_POST['description']);
        $long_description = mysqli_real_escape_string($this->db_connection, $_POST['long_description']);
        
        $manual_task_type = -1;
        $user_id = mysqli_real_escape_string($this->db_connection, $_POST['assigned_user']);
        $task_order = mysqli_real_escape_string($this->db_connection, $_POST['task_order']);
        
        $update_user_id = $_SESSION['user_id'];
        
        if (isset($_POST['fully_completed'])) {
            $fully_completed = mysqli_real_escape_string($this->db_connection, $_POST['fully_completed']);
        } else {
            $fully_completed = 0;
        }
        
        //$due_date = $_POST['due_date'];
        if (isset($_POST['date_done']) && $_POST['date_done'] != $row['date_done']) {
            $date_complete = $_POST['date_done'];
            $date_done = "date_done = '" . $date_complete . "',";
        } elseif ($row['fully_completed'] == 0 && $_POST['fully_completed'] == 1) {
            $date_done = "date_done = NOW(),";
        } else {
            $date_done = "";
        }
        
        
        
        
        if ($row['create_user_id'] > 0) {
            $create_user_id = $row['create_user_id'];
        } else {
            $create_user_id = mysqli_real_escape_string($this->db_connection, $_SESSION['user_id']);
        }
        $create_user_id_write = "create_user_id = '" . $create_user_id . "',";
        /*if ($row['date_created'] > 0) {
            $date_created = $row['date_created'];
        } else {
            $date_created = 'NOW()';
        }
        $date_updated = "NOW()";*/
        
        
            
        
        //if (isset($enc_pass) && $enc_pass = $pass_check){
            /*if (constant('DEMO_MODE') == 'on') {
                $query = "";
            } else { */
            $query = "  UPDATE      `"._DB_PREFIX."task` 
                        SET         hours = '" . $hours . "',
                                    amount = '" . $amount . "',
                                    taxable = '" . $taxable . "',
                                    description = '" . $description . "',
                                    long_description = '" . $long_description . "',
                                    
                                    $create_user_id_write
                                    
                                    fully_completed = '" . $fully_completed . "',
                                    
                                    $date_done
                                    
                                    update_user_id = '" . $update_user_id . "',
                                    date_created = (CASE WHEN date_created IS null THEN NOW() ELSE date_created END),
                                    date_updated = NOW()
                                    
                        WHERE       task_id = '" . $task_id . "'
                        ";	
            
            if ($this->db_connection->query( $query )) { 
                echo "<script>window.location = 'index.php?page=staff&staff_tab=2&project_id=". $project_id ."'</script>";
            }
            if (!$this->db_connection->query( $query )) 
            { 
                echo '<BR><strong>FAIL</strong><BR>'; 
                echo 'task_id - ' . $task_id . '<BR>';
                echo 'update_user_id - ' . $update_user_id . '<BR>';
                echo 'date_done - ' . $date_done . '<BR>';
                echo 'fully_completed - ' . $fully_completed . '<BR>';
                echo 'long_description - ' . $long_description . '<BR>';
                echo 'description - ' . $description . '<BR>';
                echo 'taxable - ' . $taxable . '<BR>';
                echo 'amount - ' . $amount . '<BR>';
                echo 'hours - ' . $hours . '<BR>';
            }
        
            //}
            
        //} else {
        //    echo 'There was an error. You may have entered your current password incorectly.';
        //}
    }
    }
    
// -------- INVOICES -------- //
    function invoice_list($single='0', $invoice_id='NULL', $customer = 'NULL', $status = 'NULL')
    {
        
        if ($customer != 'NULL') {
            if ($status != 'NULL' && $status == 'pastDue') {
                $i_status = "AND         i.date_due <= NOW()
                             AND         i.status != 'Paid'";
            } elseif ($status != 'NULL' && $status == 'inProgress') {
                $i_status = "AND         i.date_due >= NOW()
                             AND         i.status != 'Paid'";
            } else {
                $i_status = "";
            }
            $where_customer_id = "WHERE       c.customer_id = '" . $customer . "'
                                  $i_status ";
            $limit = "LIMIT     0, 1";
        } else {
            
        $limit = "";
        $customer_id = $_SESSION['customer_id'];
        if ($_SESSION['is_staff'] == 1 && $_SESSION['user_id'] != 1) {
            $where_customer_id = "WHERE       (i.customer_id = i.customer_id OR j.user_id = '" . $_SESSION['user_id'] . "')";
        } elseif ($_SESSION['user_id'] == 1) {
            $where_customer_id = "WHERE       i.customer_id = i.customer_id";
        } else {
            $where_customer_id = "WHERE       i.customer_id = $customer_id";
        }
        
        }
            
        if (isset($group_by)) {
            $group = '';
        } else {
            $group = 'GROUP BY    j.job_id';
        }
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        if (isset($invoice_id) && $invoice_id != 'NULL') {
            $id = $invoice_id;
        } elseif (isset($invoice_id) && $invoice_id == 'NULL') {
            $id = 'i.invoice_id';
        } else {
            $id = $_GET['invoice_id'];
        }
        if ($single == 1) {
            $select = "AND i.invoice_id = $id";
        } else {
            $select = '';
        }
        
        $query = "
        SELECT      *, i.name AS invoice_name, 
                    i.status AS invoice_status, 
                    i.date_due AS invoice_date_due,
                    i.date_create AS invoice_date_create,
                    u.name AS user_first,
                    ii.description AS item_description,
                    ii.amount AS item_amount
        FROM        `"._DB_PREFIX."invoice_item` AS ii 
        LEFT JOIN   `"._DB_PREFIX."task` AS t 
        ON          ii.task_id = t.task_id
        LEFT JOIN   `"._DB_PREFIX."invoice` AS i
        ON          i.invoice_id = ii.invoice_id
        LEFT JOIN   `"._DB_PREFIX."user` AS u
        ON          u.customer_id = i.customer_id
        LEFT JOIN   `"._DB_PREFIX."customer` AS c
        ON          c.customer_id = u.customer_id
        LEFT JOIN   `"._DB_PREFIX."job` AS j
        ON          j.job_id = t.job_id
        $where_customer_id
        $select
        GROUP BY    i.invoice_id
        ORDER BY    i.date_due DESC
        $limit
        ;";
        
        
        $result = $this->db_connection->query( $query ); 
        return $result;
    }
    
    public static function invoice_link($invoice_id,$h=false){
        if($h){
            return md5('s3cret7hash for invoice '._UCM_SECRET.' '.$invoice_id);
        }
            $ucm_url = $_GET['ucm_url'];
            $ext = '/ext.php?';
            $result = ($ucm_url.$ext.'m=invoice&h=public&i='.$invoice_id.'&hash='.self::invoice_link($invoice_id,true));
            return $result;
    }
    
// -------- QUOTES -------- //
    function quote_description() {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        $quote_id = $_GET['quote_id'];
            
        $query = "
        SELECT      *
        FROM		`"._DB_PREFIX."quote`
        WHERE		quote_id = $quote_id
        LIMIT		1
        ;";
        
        $result = $this->db_connection->query( $query ); 
        $row = $result->fetch_assoc();
        //$description = mysqli_real_escape_string($this->db_connection, $row['description']);
        $description = htmlspecialchars_decode ($row['description']);
        if ($description != '') {
            return $description;
        } else {
            return 'false';
        }
    }
    
    function default_task_type($rate='false') {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        $query = "
        SELECT
                    (SELECT		case when u.key = 'default_task_type' then u.val end as default_task_type
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'default_task_type' then u.val end) != 'NULL') AS default_task_type,
                    (SELECT		case when u.key = 'hourly_rate' then u.val end as hourly_rate
                    FROM      	`"._DB_PREFIX."config` AS u
                    WHERE		(case when u.key = 'hourly_rate' then u.val end) != 'NULL') AS hourly_rate
        FROM		`"._DB_PREFIX."config`
        LIMIT		1
        ;";
        
        $result = $this->db_connection->query( $query ); 
        $row = $result->fetch_assoc();
        if ($rate != 'false') {
        return $row['hourly_rate'];
        } else {
        return $row['default_task_type'];
        }
    }
    
    
    function quote_list($customer_id = 'NULL', $quote_id = 'NULL', $task_type='false')
    {   
        if (isset($quote_id) && $quote_id != 'NULL') {
            $_GET['quote_id'] = $quote_id;
        }
        // This may come into play later on.
        // Something to do with Admin access...
        /*if (isset($_SESSION['access_id'])) {
            $customer_id = $_SESSION['access_id'];
        } else {
            $customer_id = $_SESSION['customer_id'];
        }*/
        
        if ($customer_id != 'NULL') {
            $where_customer_id = "WHERE       q.customer_id = '" . $customer_id . "'
                                  AND         q.date_approved = '0000-00-00'
                                  GROUP BY    q.quote_id
                                  ORDER BY    q.quote_id DESC
                                  LIMIT       0, 1";
        } else {
        
        if ($_SESSION['is_staff'] == 1 && $_SESSION['user_id'] != 1) {
            $where_customer_id = "WHERE       q.user_id = '" . $_SESSION['user_id'] . "'
                                  GROUP BY    q.quote_id
                                  ORDER BY    q.quote_id DESC";
        } elseif ($_SESSION['user_id'] == 1) {
            $where_customer_id = "GROUP BY    q.quote_id
                                  ORDER BY    q.quote_id DESC";
        } else {
            $where_customer_id = "WHERE       q.customer_id = '" . $_SESSION['customer_id'] . "'
                                  GROUP BY    q.quote_id
                                  ORDER BY    q.quote_id DESC";
        }
            
        }
        
        if (isset($_GET['quote_id'])) {
            $where = "WHERE       q.quote_id = '" . $_GET['quote_id'] . "'";
            $and_task_id = "AND       t.quote_id = '" . $_GET['quote_id'] . "'";
        } else {
            $where = $where_customer_id;
            $and_task_id = "";
        }
        
        
        
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        if ($task_type != 'false') {
            $task_type = "AND       t.manual_task_type = '" . $task_type . "'";
        } else {
            $task_type = "";
        }
        
        $query = "
        SELECT      *, 
                    (SELECT
                    SUM(t.hours) AS total_hours
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE t.manual_task_type = 1
                    $and_task_id) AS total_task_quantity,
                    (SELECT
                    SUM(t.amount) AS total_amount
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE t.manual_task_type = 1
                    $and_task_id) AS total_task_quantity_amount,
                    (SELECT
                    SUM(t.amount)*SUM(t.hours) AS total_amount
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE t.manual_task_type = 1
                    $and_task_id) AS total_quantity,
                    
                    (SELECT
                    SUM(t.hours) AS total_hours
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE (t.manual_task_type = -1
                    OR    t.manual_task_type = 0)
                    $and_task_id) AS total_hours,
                    (SELECT
                    SUM(t.amount) AS total_amount
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE (t.manual_task_type = -1
                    OR    t.manual_task_type = 0)
                    $and_task_id) AS hourly_amount,
                    (SELECT
                    (SUM(t.hours)*q.hourly_rate) AS total_amount
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE (t.manual_task_type = -1
                    OR    t.manual_task_type = 0)
                    $and_task_id) AS total_hourly,
                    
                    (SELECT
                    SUM(t.amount) AS total_amount
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE t.manual_task_type = 2
                    $and_task_id) AS total_amount,
        
                    x.name AS tax_name,
                    x.percent AS tax_percent,
                    q.name AS name,
                    q.user_id,
                    q.hourly_rate,
                    q.description AS quote_description,
                    t.amount AS task_amount,
                    t.hours AS task_hours,
                    
                    (SELECT
                    SUM(t.amount) AS total_amount_taxable
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE t.hours = 0
                    $and_task_id) AS total_amount_taxable
                    
        FROM        `"._DB_PREFIX."quote` AS q
        LEFT JOIN   `"._DB_PREFIX."quote_task` AS t
        ON          q.quote_id = t.quote_id
        LEFT JOIN   `"._DB_PREFIX."quote_tax` AS x
        ON          x.quote_id = t.quote_id
        LEFT JOIN   `"._DB_PREFIX."customer` AS c
        ON          c.customer_id = q.customer_id
        $where
        $task_type
        ;";
        /*
                    (SELECT
                    SUM(t.hours) AS total_hours
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE t.manual_task_type = 1
                    $and_task_id) AS total_task_quantity,
                    (SELECT
                    SUM(t.amount) AS total_amount
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE t.manual_task_type = 1
                    $and_task_id) AS total_task_quantity_amount,
                    (SELECT
                    SUM(t.amount)*SUM(t.hours) AS total_amount
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE t.manual_task_type = 1
                    $and_task_id) AS total_quantity,
                    
                    (SELECT
                    SUM(t.hours) AS total_hours
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE (t.manual_task_type = -1
                    OR    t.manual_task_type = 0)
                    $and_task_id) AS total_hours,
                    (SELECT
                    SUM(t.amount) AS total_amount
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE (t.manual_task_type = -1
                    OR    t.manual_task_type = 0)
                    $and_task_id) AS hourly_amount,
                    (SELECT
                    (SUM(t.hours)*q.hourly_rate) AS total_amount
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE (t.manual_task_type = -1
                    OR    t.manual_task_type = 0)
                    $and_task_id) AS total_hourly,
                    
                    (SELECT
                    SUM(t.amount) AS total_amount
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE t.manual_task_type = 2
                    $and_task_id) AS total_amount,
        
                    x.name AS tax_name,
                    q.name AS name,
                    q.user_id,
                    q.hourly_rate,
                    t.amount AS task_amount,
                    t.hours AS task_hours,
                    
                    (SELECT
                    SUM(t.amount) AS total_amount_taxable
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE t.hours = 0
                    $and_task_id) AS total_amount_taxable
        
        */
        
        $result = $this->db_connection->query( $query ); 
        //$num_results = $result->num_rows;
        //echo $num_results;
        return $result;
    }
    
    function quote_task_list($single = '')
    {
        if ($_SESSION['is_staff'] == 1) {
            if(isset($single) && $single != '') {
                $where_customer_id = "WHERE quote_task_id = '" . $single . "' AND";
            } else {
            $where_customer_id = "WHERE ";
            }
        } else {
            $where_customer_id = "WHERE       customer_id = '" . $_SESSION['customer_id'] . "' AND";
        }
            
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        $query = "
        SELECT      *
        FROM        `"._DB_PREFIX."quote` AS q
        LEFT JOIN   `"._DB_PREFIX."quote_task` AS t
        ON          q.quote_id = t.quote_id
        $where_customer_id
                    q.quote_id = '" . $_GET['quote_id'] . "'
        ORDER BY    q.quote_id DESC
        ;";
        
        $result = $this->db_connection->query( $query ); 
        
        return $result;
    }
    
    public static function quote_link($quote_id,$h=false){
        if($h){
            return md5('s3cret7hash for quote '._UCM_SECRET.' '.$quote_id);
        }
            $ucm_url = $_GET['ucm_url'];
            $ext = '/ext.php?';
            return ($ucm_url.$ext.'m=quote&h=public&i='.$quote_id.'&hash='.self::quote_link($quote_id,true));
    }
    
    function quote_get_tax_amount($quote_id)
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        $query = "
        SELECT      t.quote_id,
                    SUM(t.hours) AS total_hours_taxable,
                    (SELECT
                    SUM(t.amount) AS total_amount_taxable
                    FROM `"._DB_PREFIX."quote_task` as t
                    WHERE t.hours = 0
                    AND t.quote_id = $quote_id) AS total_amount_taxable,
                    t.quote_task_id,
                    t.taxable,
                    q.hourly_rate,
                    x.percent
        FROM        `"._DB_PREFIX."quote_task` as t
        LEFT JOIN   `"._DB_PREFIX."quote` as q
        ON          t.quote_id = q.quote_id
        LEFT JOIN   `"._DB_PREFIX."quote_tax` as x
        ON          t.quote_id = x.quote_id
        WHERE       t.quote_id = $quote_id
        AND         taxable = 1
        ";
            
        $result = $this->db_connection->query( $query ); 
        return $result;

    }
    
    function write_quote() {
        
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        $quote_task_id = $_POST['quote_task_id'];
    $task_query = $this->quote_task_list($quote_task_id); 
    $task_results = $task_query->num_rows; 
    if( $task_results > 0){
      $row = $task_query->fetch_assoc();
      
        //if (isset($_POST['quote_task_id'])) {
            //$quote_task_id = $_POST['quote_task_id'];
        //} else {
        //    $quote_task_id = $row['quote_task_id'];
        //}
        $task_id = mysqli_real_escape_string($this->db_connection, $_POST['quote_task_id']);
        $quote_id = mysqli_real_escape_string($this->db_connection, $_POST['quote_id']);
        $hours = mysqli_real_escape_string($this->db_connection, $_POST['hours']);
        $amount = mysqli_real_escape_string($this->db_connection, $_POST['amount']);
        if (isset($_POST['taxable'])) {
            $taxable = mysqli_real_escape_string($this->db_connection, $_POST['taxable']);
        } else {
            $taxable = 0;
        }
        if (isset($_POST['billable'])) {
            $billable = mysqli_real_escape_string($this->db_connection, $_POST['billable']);
        } else {
            $billable = 1;
        }
        $description = mysqli_real_escape_string($this->db_connection, $_POST['description']);
        $long_description = mysqli_real_escape_string($this->db_connection, $_POST['long_description']);
        echo $long_description;
        $manual_task_type = -1;
        $user_id = mysqli_real_escape_string($this->db_connection, $_POST['assigned_user']);
        $task_order = mysqli_real_escape_string($this->db_connection, $_POST['task_order']);
        
        $update_user_id = $_SESSION['user_id'];
        
    
        if ($row['create_user_id'] > 0) {
            $create_user_id = $row['create_user_id'];
        } else {
            $create_user_id = mysqli_real_escape_string($this->db_connection, $_SESSION['user_id']);
        }
        $create_user_id_write = "create_user_id = '" . $create_user_id . "',";
        /*if ($row['date_created'] > 0) {
            $date_created = $row['date_created'];
        } else {
            $date_created = 'NOW()';
        }
        $date_updated = "NOW()";*/
        
    
            
        
        //if (isset($enc_pass) && $enc_pass = $pass_check){
            /*if (constant('DEMO_MODE') == 'on') {
                $query = "";
            } else { */
            $query = "  UPDATE      `"._DB_PREFIX."quote_task` 
                        SET         quote_id = '" . $quote_id . "',
                                    hours = '" . $hours . "',
                                    amount = '" . $amount . "',
                                    taxable = '" . $taxable . "',
                                    billable = '" . $billable . "',
                                    description = '" . $description . "',
                                    long_description = '" . $long_description . "',
                                    manual_task_type = '" . $manual_task_type . "',
                                    user_id = '" . $user_id . "',
                                    task_order = '" . $task_order . "',
                                    
                                    $create_user_id_write
                                    
                                    update_user_id = '" . $update_user_id . "',
                                    date_created = (CASE WHEN date_created IS null THEN NOW() ELSE date_created END),
                                    date_updated = NOW()
                                    
                        WHERE       quote_task_id = '" . $task_id . "'
                        ";	
            
            if ($this->db_connection->query( $query )) { 
                echo "<script>window.location = 'index.php?page=staff&staff_tab=1&quote_id=". $quote_id ."'</script>";
            }
            if (!$this->db_connection->query( $query )) { echo '<BR>fail'; }
        
            //}
            
        //} else {
        //    echo 'There was an error. You may have entered your current password incorectly.';
        //}
    }
    }
    
    
    
// -------- INVOICE & QUOTE PAGES -------- //
    function task_list()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        
        $query = "
        SELECT      *
        FROM        `"._DB_PREFIX."invoice` AS i
        LEFT JOIN   `"._DB_PREFIX."invoice_item` AS ii
        ON          i.invoice_id = ii.invoice_id
        WHERE       i.invoice_id = '" . $_GET['invoice_id'] . "'
        ORDER BY    task_order ASC
        ;";
        
        $result = $this->db_connection->query( $query ); 
        
        return $result;
        
    }
    
    function task_list_subtotal()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        //$tax='NULL', $total='NULL'
        /*$query = "
        SELECT      *
        FROM        `"._DB_PREFIX."invoice` AS i
        LEFT JOIN   `"._DB_PREFIX."invoice_item` AS ii
        ON          i.invoice_id = ii.invoice_id
        WHERE       i.invoice_id = '" . $_GET['invoice_id'] . "'
        ORDER BY    task_order ASC
        ;";
        */

        $query = "
        SELECT      ii.task_id,
                    ii.invoice_id,
                    i.invoice_id,
                    i.c_total_amount,
                    t.task_id,
                    t.job_id,
                    SUM(ii.amount) AS sum_total,
                    percent,
                    jt.job_id
        FROM        `"._DB_PREFIX."invoice_item` AS ii 
        LEFT JOIN   `"._DB_PREFIX."task` AS t 
        ON          ii.task_id = t.task_id
        LEFT JOIN   `"._DB_PREFIX."invoice` AS i
        ON          i.invoice_id = ii.invoice_id
        LEFT JOIN   `"._DB_PREFIX."job_tax` AS jt
        ON          jt.job_id = t.job_id
        WHERE       i.invoice_id = '" . $_GET['invoice_id'] . "'
        ;";
            
        $result = $this->db_connection->query( $query ); 
        
            $row = $result->fetch_assoc();
            return $row['sum_total'];

    }
    
 /*   function project_comments_submit()
    {
        
        if (isset($_POST['comment'])){
                    
                    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                    if ($this->db_connection->connect_error) {
                        die("Connection failed: " . $this->db_connection->connect_error);
                    } 
                    $comment = mysqli_real_escape_string($this->db_connection, $_POST['comment']);
                        
                    $query = "INSERT INTO `"._DB_PREFIX."job_discussion` (job_id, user_id, note, create_user_id, date_created) VALUES ('" . $_GET['project_id'] . "', '" . $_SESSION['user_id'] . "', '" . $comment . "', '" . $_SESSION['user_id'] . "', NOW())";
                    if ($this->db_connection->query($query) === TRUE) {
                        //echo "New record created successfully";
                        echo "<script>window.location.assign('../project.php?id=";
                        echo "{$_GET['project_id']}')</script>";
                    } else {
                        echo "Error: " . $query . "<br>" . $this->db_connection->error;
                    }
                $this->db_connection->close();
                }
    }*/
    
    
    
// -------- GRAVATAR -------- //
    //Old code. Not working all the way.
    /*function avatar($mail, $size = 60){
        $url = "http://www.gravatar.com/avatar/";
        $url .= md5( strtolower( trim( $mail ) ) );
        // $url .= "?d=" . urlencode( $default );
        $url .= "&s=&d=identicon" . $size;
        return $url;
    }*/
    function avatar( $email, $s = 80, $d = 'identicon', $r = 'g', $img = false, $atts = array() ) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
        $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
        }
        return $url;
    }
 
    

// -------- TIME ZONE -------- //
function formatOffset($offset) {
        $hours = $offset / 3600;
        $remainder = $offset % 3600;
        $sign = $hours > 0 ? '+' : '-';
        $hour = (int) abs($hours);
        $minutes = (int) abs($remainder / 60);

        if ($hour == 0 AND $minutes == 0) {
            $sign = ' ';
        }
        return $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) .':'. str_pad($minutes,2, '0');

}

    
// -------- TO DO -------- //
    // Projects page - File approval
    function approve_file()
    {
        //Create form
        //Recieve from "signed by" text box
        //Recieve from "agree" checkbox
        //Submit button -> Writes to database
    }
    // List for downloads on projects that have been paid for
    function downloads_list()
    {
        //Provide a list of available downloads.
        //Show download link for files with paid invoice
        //Link to invoice for unpaid projects
    }
    // Will pull images from UCM and generate thumbnails if none exist.
    function generate_thumbnails()
    {
        //Pull from UCM file link
        //Figure out if thumbnail exists for a file
        //Convert to thumbnail and store on CP
        //If thumbnail exists on CP replace thumbnail previews on CP pages
    }

}
?>