<?php if ($_SESSION['is_staff'] == 1) { ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<!-- <script src="//code.jquery.com/jquery-1.10.2.js"></script> -->
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
    $( document ).ready(function() {
        $('.datepick').each(function() {
        $(this).datepicker({ dateFormat: 'yy-mm-dd' }).val();
        });
    });
</script>
<table style="width: 100%; 
    <?php if (isset($_GET['project_id'])) { echo 'display: none;'; } ?> ">
    <thead>
        <tr class="list-header" >
        <th >Project Name</th>
        <th >Status</th>
    <?php if ($_SESSION['is_staff'] == '1') { ?>
        <th >Customer</th>
    <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php $projects_query = $Controller->projects_list(); ?>
    <?php if( $num_results > 0){ ?>
    <?php while($row = $projects_query->fetch_assoc()){ ?>
        <?php
            $invoice_job_id = $row['job_id'];
            $invoice_query = $Controller->invoice_list('1',$invoice_job_id);
            $num_results = $invoice_query->num_rows;
            $row1 = $invoice_query->fetch_assoc();
            ?>
            <tr class="job-list" onclick="document.location = 'index.php?page=staff&staff_tab=2&project_id=<?php echo $row['job_id']; ?>';">
                <td style="text-align: center; vertical-align: middle; display: inlilne;">
                    <div class="list-large-screen">
                        <?php echo $row['name']; ?>
                    </div>
                    
                    <div class="list-small-screen">
                                <div style='width: 100%; text-align: center; font-weight: 600; font-size: 18px;'>
                                    <?php echo $row['name']; ?>
                                </div>
                                <?php if ($_SESSION['is_staff'] == 1) { ?>
                                <center><span sytle="font-size: 14px; font-weight: 400;">
                                <?php echo $row['customer_name']; ?></span></center>
                                <?php } ?>
                            </div>
                    <div class="list-img-crop list-small-screen" style="margin-left: 5px;">
                    <?php $Controller->display_project_latest_image('list-img', $row['job_id'], '0', '0'); ?>
                    </div>
                        <div class="list-small-screen" style="width: 100%;">
                        <table style="width: 58%; height: 80px; display: inline; float: right; vertical-align: top; margin-bottom: 8px;">
                            <tr>
                                <td>
                    <?php 
                        if ($_SESSION['is_staff'] == 1) {
                            date_default_timezone_set(constant('TIME_ZONE'));
                            $date = new DateTime();    
                            if ($row['status'] == 'Completed' && $row['date_completed'] < $row['date_due'] && $date->format('Y-m-d') - $row['date_completed'] < 30){
                                echo "<div class='due-date' id=''>";
                                echo 'Finished Early <h3>(' . $row['date_completed'] . ')</h3>'; 
                                echo "</div>";
                            } elseif ($row['status'] == 'On Hold' || $row['status'] == 'Pending' || $row['status'] == 'In Progress') {
                                echo "<div class='due-date' id='pending'><strong>";
                                echo $row['status']; 
                                echo "</strong></div>";
                            } elseif ($row['date_due'] == 0 && $row['status'] != 'Completed') {
                                echo "<div class='due-date' id='pending'>";
                                echo '<strong>' . $row['status'] . '</strong>'; 
                                echo "</div>";
                            }elseif ($date->format('Y-m-d') >= $row['date_due'] && $row['status'] != 'Completed') {
                                echo "<div class='due-date' id='pastDue'>";
                                echo '<strong>Past Due</strong> <h3>(' . $row['date_due'] . ')</h3>'; 
                                echo "</div>";
                            } elseif ($date->format('Y-m-d') <= $row['date_due'] && $row['status'] != 'Completed'){
                                echo "<div class='due-date' id='pending'>"; //#f1f100
                                echo 'Due ' . $row['date_due'] . ''; 
                                echo "</div>";
                            } else {
                                echo "<div class='due-date' id=''>";
                                echo $row['status'];
                                echo '<h3>(' . $row['date_completed'] . ')</h3>';
                                echo "</div>";
                            }
                        }?>
                    
                            <?php
                        if( $num_results > 0){
                                if ($row1['c_total_amount_due'] == '0.00'){
                                    echo "<div class='due-date' id='paid'>";
                                    echo 'PAID';
                                    echo "</div>";
                                } else {
                                    echo "<div class='due-date' id='pastDue'>";
                                    echo '$' . $row1['c_total_amount_due'] . '<span style="font-size: 10px;"> Due</span>'; 
                                    echo "</div>";
                                }
                            } else {
                                echo ' ';
                              } ?>
                    
                        </td>
                            <td style="width: 18px; text-align: center; padding-right: 5px;">
                                <img src="images/icons/arrow_right.png" style="width: 15px;">
                            </td>
                        </tr>
                    </table>
                </div>
                    
                </td>
                </td>
                
                
                <td class="list-large-screen" style="text-align: center;">
                    <?php 
                        if ($_SESSION['is_staff'] == 1) {
                            date_default_timezone_set(constant('TIME_ZONE'));
                            $date = new DateTime();    
                            if ($row['status'] == 'Completed' && $row['date_completed'] < $row['date_due'] && $date->format('Y-m-d') - $row['date_completed'] < 30){
                                echo "<div class='due-date' id=''>";
                                echo 'Finished Early <h3>(' . $row['date_completed'] . ')</h3>'; 
                                echo "</div>";
                            } elseif ($row['status'] == 'On Hold' || $row['status'] == 'Pending' || $row['status'] == 'In Progress') {
                                echo "<div class='due-date' id='pending'><strong>";
                                echo $row['status']; 
                                echo "</strong></div>";
                            } elseif ($row['date_due'] == 0 && $row['status'] != 'Completed') {
                                echo "<div class='due-date' id='pending'>";
                                echo '<strong>' . $row['status'] . '</strong>'; 
                                echo "</div>";
                            }elseif ($date->format('Y-m-d') >= $row['date_due'] && $row['status'] != 'Completed') {
                                echo "<div class='due-date' id='pastDue'>";
                                echo '<strong>Past Due</strong> <h3>(' . $row['date_due'] . ')</h3>'; 
                                echo "</div>";
                            } elseif ($date->format('Y-m-d') <= $row['date_due'] && $row['status'] != 'Completed'){
                                echo "<div class='due-date' id='pending'>"; //#f1f100
                                echo 'Due ' . $row['date_due'] . ''; 
                                echo "</div>";
                            } else {
                                //echo "<div class='due-date' id=''>";
                                echo $row['status'];
                                echo '<h3>(' . $row['date_completed'] . ')</h3>';
                                //echo "</div>";
                            }
                        } else {
                            if ($row['status'] == 'Completed'){
                                echo "<div class='due-date' id='paid'>";
                                echo 'Complete&nbsp;&nbsp;';  
                                echo "</div>";
                            } else {
                                echo "<div class='due-date' id='pending'>";
                                echo $row['status'];
                                echo "</div>";
                            }
                        }?>
                </td>
            <?php if ($_SESSION['is_staff'] == '1') { ?>
                <td class="list-large-screen">
                    <?php echo $row['customer_name']; ?>
                </td>
            <?php } ?>
                </tr>
                </a>
        <?php } ?>
    </tbody>
</table>
    <?php } ?>





<?php if (isset($_GET['project_id'])) { 
//$_GET['quote_id'] = $_GET['quote'];?>
<BR>
<a href="index.php?page=staff&staff_tab=2"><div class="due-date" style="max-width: 200px;">Project List</div></a>
<BR>
    <?php $quote_query = $Controller->projects_list(); ?>
    <?php $num_results = $quote_query->num_rows; ?>
    <?php if( $num_results > 0){ ?>
    <?php $row = $quote_query->fetch_assoc(); ?>
        <?php if($row['job_id'] = $_GET['project_id']) { ?>

        <?php $assigned_user = $row['user_id']; ?>
<table width="100%">
    <tr>
        <td style="text-align: left;">
            <span><?php echo $row['customer_name']; ?></span>
        </td>
        <td style="text-align: right;">
            <span style="font-weight: 600;"><?php echo $row['name']; ?></span>
        </td>
    </tr>
</table>
<!-- <form method="post"> -->
    <!-- <input type="username" name="quote_name" value="<?php //echo $row['name']; ?>"> -->
<!-- </form> -->


        <!-- <tr class="invoice-list-header">
            <th>#</th>
            <th>Project Item</th>
            <th>Hourly Rate</th>
            <th>Hours</th>
            <th>Amount</th>
        </tr> -->
        <?php $task_query = $Controller->project_task_list(); ?>
        <?php $task_results = $task_query->num_rows; ?>
        <?php if( $task_results > 0){ ?>
        <?php 
        $row_color=0;
    
        while($row_color < $task_results) {
            if($row['job_id'] = $_GET['project_id']) {
                while($row = $task_query->fetch_assoc()){ 
                    /*if ($row_color % 2 == 0){
                    echo "<div class='invoice-list-light'>";
                    } else {
                    echo "<div class='invoice-list-dark'>";
                    } */?>
    <table style="width: 100%;">
        <tr>
            <td>
    <form method="post">
    
        <table class="left-box">
            <tr>
                <td> 
        Project Item #<?php echo $row['task_order']; ?>
                    <input type="username" name="description" 
                           value="<?php echo htmlspecialchars($row['description']); ?>" 
                           style="width: 100%;">
                   
                    <input type="text" name="long_description" 
                           value="<?php echo htmlspecialchars($row['long_description']); ?>"
                           style="width: 100%;">  
                <div class="list-large-screen">
                    <center style="padding-top: 5px;">
                    <input type="submit" style="float: none;" name="project_task_submit" value="Update">
                    </center>
                </div>
                </td>
            </tr>
        </table>
            
            
        </div>
        <table class="right-box"> 
            <tr>
                <td> 
                <table style="width: 100%; border: 1px solid; margin: 2px;">
                    <tr class="invoice-list-header">
                        <th style="width: 33%;">Complete?</th>
                        <th style="width: 33%;">Date Completed</th>
                        <th style="width: 33%;">Date Due</th>
                    </tr>
                    <tr>
                        <td>
                            <center>
                            <input type="checkbox" name="fully_completed" value="1"
                            <?php if($row['fully_completed']== 1) { echo 'checked'; }?>>
                            </center>
                        </td>
                        <td style="padding: 5px; text-align: center;">
                            <?php 
                                if ($row['date_done'] == 0) {
                                    echo 'Incomplete';
                                } else {
                            ?>
                            <input type="username" 
                                   class="datepick" 
                                   id="<?php echo ($row['task_id'] . 'd1'); ?>" 
                                   value="<?php echo $row['date_done']; ?>"
                                   name="date_done" style="width: 100%">
                            <?php } ?>
                        </td>
                        <td style="padding: 5px; text-align: center;">
                            <input type="username" 
                                   class="datepick" 
                                   id="<?php echo ($row['task_id'] . 'd2'); ?>" 
                                   <?php 
                                        if ($row['date_due'] == 0) {
                                            echo 'placeholder="None"';
                                        } else {
                                            echo 'value="' . $row['date_due'] . '"';
                                        }
                                   ?>
                                   
                                   name="date_due" style="width: 100%">
                        </td>
                    </tr>
                </table>
                </td>
            </tr> 
            <tr>
                <td>   
                
        <table style="width: 100%; border: 1px solid; margin: 2px;">
            <tr class="invoice-list-header">
                <th>Hourly Rate</th>
                <th>Hours</th>
                <th>Amount</th>
            </tr>
            <tr>
            <td class="invoice-list" style="width: 15%; text-align: center; vertical-align: top; padding: 5px;">
                
                
                <input type="hidden" name="assigned_user" value="<?php echo $assigned_user; ?>">
                <input type="hidden" name="project_id" value="<?php echo $_GET['project_id']; ?>">
                <!-- <input type="hidden" name="task_order" value="<?php //echo $task_results + 1; ?>"> -->
                <input type="hidden" name="project_task_id" value="<?php echo $row['task_id']; ?>">
                <input type="hidden" name="task_order" value="<?php echo $task_results + 1; ?>">
                
                
                <script>
                $(document).ready(function () {
                     $('#hourlyBox').click(function () {
                         var $this = $(this);
                         if ($this.is(':checked')) {
                             $('#amountBox').fadeIn();
                             $('#amountBox').show();
                             $('#amountDisplay').fadeIn();
                             $('#amountDisplay').hide();
                             $('#hourlyDisplay').fadeIn();
                             $('#hourlyDisplay').show();
                             $('#hourlyInput').fadeIn();
                             $('#hourlyInput').hide();
                         } else {
                             $('#amountDisplay').fadeIn();
                             $('#amountDisplay').show();
                             $('#amountBox').fadeIn();
                             $('#amountBox').hide();
                             $('#hourlyDisplay').fadeIn();
                             $('#hourlyDisplay').hide();
                             $('#hourlyInput').fadeIn();
                             $('#hourlyInput').show();
                         }
                     });
                 });    
                </script>
                <input type="checkbox" name="no_hourly" id="hourlyBox"
                       <?php if($row['hourly_rate']== 0) { echo 'checked'; }?>>N/A
                <input type="number" name="hourly_rate" id="hourlyInput"
                       value="<?php echo $row['hourly_rate']; ?>" style="width: 100%;">
                <span id="hourlyDisplay" style="<?php if ($row['hourly_rate'] != 0) { echo 'display: none;'; }?>">
                    <BR>0.00</span>
            </td>
            <td class="invoice-list" style="width: 15%; text-align: center; vertical-align: top; padding: 5px;">
                <input type="checkbox" name="no_hours" <?php if($row['hours']== 0) { echo 'checked'; }?>>N/A
                <input type="number" name="hours" value="<?php echo $row['hours']; ?>" 
                       style="width: 100%;">
            </td>
            <td class="invoice-list" style="width: 15%; text-align: center; vertical-align: top; padding: 5px;">
                
                
                <input type="checkbox" name="taxable" value="1"
                       <?php if($row['taxable'] == 1) { echo 'checked'; }?>>Taxable<br>
                <input type="number" name="amount" id="amountBox" value="<?php echo $row['amount']; ?>" 
                       style="width: 100%; <?php if ($row['hours'] != 0) { echo 'display: none;'; }?>">
                <span id="amountDisplay" style="<?php if ($row['hours'] == 0) { echo 'display: none;'; }?>">
                
                <?php 
                if ($row['taxable'] == 1) {
                    $taxable = "<span style='font-size: 10px;'>&nbsp;(+Tax)</span>";
                } else {
                    $taxable = "";
                }
                if($row['amount'] > 0) {
                    echo "$";
                    echo $row['amount'];
                    echo $taxable;
                } elseif ($row['hours'] > 0) {
                    echo "$";
                    echo $row['hourly_rate'] * $row['hours'];
                    echo $taxable;
                } elseif ($row['hours'] == 0 && $row['amount'] == 0) {
                    echo '$0.00';
                }?>
                    </span>
            </td>
                
            </tr>
        </table>
                <div class="list-small-screen">
                    <center style="padding-top: 5px;">
                    <input type="submit" style="float: none;" name="project_task_submit" value="Update">
                    </center>
                </div>
            
    </td></tr></table>
    </table>

            </td>
        </tr>
    </table>&nbsp;<BR><HR><BR>
    </form>
        <?php $row_color++; } ?>
        <?php }}} ?>
<?php $projects_query = $Controller->project_task_list(); ?>
<?php $task_results = $projects_query->num_rows; ?>
<?php if( $task_results > 0){ ?>
<?php $row = $projects_query->fetch_assoc(); ?>
    </table>
    <table style="width: 100%; border: 0px solid #000; margin: 5px; padding: 5px;">
        <tr>
            <td style="width: 60%;"></td>
            <td style="text-align: right; padding: 2px; width: 25%;">Sub Total:&nbsp;</td>
            <td style="width: 10%;"><?php 
                             
                $taxable_query = $Controller->job_tax($_GET['project_id']); 
                $taxable_results = $taxable_query->num_rows; 
                if( $taxable_results > 0){ 
                $row1 = $taxable_query->fetch_assoc(); 
                    
                    if($row1['total_amount'] > 0) {
                        $total_amt = $row1['total_amount'];
                    } else {
                        $total_amt = 0;
                    }                        
                    if ($row1['total_hours'] > 0 && $row1['total_amount'] == 0) {
                        $total_hourly = $row['hourly_rate'] * $row1['total_hours'];
                    } elseif ($row1['total_hours'] <= 0) {
                        $total_hourly = 0;
                    } else {
                        $total_hourly = 0;
                    }
                             
                    echo "<strong>$";
                    echo $total_amt; + $total_hourly;
                    echo "</span></strong>";?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right; padding: 2px; width: 25%;">Tax <span style="font-size: 10px;">(<?php echo $row['percent'] ?>%)</span>:&nbsp;</td>
            <td style="width: 10%;">
                <?php 

                
                    if ($row1['total_hours_taxable'] > 0) {
                        $hourly_taxable = $row1['total_hours_taxable'] * $row['hourly_rate'];
                        $hourly_tax = $hourly_taxable / $row1['percent'];
                    } else {
                        $hourly_tax = 0;
                    }
                    if ($row1['total_amount_taxable'] > 0) {
                        $amount_tax = $row1['total_amount_taxable'] / $row['percent'];
                    } else {
                        $amount_tax = 0;
                    }
                    
                    $tax = $amount_tax + $hourly_tax;
                    echo "<strong>$";
                    echo $tax;
                    echo "</span></strong>";
                }
                ?>
                    
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right; padding: 2px; width: 25%;">Est. Total:&nbsp;</td>
            <td style="width: 10%;"><?php 
                    echo "<strong>$";
                    echo $total_amt + $tax;
                    //echo ($total_amt + $total_hourly) + $tax;
                    echo "</span></strong>";?>
            </td>
        </tr>
        <tr height="10px">        
        </tr>
        
    </table>
<?php } ?>

<?php
if (isset($_POST['project_task_submit'])) {
    //$Controller->write_project();
}?>
        <?php //echo $row['date_approved']; ?>

        <?php //if($row['date_approved'] >= 0) { ?>
    
    
        <?php //} ?>
    <?php } ?>
    <?php } ?>

    <?php } ?>

<?php } ?>