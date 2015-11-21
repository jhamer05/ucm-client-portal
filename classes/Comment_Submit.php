<?php
session_start();
?>
<?php
require_once("../config/config.php");
require_once("login.php");
require_once("controller.php");

        $customer_id = $_SESSION['user_id'];
        $project_id = $_GET['id'];
        $ucm_url = $_GET['ucm_url'];
print $project_id;
        // Setup Database Connection
        //if(isset($_POST['submit'])){
                if (isset($_POST['comment'])){
                    
                    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                    if ($db_connection->connect_error) {
                        die("Connection failed: " . $db_connection->connect_error);
                    } 
                    $comment = mysqli_real_escape_string($db_connection, $_POST['comment']);
                        
                    $query = "INSERT INTO `"._DB_PREFIX."job_discussion` (job_id, user_id, note, create_user_id, date_created) VALUES ('" . $_GET['id'] . "', '" . $_SESSION['user_id'] . "', '" . $comment . "', '" . $_SESSION['user_id'] . "', NOW())";
                    if ($db_connection->query($query) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $query . "<br>" . $db_connection->error;
                    }
                $db_connection->close();
                }
    
          


?>