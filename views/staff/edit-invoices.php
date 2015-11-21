<?php if ($_SESSION['is_staff'] == 1) { ?>
<BR>
<div class="welcome" style="border: 2px solid;">
<strong>THIS PAGE IS ON HOLD</strong><BR>
This page will be available in a later release. For now, the other pages have been taking quite a lot of time. In the interest of moving things along in a timely manor I've decided to work on this page later.
</div>
<BR>

<table style="width: 100%; 
    <?php if (isset($_GET['invoice_id'])) { echo 'display: none;'; } ?> ">
    <thead>
        <tr class="list-header" >
        <th >Project Name</th>
        <th >Status</th>
        <th >$ Due</th>
    <?php if ($_SESSION['is_staff'] == '1') { ?>
        <th >Customer</th>
    <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php $invoice_query = $Controller->invoice_list(); ?>
    <?php if( $num_results > 0){ ?>
    <?php while($row = $invoice_query->fetch_assoc()){ ?>
            <?php $invoice_job_id = $row['job_id']; ?>
            <tr class="job-list" onclick="document.location = 'index.php?page=staff&staff_tab=3&invoice_id=<?php echo $row['invoice_id']; ?>';">
                
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
                                            echo "<div class='due-date'>";
                                            echo $row['c_total_amount_due'];
                                            echo "</div>";
                                        } ?>
                                </td>
                                
                            </tr>
                            
                        </table>
                    </div>
                    
                    <!--<div class="list-large-screen">
                    <?php //echo $row['invoice_name']; ?>
                    </div>-->
                
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
            <?php if ($_SESSION['is_staff'] == '0') { ?>
                <td class="list-large-screen">
                    <?php echo $row['c_total_amount']; ?>
                </td>
            <?php } ?>
                <td class="list-large-screen">
                    <?php
                        if ($row['c_total_amount_due'] <= '0.00'){
                            echo "<div class='due-date' id='paid'>";
                            echo 'PAID';
                            echo "</div>";
                        } else {
                            echo '$' . $row['c_total_amount_due'];
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
    </tbody>
</table>
    <?php } ?>

<?php if (isset($_GET['invoice_id'])) { 
//$_GET['quote_id'] = $_GET['quote'];?>
<BR>
<a href="index.php?page=staff&staff_tab=3"><div class="due-date" style="max-width: 200px;">Invoice List</div></a>
<BR>
<?php } ?>

<?php } ?>