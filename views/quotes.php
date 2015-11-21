<table style="width: 100%;">
    <thead>
        <tr class="list-header" >
        <th >Project Name</th>
        <th >Quote Date</th>
        <th >Est. Price</th>
        <th >Status</th>
    <?php if ($_SESSION['is_staff'] == '1') { ?>
        <th >Customer</th>
    <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php $quote_query = $Controller->quote_list(); ?>
    <?php if( $num_results > 0){ ?>
    <?php while($row = $quote_query->fetch_assoc()){ ?>
        <?php $quote_query1 = $Controller->quote_list('NULL',$row['quote_id']); ?>
        <?php if( $num_results > 0){ ?>
        <?php $row1 = $quote_query1->fetch_assoc() ?>
            <?php

            $currency_query = $Controller->get_project_currency_data('quote', $row['quote_id']);
            //$currency_data = $currency_query->fetch_assoc();
foreach((array) $currency_query as $currency_data) //fetch_assoc() may have been causing issues
            $decimal = $currency_data['currency_decimal_separator'];
            $thousands = $currency_data['currency_thousand_separator'];
            $decimal_places = $currency_data['currency_decimal_places'];

            ?>
            <tr class="job-list" onclick="document.location = 'index.php?quote_id=<?php echo $row['quote_id']; ?>';">
                <td style="text-align: center;">
                    <div class="list-large-screen">
                        <?php echo $row['name']; ?>
                    </div>
                    <div class="list-small-screen">
                                <div style='width: 100%; text-align: center; font-weight: 600; font-size: 18px;'>
                                    <?php echo $row['name']; ?>
                                </div>
                            </div>
                    <div class="list-small-screen" style="width: 100%;">
                            <?php
                            if ($row['date_approved'] > 0){
                                echo "<div class='due-date' id='approved'>";
                                echo 'Approved';
                                echo "</div>";
                                echo "<h3>";
                                echo $row['date_approved'];
                                echo "</h3>";
                            } else {
                                echo "<div class='due-date' id='pending'>";
                                echo 'Pending Approval';
                                echo "</div>";
                            } ?>
                    </div>
                    <div class="list-small-screen" style="width: 100%;">
                        <table style="width: 100%; height: 80px; vertical-align: top; margin-bottom: 8px; margin: auto;">
                            <tr>
                                <td style="text-align: right;">
                                    Quoted on:
                                </td>
                                <td>
                                    <div class="due-date" style="text-align: center;">
                                    <?php echo $row['date_created']; ?>
                                    </div>
                                </td>
                                <td style="width: 18px; text-align: center; vertical-align: middle; padding-right: 5px;">
                                    <img src="images/icons/arrow_right.png" style="width: 15px;">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">
                                    Est. Price:
                                </td>
                                <td>
                                    <div class="due-date" style="text-align: center;">
                                        <?php 
                                    
                $total_hourly_plus_amount = 0;
                $total_quantity = 0;
                $total_amount = 0;
            $total_query = $Controller->quote_list('NULL',$row['quote_id']);
            while($total_row = $total_query->fetch_assoc()){
                if ($total_row['manual_task_type'] == '-1') {
                    $default_task_type = $Controller->default_task_type();
                } else {
                    $default_task_type = 'false';
                }
                
                if ($default_task_type == '0' || $total_row['manual_task_type'] == '0') {
                    $total_hourly_plus_amount += $total_row['task_amount'] + ($total_row['task_hours'] * $total_row['hourly_rate']);
                } elseif ($default_task_type == '1' || $total_row['manual_task_type'] == '1'){
                    $total_quantity += $total_row['task_hours'] * $total_row['task_amount'];
                } elseif ($default_task_type == '2' || $total_row['manual_task_type'] == '2'){
                    $total_amount += $total_row['task_amount'];
                }
            }
    
            $sum_total = $total_hourly_plus_amount + $total_quantity + $total_amount;
                           
                        echo "<strong>";
                        echo $currency_data['symbol'];
                        echo number_format((float)$sum_total, $decimal_places, $decimal, $thousands);
                        echo "</span></strong>";
                    ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                </td>
                <td class="list-large-screen" style="text-align: center;">
                    <?php echo $row['date_created']; ?></td>
                <td class="list-large-screen" style="text-align: center;">
                      <?php 
                                    
                $total_hourly_plus_amount = 0;
                $total_quantity = 0;
                $total_amount = 0;
            $total_query = $Controller->quote_list('NULL',$row['quote_id']);
            while($total_row = $total_query->fetch_assoc()){
                if ($total_row['manual_task_type'] == '-1') {
                    $default_task_type = $Controller->default_task_type();
                } else {
                    $default_task_type = 'false';
                }
                
                if ($default_task_type == '0' || $total_row['manual_task_type'] == '0') {
                    $total_hourly_plus_amount += $total_row['task_amount'] + ($total_row['task_hours'] * $total_row['hourly_rate']);
                } elseif ($default_task_type == '1' || $total_row['manual_task_type'] == '1'){
                    $total_quantity += $total_row['task_hours'] * $total_row['task_amount'];
                } elseif ($default_task_type == '2' || $total_row['manual_task_type'] == '2'){
                    $total_amount += $total_row['task_amount'];
                }
            }
    
            $sum_total = $total_hourly_plus_amount + $total_quantity + $total_amount;
                           
                        echo "<strong>";
                        echo $currency_data['symbol'];
                        echo number_format((float)$sum_total, $decimal_places, $decimal, $thousands);
                        echo "</span></strong>";
                    ?>
                </td>
                <td class="list-large-screen" style="text-align: center;">
                    <?php
                    if ($row['date_approved'] > 0){
                        echo "<div class='due-date' id='approved'>";
                        echo 'Approved';
                        echo "</div>";
                        echo "<h3>";
                        echo $row['date_approved'];
                        echo "</h3>";
                    } else {
                        echo "<div class='due-date' id='pending'>";
                        echo 'Pending Approval';
                        echo "</div>";
                    } ?>
                </td>
            <?php if ($_SESSION['is_staff'] == '1') { ?>
                <td class="list-large-screen">
                    <?php echo $row['customer_name']; ?>
                </td>
            <?php } ?>
                </tr>
                </a>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>
    <?php } ?>