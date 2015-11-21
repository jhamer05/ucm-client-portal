<table style="width: 100%"><tr><td>
<table class='list-header'>
        <tr>
        <th >Invoice #</th>
        <th >Project Name</th>
    <?php if ($_SESSION['is_staff'] == '1') { ?>
        <th >Due Date</th>
        <th >Amt. Due</th>
        <th >Customer</th>
    <?php } else { ?>
        <th >Due Date</th>
        <th style="text-align: left;">Total</th>
        <th >Amt. Due</th>
    <?php } ?>
        </tr>
        <tbody>
    <?php $invoice_query = $Controller->invoice_list(); ?>
    <?php //if( $num_results > 0){ ?>
    <?php while($row = $invoice_query->fetch_assoc()){ ?>
        <?php //$invoice_id = $row['invoice_id']; ?>
            <?php

            $currency_query = $Controller->get_project_currency_data('invoice', $row['invoice_id']);
            $currency_data = $currency_query->fetch_assoc();

            $decimal = $currency_data['currency_decimal_separator'];
            $thousands = $currency_data['currency_thousand_separator'];
            $decimal_places = $currency_data['currency_decimal_places'];

            ?>
            <tr class="job-list" onclick="document.location = 'index.php?invoice_id=<?php echo $row['invoice_id']; ?>';">
                
                <td>
                    <div class="list-small-screen">
                        <div style='width: 100%; text-align: center; font-weight: 600; font-size: 18px;'>
                            <span style="font-weight: 600; font-size: 18px;">
                                <?php echo $row['name']; ?></span>
                            <span style="font-size: 12px;">
                                (#<?php echo $row['invoice_name']; ?>)
                            </span>
                        </div>
                    </div>
                    <div class="list-small-screen" style="width: 100%;">
                        <?php 
                            date_default_timezone_set(constant('TIME_ZONE'));
                            $date = new DateTime();
                            $amt_due = $row['c_total_amount_due'];
                            if ($date->format('Y-m-d') > $row['invoice_date_due'] && $amt_due > 0.00) {
                                echo "<div class='due-date' id='pastDue'>";
                                echo 'Past Due: ' . $row['invoice_date_due']; 
                                echo "</div>";
                            } elseif ($row['c_total_amount_due'] > 0.00){
                                echo "<div class='due-date' id='pending'>"; //#f1f100
                                echo 'Due by: ' . $row['invoice_date_due']; 
                                echo "</div>";
                            } else {
                                echo "<div class='due-date'>";
                                echo 'Paid: ' . $row['date_paid'];
                                echo "</div>";
                            }
                        ?>
                    </div>
                    <div class="list-small-screen" style="width: 100%;">
                        <table style="width: 100%; height: 80px; vertical-align: top; margin-bottom: 8px; margin: auto;">
                            <tr>
                                <td style="text-align: right;">
                                    Total Cost:
                                </td>
                                <td>
                                    <div class="due-date" style="text-align: center;">
                                    <?php echo $row['c_total_amount']; ?>
                                    </div>
                                </td>
                                <td style="width: 18px; text-align: center; vertical-align: middle; padding-right: 5px;">
                                    <img src="images/icons/arrow_right.png" style="width: 15px;">
                                </td>
                            </tr>
                            <tr>
                            <tr>
                                <td style="text-align: right;">
                                    Amt. Due:
                                </td>
                                <td>
                                    <?php
                                        if ($row['c_total_amount_due'] <= '0.00'){
                                            echo "<div class='due-date' id='paid'>";
                                            echo 'PAID';
                                            echo "</div>";
                                        } else {
                                            echo "<div class='due-date' id='pastDue'>";
                                            $amt_due = $row['c_total_amount_due'];
                                            
                                            echo "<strong>";
                                            echo $currency_data['symbol'];
                                            echo number_format((float)$amt_due, $decimal_places, $decimal, $thousands);
                                            echo "</span></strong>";
                                            
                                            echo "</div>";
                                            
                                            
                                        } ?>
                                </td>
                                
                            </tr>
                            
                        </table>
                    </div>
                    
                    <div class="list-large-screen">
                    <?php echo $row['invoice_name']; ?>
                    </div>
                </td>
                <td class="list-large-screen">
                    <?php 
                    if ($row['name']) {
                        echo $row['name']; 
                    } else {
                        echo '';
                        echo $row['item_description'];
                    }?>
                </td>
                <td class="list-large-screen">
                    <?php 
                        date_default_timezone_set(constant('TIME_ZONE'));
                        $date = new DateTime();
                        $amt_due = $row['c_total_amount_due'];
                        if ($date->format('Y-m-d') >= $row['invoice_date_due'] && $amt_due > 0.00) {
                            echo "<div class='due-date' id='pastDue'>";
                            echo 'Past Due: ' . $row['invoice_date_due']; 
                            echo "</div>";
                        } elseif ($row['c_total_amount_due'] > 0.00){
                            echo "<div class='due-date' id='pending'>"; //#f1f100
                            echo $row['invoice_date_due']; 
                            echo "</div>";
                        } else {
                            echo 'Paid: ' . $row['date_paid'];
                        }
                    ?>
                </td>
            <?php if ($_SESSION['is_staff'] != '1') { ?>
                <td class="list-large-screen" style="text-align: left;">
                    <?php echo "$" . $row['c_total_amount']; ?>
                </td>
            <?php } ?>
                <td class="list-large-screen">
                    <?php
                        if ($row['c_total_amount_due'] <= '0.00'){
                            echo "<div class='due-date' id='paid'>";
                            echo 'PAID';
                            echo "<h3>(" . $currency_data['symbol'] . $row['c_total_amount'] . ")</h3>";
                            echo "</div>";
                        } else {
                            $amt_due = $row['c_total_amount_due'];
                                            
                            echo "<strong>";
                            echo $currency_data['symbol'];
                            echo number_format((float)$amt_due, $decimal_places, $decimal, $thousands);
                            echo "</span></strong>";
                        } ?>
                </td>
            <?php if ($_SESSION['is_staff'] == '1') { ?>
                <td class="list-large-screen">
                    <?php echo $row['customer_name']; ?>
                </td>
            <?php } ?>
                </tr>
            
        <?php } ?>
</table>
        <?php //} ?>
</td></tr></table>