<?php
/* ---------------- Simple Login Script ---------------- */
/* ------ Credit goes to http://www.php-login.net ------ */
/* -- Logs in with session data rather than DB writes -- */
class Login
{
    private $db_connection = null;
    public $errors = array();
    public $messages = array();
    public function __construct()
    {
        //if (session_status() == PHP_SESSION_NONE) {
        //    session_start();
        //}
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }

    private function dologinWithPostData()
    {
        // check login form contents
        if (empty($_POST['email'])) {
            $this->errors[] = "<div class='due-date' 
                        style='background-color: #909090; color: f5f5f5; font-size: 20px; font-weight: 700;'>
                        Username field was empty.</div>";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "<div class='due-date' 
                        style='background-color: #909090; color: f5f5f5; font-size: 20px; font-weight: 700;'>
                        Password field was empty.</div>";
        } elseif (!empty($_POST['email']) && !empty($_POST['user_password'])) {

            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }
            if (!$this->db_connection->connect_errno) {
                
                $email = $this->db_connection->real_escape_string($_POST['email']);
                $sql = "SELECT      * 
                        FROM        `"._DB_PREFIX."user` 
                        WHERE       email = '" . $email . "'
                        ;";
                
                
                $result_of_login_check = $this->db_connection->query($sql);

                if ($result_of_login_check->num_rows >= 1) {
                    $result_row = $result_of_login_check->fetch_object();
					if (md5($_POST['user_password']) === $result_row->password || $_POST['user_password'] == $result_row->password) {
                        if ($result_row->user_id == '1') {
                            $is_staff = 1;
                        } elseif ($result_row->is_staff == '-1') {
                            $is_staff = 0;
                        } else {
                            $is_staff = $result_row->is_staff;
                        }
                        $_SESSION['email'] = $result_row->email;
                        $_SESSION['name'] = $result_row->name;
                        $_SESSION['last_name'] = $result_row->last_name;
                        $_SESSION['user_id'] = $result_row->user_id;
                        $_SESSION['is_staff'] = $is_staff;
                        $_SESSION['user_login_status'] = 1;
                        if ($is_staff == 1) {
                            $_SESSION['customer_id'] = "customer_id";
                        } elseif ($result_of_login_check->num_rows > 1) {
                                //include("views/login-select.php");
                                echo "<script>window.location = 'index.php?page=login-select'</script>";
                        } else {
                                $_SESSION['customer_id'] = $result_row->customer_id;
                        }
                        
                    } else {
                        $this->errors[] = "<div class='due-date' 
                        style='background-color: #909090; color: f5f5f5; font-size: 20px; font-weight: 700;'>
                        Wrong password. Please try again. </div>";
                    }
                } else {
                    $this->errors[] = "<div class='due-date' 
                        style='background-color: #909090; color: f5f5f5; font-size: 20px; font-weight: 700;'>
                        This user does not exist.</div>";
                }
            } else {
                $this->errors[] = "<div class='due-date' 
                        style='background-color: #909090; color: f5f5f5; font-size: 20px; font-weight: 700;'>
                        There was a database connection problem. Please contact the administrator for help.</div>";
            }
        }
    }

    // Logout
    public function doLogout()
    {
        // delete the session of the user
        if (isset($_SESSION)) {
        $_SESSION = array();
        session_destroy();
        // return a little feeedback message
        $this->messages[] = "<div class='due-date' style='background-color: #909090; color: f5f5f5; font-size: 20px; font-weight: 700;'>You have been logged out.</div>";
        }
    }

    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
            return false;
    }
}
