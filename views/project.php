<?php
$id = $_GET['project_id'];
?>

<?php

$client_access_query = $Controller->projects_list('0,1', '1');
$rowC = $client_access_query->fetch_assoc();

    if ($rowC['customer_id'] == $_SESSION['customer_id'] || $_SESSION['is_staff'] == 1) {
        $client_access = 1;
    } else {
        $client_access = 0;
    }
    
//$Controller = new Controller();
$special_access_query = $Controller->special_access($_SESSION['user_id']);
$row = $special_access_query->fetch_assoc();
    if ($row['special_access'] != 'NULL' && $row['special_access'] != '') {
        $special_access_values = explode(',',$row['special_access']);
        if (in_array("$id", $special_access_values)) {
            $grant_access = 1;
        } else {
            $grant_access = 0;
        }
    } 

    if ($client_access == 1){
        $grant_access = 1;
    } elseif ($client_access == 0) {
            $grant_access = 0;
    }
if ($grant_access == '1') {


?>
    <?php $projects_query = $Controller->projects_list('0,1', '1'); ?>
    <?php while($row = $projects_query->fetch_assoc()){ ?>
            <div class="wrap-header">
                <h2 class="wrap-title" style="margin-bottom: -2px;">Project - (<?php echo $row['name']; ?>)</h2>
            </div>
            <div >
                <table style="width: 100%">
                <tr class='list-header'>
                <td style="padding-bottom: 2px;">Project Name</th>
                <td style="padding-bottom: 2px;">Type</th>
                <td style="padding-bottom: 2px;">Status</th>
                <td style="padding-bottom: 2px;">Amount Due</th>
                </tr>
                <tr class="single-list-item">
                <td style="border-right: 0px solid; border-top: 0px solid;"><?php echo $row['name']; ?></td>
                <td style="border-right: 0px solid; border-top: 0px solid;"><?php echo $row['type']; ?></td>
                <td style="border-right: 0px solid; border-top: 0px solid;"><?php echo $row['status']; ?></td>
                <td style="border-top: 0px solid;">
                    <?php
                        $invoice_job_id = $row['job_id'];
                        $invoice_query = $Controller->invoice_list('1',$invoice_job_id);
                        $num_results = $invoice_query->num_rows;
                        if( $num_results > 0){
                            while($row = $invoice_query->fetch_assoc()){
                                if ($row['c_total_amount_due'] == '0.00'){
                                    echo 'PAID';
                                } else {
                                    extract($row);
                                    echo '$' . $row['c_total_amount_due'];
                                }
                            }
                        } else {
                                echo 'N/A';
                              }
                    ?>
                    </td>
                </tr>
                </table>
                        
                    </div>
    <?php } ?>
<!-- <div class="inner"> -->
<?php 
    $projects_query = $Controller->projects_list('0,1', '1'); 
    while($row = $projects_query->fetch_assoc()){ 
        if ($row['status'] == 'Completed') {
            //$invoice_job_id = $row['job_id'];
            $invoice_id_query = $Controller->project_get_invoice_id($row['job_id']);
            $invoice_id = $invoice_id_query->fetch_assoc();
    //echo $invoice_id_query->num_rows;
            if ($invoice_id_query->num_rows > 0) {
                $invoice_job_id = $invoice_id['invoice_id'];
            } else {
                $invoice_job_id = '0';
            }
            
            
            
            $invoice_query = $Controller->invoice_list('1',$invoice_job_id);
            $num_results = $invoice_query->num_rows;
            if( $num_results > 0){
                /*while(*/$row = $invoice_query->fetch_assoc();//){
                    $invoice_id = $row['invoice_id'];
                    if ($row['c_total_amount_due'] == '0.00'){
                        echo "<div class='project-page-status-paid'><h2>This project has been completed.</h2>";
                        if ($_SESSION['is_staff'] == 1) { 
                            echo "The client has already paid.&nbsp;
                            <a href='index.php?invoice_id=" . $invoice_id . "'>Click Here</a> to view the invoice.";  
                        } else {
                            echo "Thank you for your payment.&nbsp; 
                            <a href='index.php?invoice_id=" . $invoice_id . "'>Click Here</a> to view the invoice.";
                        }
                    } else {
                        echo "<div class='project-page-status-not-paid'><h2>This project has been completed.</h2>";
                        if ($_SESSION['is_staff'] == 1) { 
                            echo "The client has not yet paid.&nbsp;
                            <a href='index.php?invoice_id=" . $invoice_id . "'>Click Here</a> to view the invoice.";  
                        } else {
                            echo "Please <a href='index.php?invoice_id=" . $invoice_id . "'>Click Here</a>&nbsp; 
                            to view and pay the invoice.";
                        }
                        
                        
                                }
                            //}
                        }
            echo "</div>";
            } else {
            }
    }
                    ?>
    
        <div class="list-small-screen">
            <div class="title-box"><BR>
                <h4 >Project Description</h4>
                <span><?php $Controller->get_project_description(); ?></span><BR>
            </div>
        </div>
                
        <div class="left-box">
                <h4 >Total Progress</h4>
                <?php $projects_query = $Controller->projects_list('0,1', '1'); 
                      $project_info = $projects_query->fetch_assoc();?>
                <?php $percent = $project_info['total_percent_complete'] * 100; ?>
                    <?php if ($percent < 10 && $percent != 0) { ?>
                            <table style="width: 90%; margin: 0 auto;">
                                <tr><td>
                            <?php echo $percent . "%"; ?>
                                </td><td width="80%">
                            <div class='progress-bar-container' style="min-width: 100%; margin: 0px auto; height: 20px;">
                                <div class='progress-bar' style="width: <?php echo $percent + 1; ?>%;">
                                </div>
                            </div>
                                </td></tr>
                            </table>
                          <?php } else { ?>
                    <div class='progress-bar-container' style="font-size: 18px;">
                        <?php if ($percent == 0) { 
                            echo $percent . "%";
                              } else { ?>
                        <div class='progress-bar' style="font-size: 18px; height: 20px; width: <?php echo $percent + 1; ?>%;">
                            <?php 
                            if ($percent >= 10) {
                                echo $percent . "%";
                            } ?>
                        </div>
                        <?php } ?>
                    </div>
                        <?php } ?>
                
                
                <HR style="margin: 10px;">
                    
                    
        <div>
            <h4>Latest File</h4>
            <?php $Controller->display_project_latest_image('feature-project-image', '','1', '0', '0', '1'); ?>
        </div>
            
            <h4>Other Project Files</h4>
        <div class="thumbnail-list-container">
            Images:<BR>
            <div style="width: 100%; margin: 0 auto; text-align: left;">
            <?php $Controller->display_project_images('thumbnail'); ?>
            </div>
            <?php
                //$src = "http://samples.jchdesign.com/SCP-Demo/UCM/includes/plugin_file/upload/c0b0482598f7e6e4967e71ccbbf3df59";
                //$Controller->check_for_thumb($src);
                //echo '<HR>';
                //echo $src;
            ?>
            <!--
            Audio:
            Video:

            Misc. Assets:
                Compressed .ZIP Files:
                Text Documents:
                Images:
                Audio:
                Video:
            -->
        </div><BR>
        </div>
        <?php
        $comment_query = $Controller->ajax_project_comments_query();
        ?>
        <div class="right-box">
            <div class="list-large-screen">
            
                <h4>Project Description</h4>
                <span><?php $Controller->get_project_description(); ?></span>
            
            </div>
            <HR style="margin: 10px;">

        <form id="form" method="post">
                    <label>
                        <span>Please leave a comment:</span>
                        <textarea name="comment" id="comment" placeholder="Type your comment here" required></textarea>
                    </label>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <table>
                <tr>
                    <td style='text-align: right; width: 100%; padding-right: 5px; vertical-align: center;'>
                    <?php
                    if ($_SESSION['is_staff'] == 1){
                        echo "<div style='margin-bottom: 5px;'>";
                        echo "<input type='checkbox' name='notify_customer' value='notify_customer' checked> Notify Client?";
                        echo '</td>';
                    } else { echo '</div></td>'; }
                    ?>
                    <td>
                    <input type="submit" id="submit" name="submit_comment" value="Submit Comment">
                    </td>
                </tr>
            </table>
                </form>

        <h4>Comments</h4>
                <div class="comment-block">
                <?php if (!$comment_query->fetch_assoc()){
                        echo "There have not been any comments made on this page. Please use the form above to add one.";
                    } ?>
                <?php while($row = $comment_query->fetch_assoc()){ ?>
                    <div class="comment-item">
                        <div class="comment-avatar">
                            <img src="<?php echo $Controller->avatar($row['email'], '120px'); ?>" alt="avatar">
                            
                        </div>
                        <div class="comment-post">
                            <p><?php echo htmlspecialchars($row['note']); ?></p>&nbsp;
                            <h3><strong>- <?php echo $row['name'] . ' ' . $row['last_name']; ?></strong>
                            <?php echo $row['date_created']; ?></h3>
                        </div>
                        
                    </div>
                <?php } ?>
                </div>
        </div><BR>
<?php
if (file_exists('custom/options-config.php')) {
        require_once('custom/options-config.php');
    if (defined('PROJECT_SHARING')) {
        if (constant('PROJECT_SHARING') == 'on') {
?>
<HR style="width: 100%; margin: 10px auto;">
        <div style="float: right; width: 100%; border: 0px solid;">
            <center>
                <strong>Share This Project?</strong>
                <div style="width: 80%; margin: 0 auto; text-align: left;">
            Invite another person to view this project. It may be helpful to have more than one opinion. If you'd like to show this page to someone else, please enter their email address below. They will be able to login and access only this or other projects you have shared with them.
                </div><BR>
            <form method="post" id="invite" action="index.php?page=invite-user&project_id=<?php echo $id; ?>">
                Email:
                <input id="login_input_username" class="login_input" type="username" name="email" />
                <input type="submit" style="padding: 4px; width: auto;" 
                       name="special_access_add_user" 
                       value="Invite"/>
                <input type="hidden" name="project_id" value="<?php echo $id; ?>">
                
                
            <?php
            if (isset($_POST['special_access_add_user'])) {
                //echo "<script>window.location = 'index.php?page=invite-user'</script>";
                }
$Controller->special_access_column_check();
            //$add_user_query = $Controller->special_access_column_check();
            //$row = $add_user_query->fetch_assoc();
            //    echo $row['table_check'];
            ?>

                
            </form>
            </center>
        </div>
    <?php } ?>
<?php } ?>
<?php } ?>
</div>
      
<?php } else { ?>
            <BR>
<div class='due-date' style='background-color: #909090; color: f5f5f5; font-size: 20px; font-weight: 700;'>
    ACCESS DENIED
</div><BR>
<div style="width: 75%; margin: 0 auto;">
You do not have permission to view this page. If you feel this is an error, please contact an administrator and we'll do out best to resolve the issue.
</div><BR><BR>
            
<?php }?>
            
            