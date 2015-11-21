<table style="width: 100%;">
        <thead>
            <tr class="list-header" >
                <th >Preview</th>
                <th >Project Name</th>
                <?php if ($_SESSION['is_staff'] == 0) {
                echo '<th >Type</th>';
                }?>
                <th >Status</th>
                <th >Amt. Due</th>
                <?php if ($_SESSION['is_staff'] == 1) {
                echo '<th >Customer</th>';
                } ?>
            </tr>
        </thead>
        <tbody>
<?php

?>
    <?php $projects_query = $Controller->projects_list(); ?>
    <?php while($row = $projects_query->fetch_assoc()){ ?>
            <?php
            
            $currency_query = $Controller->get_project_currency_data('project', $row['job_id']);
            $currency_data = $currency_query->fetch_assoc();

            $decimal = $currency_data['currency_decimal_separator'];
            $thousands = $currency_data['currency_thousand_separator'];
            $decimal_places = $currency_data['currency_decimal_places'];

            ?>
                <tr class="job-list" onclick="document.location = 'index.php?project_id=<?php echo $row['job_id']; ?>';">
                    <td style="vertical-align: middle; display: inlilne; width: 15%;">
                            <div class="list-small-screen">
                                <div style='width: 100%; text-align: center; font-weight: 600; font-size: 18px;'>
                                    <?php echo $row['name']; ?>
                                </div>
                                <?php if ($_SESSION['is_staff'] == 1) { ?>
                                <center><span sytle="font-size: 14px; font-weight: 400;">
                                <?php echo $row['customer_name']; ?></span></center>
                                <?php } ?>
                            </div>
                    <div class="list-img-crop" style="margin-left: 5px;">
                    <?php $Controller->display_project_latest_image('list-img', $row['job_id'], '0', '0', '1'); ?>
                    </div>
                        <div class="list-small-screen" style="width: 100%;">
                        <table style="width: 58%; height: 80px; display: inline; float: right; vertical-align: top; margin-bottom: 8px;">
                            <tr>
                                <td>
                                    
                                    
                    <?php $percent = $row['total_percent_complete'] * 100; ?>
                    <?php if ($percent < 15 && $percent != 0) { ?>
                            <table style="width: 90%; margin: 0 auto;">
                                <tr><td>
                            <?php echo $percent . "%"; ?>
                                </td><td width="80%">
                            <div class='progress-bar-container' style="min-width: 100%; margin: 0px auto;">
                                <div class='progress-bar' style="width: <?php echo $percent + 1; ?>%;">
                                </div>
                            </div>
                                </td></tr>
                            </table>
                          <?php } else { ?>
                    <div class='progress-bar-container' id=''>
                        <?php if ($percent == 0) { 
                            echo $percent . "%";
                              } else { ?>
                        <div class='progress-bar' style="width: <?php echo $percent + 1; ?>%;">
                            <?php 
                            if ($percent >= 15) {
                                echo $percent . "%";
                            } ?>
                        </div>
                        <?php } ?>
                    </div>
                        <?php } ?>
                                    
                                    
                    <?php 
                        //if ($_SESSION['is_staff'] == 1) {
                            date_default_timezone_set(constant('TIME_ZONE'));
                            $date = new DateTime();    
                            if ($row['status'] == 'Completed' && $row['date_completed'] < $row['date_due'] && $date->format('Y-m-d') - $row['date_completed'] < 30 && $_SESSION['is_staff'] == 1){
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
                                echo "<div class='due-date' style='border: 0px solid;'>";
                                echo $row['status'];
                                echo '<h3>(' . $row['date_completed'] . ')</h3>';
                                echo "</div>";
                            }
                        /*} else {
                            if ($row['status'] == 'Completed'){
                                echo "<div class='due-date' id='paid'>";
                                echo 'Complete&nbsp;&nbsp;'; 
                                echo "</div>";
                            } else {
                                echo "<div class='due-date' id='pending'>";
                                echo $row['status'];
                                echo "</div>";
                            }*/
                        //}?>
                                <?php
            
            //$invoice_job_id = $invoice_id['invoice_id'];
            //if ($invoice_job_id != 'NULL') {
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
            $row1 = $invoice_query->fetch_assoc();
    
            //} else {
                
            //}
            ?>
                                    
                        
                            <?php
                        //if( $num_results > 0){
                                if ($row1['c_total_amount_due'] == '0.00'){
                                    echo "<div class='due-date' id='paid'>";
                                    echo 'PAID';
                                    echo "</div>";
                                } elseif ($row1['c_total_amount_due'] > '0.00') {
                                    echo "<div class='due-date' id='pastDue'>";
                                    
                                    $amt_due = $row1['c_total_amount_due'];
                                    echo "<strong>";
                                    echo $currency_data['symbol'];
                                    echo number_format((float)$amt_due, $decimal_places, $decimal, $thousands);
                                    echo "</span></strong>";
                                    echo '<font style="font-size: 10px;"> Due</font>'; 
                                    echo "</div>";
                                    
                                } else {
                                echo ' ';
                                }
                        
                              //} ?>
                    
                        </td>
                            <td style="width: 18px; text-align: center; padding-right: 5px;">
                                <img src="images/icons/arrow_right.png" style="width: 15px;">
                            </td>
                        </tr>
                    </table>
                </div>
                </td>
                <td class="list-large-screen" style="text-align: center;"><?php echo $row['name']; ?></td>
            <?php if ($_SESSION['is_staff'] == '0') { ?>
                <td class="list-large-screen" style="text-align: center;"><?php echo $row['type']; ?></td>
            <?php } ?>
                <td class="list-large-screen" style="text-align: center; max-width: 120px; !important">
                    
                    
                    <?php $percent = $row['total_percent_complete'] * 100; ?>
                    <?php if ($percent < 30 && $percent != 0) { ?>
                            <table style="width: 90%; margin: 0 auto;">
                                <tr><td>
                            <?php echo $percent . "%"; ?>
                                </td><td width="80%">
                            <div class='progress-bar-container' style="min-width: 100%; margin: 0px auto;">
                                <div class='progress-bar' style="width: <?php echo $percent + 1; ?>%;">
                                </div>
                            </div>
                                </td></tr>
                            </table>
                          <?php } else { ?>
                    <div class='progress-bar-container' id=''>
                        <?php if ($percent == 0) { 
                            echo $percent . "%";
                              } else { ?>
                        <div class='progress-bar' style="width: <?php echo $percent + 1; ?>%;">
                            <?php 
                            if ($percent >= 30) {
                                echo $percent . "%";
                            } ?>
                        </div>
                        <?php } ?>
                    </div>
                        <?php } ?>
                    
                    
                    <?php 
                        //if ($_SESSION['is_staff'] == 1) {
                            date_default_timezone_set(constant('TIME_ZONE'));
                            $date = new DateTime();    
                            if ($row['status'] == 'Completed' && $row['date_completed'] < $row['date_due'] && $date->format('Y-m-d') - $row['date_completed'] < 30 && $_SESSION['is_staff'] == 1){
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
                        //}?>
                </td>
                <td class="list-large-screen">
                    
                    <?php
                        if( $num_results > 0){
                                if ($row1['c_total_amount_due'] == '0.00'){
                                    echo "<div class='due-date' id='paid'>";
                                    echo 'PAID';
                                    echo "</div>";
                                } else {
                                    echo "<div class='due-date' id='pastDue'>";
                                    
                                    $amt_due = $row1['c_total_amount_due'];
                                    echo "<strong>";
                                    echo $currency_data['symbol'];
                                    echo number_format((float)$amt_due, $decimal_places, $decimal, $thousands);
                                    echo "</span></strong>";
                                    echo '<font style="font-size: 10px;"> Due</font>'; 
                                    echo "</div>";
                                }
                            } else {
                                echo ' ';
                              }
                        ?>
                </td>
            <?php if ($_SESSION['is_staff'] == '1') { ?>
                <td class="list-large-screen">
                    <?php echo $row['customer_name']; ?>
                </td>
            <?php } ?>
                
                </tr>
                
                <?php } ?>
    </tbody>
</table>