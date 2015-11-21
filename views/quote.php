<br>
<div class="invoice-display">
<?php $quote_query = $Controller->quote_list(); ?>
    <?php $num_results = $quote_query->num_rows; ?>
    <?php if( $num_results > 0){ ?>
    <?php $row = $quote_query->fetch_assoc(); ?>
        <?php if($row['quote_id'] = $_GET['quote_id']) { ?>
    
<?php
$customer_query = $Controller->get_customer_info($row['customer_id']);
$customer_row = $customer_query->fetch_assoc();
$user_query = $Controller->get_user_info_staff($customer_row['primary_user_id']);
$customer_info = $user_query->fetch_assoc();
    
$currency_query = $Controller->get_project_currency_data('quote', $_GET['quote_id']);
$currency_data = $currency_query->fetch_assoc();

$decimal = $currency_data['currency_decimal_separator'];
$thousands = $currency_data['currency_thousand_separator'];
$decimal_places = $currency_data['currency_decimal_places'];

?>

<table style="width: 100%;" border="0" cellspacing="0" cellpadding="1" align="center">
<tbody>
<tr>
    <td colspan="2" align="left" valign="top" width="60%">
        <img style="
                    display: block; 
                    margin-left: auto; 
                    margin-right: auto;
                    max-width: 90%;
                    max-height: 200px;" 
             title="Logo" 
             src="<?php echo $_GET['base_url'] . constant('LOGO_IMG');?>" 
             alt="Logo" 
            />
    </td>
    <td colspan="2" align="left" valign="top" width="39%">
        <table style="width: 100%;">
            <tr>
                <td>
        <span class="style11" style="font-size: x-large;">QUOTE </span>
                </td>
                </tr>
        <?php 
              if ($row['date_approved'] > 0){
                        echo "<tr><td>";
                            echo "<div class='due-date' id='approved' style='margin: 0px; width: 200px;'>";
                            echo '  <font style="font-size: 18px; font-weight: 600;">
                                    <strong>(Approved)</strong>
                                    </font>';
                            echo "<BR><font style='font-size: 10px;'>";
                            echo $row['date_approved'];
                            echo "</font>";
                            echo "</div>";
                        echo "</tr></td>";
                        } ?>
                
                
        </table>
        <BR>
        
        <p><span style="font-size: large;"><strong>Project: <?php echo $row['name']; ?>
            </strong></span></p><BR>
<br />
        <table>
        <tbody>
            <tr>
                <td><strong>Phone:</strong></td>
                <td><?php echo constant('PHONE_NUMBER'); ?></a></td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td><a href="mailto:<?php echo constant('SYSTEM_EMAIL'); ?>"><?php echo constant('SYSTEM_EMAIL'); ?></a></td>
            </tr>
            <tr>
                <td><strong>Web:</strong></td>
                <td><a href="<?php echo constant('MAIN_SITE'); ?>"><?php echo constant('COMPANY_NAME'); ?></a></td>
            </tr>
        </tbody>
        </table>
    </td>
    </tr>
    <tr>
        
        <TR></tr>
        <td style="text-align: right;"><strong>Quote Date:</strong></td>
        <td ><?php echo $row['date_created']; ?></td>
    </tr>
    
    </tbody>
    </table><BR>
    <h2>RECIPIENT</h2>
<?php $invoice_query = $Controller->invoice_list(); ?>
    <?php $num_results = $invoice_query->num_rows; ?>
    <?php if( $num_results > 0){ ?>
    <?php $row = $invoice_query->fetch_assoc(); ?>
    <table style="width: 100%;" border="0" cellspacing="0" cellpadding="1" align="center">
    <tbody>
    <tr>
        <td valign="top" width="15%"><strong>Company:</strong></td>
        <td valign="top" width="40%"><?php echo $customer_row['customer_name']; ?></td>
        <td valign="top" width="15%"><strong>&nbsp;Contact&nbsp;Phone:</strong></td>
        <td valign="top" width="30%">&nbsp;<span><?php echo $customer_info['phone']; ?></span></td>
    </tr>
    <tr>
        <td valign="top"><strong>Contact:</strong></td>
        <td valign="top"><?php echo $customer_info['name']; ?> <?php echo $customer_info['last_name']; ?></td>
        <td valign="top"><strong>&nbsp;Contact&nbsp;Email:</strong></td>
        <td valign="top">&nbsp;<?php echo $customer_info['email']; ?></td>
    </tr>
    </tbody>
    </table><?php } ?><BR>

<h2>QUOTE DETAILS</h2>
The following quote outlines the estimated price for this project. This includes estimations for the project(s), asset acquisition, revisions, discounts, and any extra fees. Estimations here are included as a point of reference but final pricing is subject to change.<BR><BR>
<?php
$title = "<font style='font-weight: 600;'>Project Description:</font>";
$description = $Controller->quote_description();    
if ($description != 'false') {
echo $title . $description;
}
?><BR>
    <table style="width: 100%;">
        <tr class="invoice-list-header">
            <th>#</th>
            <th>Project Item</th>
            <th>Hourly Rate/Price</th>
            <th>Est. Hours/Qty.</th>
            <th>Est. Total</th>
        </tr>
        <?php $task_query = $Controller->quote_task_list(); ?>
        <?php $task_results = $task_query->num_rows; ?>
        <?php if( $task_results > 0){ ?>
        <?php 
        $row_color=0;
        while($row_color < $task_results) {
            if($row['quote_id'] = $_GET['quote_id']) {
                while($row = $task_query->fetch_assoc()){ 
                    if ($row_color % 2 == 0){
                    echo "<tr class='invoice-list-light'>";
                    } else {
                    echo "<tr class='invoice-list-dark'>";
                    } 
                    
                //$task_type_query = $Controller->quote_list('NULL',$_GET['quote_id']);
                //$task_type_data = $task_type_query->fetch_assoc();
                if ($row['manual_task_type'] == '-1') {
                    $default_task_type = $Controller->default_task_type();
                } else {
                    $default_task_type = 'false';
                }
                
                if ($default_task_type == '0' || $row['manual_task_type'] == '0') {
                    $task_type = '0'; //hourly + amt
                } elseif ($default_task_type == '1' || $row['manual_task_type'] == '1'){
                    $task_type = '1'; //qty + amt
                } elseif ($default_task_type == '2' || $row['manual_task_type'] == '2'){
                    $task_type = '2'; //amt only
                }
            
        ?>
            <td class="invoice-list" style="max-width: 30px; min-width: 20px; text-align: center;">
                <?php echo $row['task_order']; ?>
            </td>
            <td class="invoice-list" style="max-width: 140px; min-width: 100px; text-align: left;">
                <?php echo $row['description']; ?><BR>
                <?php echo $row['long_description'];?>
            </td>
            <td class="invoice-list" style="width: 12%; text-align: center;">
                <?php
                if($row['hours']== 0 || $task_type == 2) {
                echo "-";
                } elseif($task_type == 1) {
                echo "$";
                echo $row['amount'] . "<span style='font-size: 10px;'>&nbsp;(Price)</span>";
                }else {
                echo "$";
                echo $row['hourly_rate'] . "<span style='font-size: 10px;'>&nbsp;(Rate)</span>";
                } ?>
            </td>
            <td class="invoice-list" style="width: 12%; text-align: center;">
                
                <?php if($row['hours'] == 0 || $task_type == 2) {
                echo "-";
                } else {
                    if ($task_type == 0) {
                    echo number_format((float)$row['hours'], $decimal_places, $decimal, $thousands);
                        echo "<span style='font-size: 10px;'>&nbsp;(Hrs.)</span>";
                    } elseif ($task_type == 1) {
                        echo floor($row['hours']);
                        echo "<span style='font-size: 10px;'>&nbsp;(Qty.)</span>";
                    }
                } ?>
            </td>
            <td class="invoice-list" style="width: 12%; text-align: center;">
                <?php 
                if ($row['taxable'] == 1) {
                    $taxable = "<span style='font-size: 10px;'>&nbsp;(+Tax)</span>";
                } else {
                    $taxable = "";
                }
                    
                     /*
                    if ($row['manual_task_type'] == -1 || $row['manual_task_type'] == 0) {
                        $a1amt_hrly = $row['total_amt_plus_hourly'];
                    } else {
                        $a1amt_hrly = 0;
                    }
                    if ($row['manual_task_type'] == 1) {
                        $a1quant_amt = $row['task_hours'] * $row['task_amount'];
                    } else {
                        $a1quant_amt = 0;
                    }
                    if ($row['manual_task_type'] == 2) {
                        $a1amt = $row['total_amount'];
                    } else {
                        $a1amt = 0;
                    }*/
            if ($task_type == '0') {
                if($row['amount'] > 0) {
                    echo "$";
                    echo number_format((float)$row['amount'], $decimal_places, $decimal, $thousands);
                    echo $taxable;
                } elseif ($row['hours'] > 0) {
                    echo "$";
                    $est_amt = $row['hourly_rate'] * $row['hours'];
                    echo number_format((float)$est_amt, $decimal_places, $decimal, $thousands);
                    echo $taxable;
                }
            } elseif ($task_type == 1) {
                if($row['amount'] > 0) {
                    echo "$";
                    $est_amt = $row['amount'] * $row['hours'];
                    echo number_format((float)$est_amt, $decimal_places, $decimal, $thousands);
                    echo $taxable;
                } elseif ($row['hours'] > 0) {
                    echo "-";
                    //echo "$";
                    //echo $row['amount'] * $row['hours'];
                    //echo $taxable;
                }
            } elseif ($task_type == 2) {
                if($row['amount'] > 0) {
                    echo "$";
                    $est_amt = $row['amount'];
                    echo number_format((float)$est_amt, $decimal_places, $decimal, $thousands);
                    echo $taxable;
                } else {
                    echo "-";
                    //echo $row['amount'] * $row['hours'];
                    //echo $taxable;
                }
            }
                ?>
            </td>

        </tr>
        <?php $row_color++; } ?>
        <?php }}} ?>
<?php $task_query = $Controller->quote_list('NULL',$_GET['quote_id']); ?>
<?php $task_results = $task_query->num_rows; ?>
<?php //if( $task_results > 0){ ?>
<?php $quote_info = $task_query->fetch_assoc(); ?>
    </table>
    <table style="width: 100%; border: 0px solid #000; margin: 5px; padding: 5px;">
        <tr>
            <td style="width: 60%;"></td>
            <td style="text-align: right; padding: 2px; width: 25%;">Sub Total:&nbsp;</td>
            <td style="width: 10%;">
        <?php 
        
        
                $total_hourly_plus_amount = 0;
                $total_quantity = 0;
                $total_amount = 0;
            $total_query = $Controller->quote_list('NULL',$_GET['quote_id']);
            while($row = $total_query->fetch_assoc()){
                if ($row['manual_task_type'] == '-1') {
                    $default_task_type = $Controller->default_task_type();
                } else {
                    $default_task_type = 'false';
                }
                
                if ($default_task_type == '0' || $row['manual_task_type'] == '0') {
                    $total_hourly_plus_amount += $row['task_amount'] + ($row['task_hours'] * $row['hourly_rate']);
                } elseif ($default_task_type == '1' || $row['manual_task_type'] == '1'){
                    $total_quantity += $row['task_hours'] * $row['task_amount'];
                } elseif ($default_task_type == '2' || $row['manual_task_type'] == '2'){
                    $total_amount += $row['task_amount'];
                }
            }
    
            $sum_total = $total_hourly_plus_amount + $total_quantity + $total_amount;
                    
                    echo "<strong>";
                    echo $currency_data['symbol'];
                    echo number_format((float)$sum_total, $decimal_places, $decimal, $thousands);
                    echo "</span></strong>";
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right; padding: 2px; width: 25%;">Tax <span style="font-size: 10px;">(<?php echo $quote_info['tax_percent'] ?>%)</span>:&nbsp;</td>
            <td style="width: 10%;">
                <?php 
                $taxable_hourly_plus_amount = 0;
                $taxable_quantity = 0;
                $taxable_amount = 0;
            $tax_query = $Controller->quote_list('NULL',$_GET['quote_id']);
            while($row = $tax_query->fetch_assoc()){
                if ($row['manual_task_type'] = '-1') {
                    $default_task_type = $Controller->default_task_type();
                } else {
                    $default_task_type = 'false';
                }
                    if ($default_task_type == '0' || $row['manual_task_type'] == '0') {
                        if ($row['taxable'] == 1) {
                        $taxable_hourly_plus_amount += $row['task_amount'] + ($row['task_hours'] * $row['hourly_rate']);
                        }
                    } elseif ($default_task_type == '1' || $row['manual_task_type'] == '1'){
                        if ($row['taxable'] == 1) {
                        $taxable_quantity += $row['task_hours'] * $row['task_amount'];
                        }
                    } elseif ($default_task_type == '2' || $row['manual_task_type'] == '2'){
                        if ($row['taxable'] == 1) {
                        $taxable_amount += $row['task_amount'];
                        }
                    }
                
            }    
                
                    
            $taxable_total = $taxable_quantity + $taxable_quantity + $taxable_amount;
            //echo $taxable_total;
                    
                $tax = ($taxable_total * $quote_info['tax_percent']) / 100;
                   /*     
                $taxable_query = $Controller->quote_get_tax_amount($row['quote_id']); 
                $taxable_results = $taxable_query->num_rows; 
                $tax_data = $taxable_query->fetch_assoc(); 
                if($taxable_results > 0){ 
                    if ($tax_data['total_hours_taxable'] > 0) {
                        $hourly_taxable = $tax_data['total_hours_taxable'] * $tax_data['hourly_rate'];
                        $hourly_tax = $hourly_taxable / $tax_data['percent'];
                    } else {
                        $hourly_tax = 0;
                    }
                    if ($tax_data['total_amount_taxable'] > 0) {
                        $amount_tax = $tax_data['total_amount_taxable'] / $tax_data['percent'];
                    } else {
                        $amount_tax = '0';
                    }
                    
                    $tax = $amount_tax + $hourly_tax;
                    */
                    echo "<strong>";
                    echo $currency_data['symbol'];
                    echo number_format((float)$tax, $decimal_places, $decimal, $thousands);
                    echo "</span></strong>";
                //}
                ?>
                    
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right; padding: 2px; width: 25%;">Est. Total:&nbsp;</td>
            <td style="width: 10%;"><?php 
                $format_total = $sum_total + $tax;
                    echo "<strong>";
                    echo $currency_data['symbol'];
                    echo number_format((float)$format_total, $decimal_places, $decimal, $thousands);
                    echo "</span></strong>";?>
            </td>
        </tr>
        <tr height="10px">        
        </tr>
        
    </table>


    <HR>
<table width="95%">
    <tr>
        <td style="vertical-align: top;">
        <h2>APPROVAL</h2>
        </td>
        <td style="vertical-align: top;">
<div class="welcome">
You can approve this quote clicking the button below. Once approved, steps will be taken to complete this project.<br>
<input type="button" value="Approve Quote" style="
    font-size: 14px;
	font-weight: 600;
	width:150px;
	border: 1px solid #909090;
    float: none;
	background:#e4e4e4;
	background-image:linear-gradient(bottom, #e4e4e4 0%, #f4f4f4 52%);
	background-image:-moz-linear-gradient(bottom, #e4e4e4 0%, #f4f4f4 52%);
	background-image:-webkit-linear-gradient(bottom, #e4e4e4 0%, #f4f4f4 52%);
	color:#404040;
	margin-top: 5px;
    margin-bottom: 5px;
	padding:8px;
	border-radius:5px;
    " onclick="location.href='<?php echo $Controller->quote_link($_GET['quote_id']); ?>';" />
</div>
        </td>
    </tr>
</table>
    </div>
</div>

<BR>
            <div style="text-align: center; font-weight: 600;">
                Problems with the quote? Please leave a note below if this quote does not meet your approval.
            </div>
                <form id="form" method="post" action='index.php?page=send&quote_id=<?php echo $_GET['quote_id']; ?>' style="max-width: 800px;">
                    <label>
                        <textarea name="comment" id="comment" placeholder="Type your comment here" required></textarea>
                    </label>
                    <input type="hidden" name="user_id" value="<?php echo $row['user_id'] ?>">
                    <input type="hidden" name="quote_id" value="<?php echo $_GET['quote_id'] ?>">
            
                    <input type="submit" id="submit" name="submit_comment" value="Submit Comment">
                    
                </form>
                    <BR>
                    <div class="welcome">
    If you would like to print a copy of this quote for your records, please click the button below.<BR><BR>
<script type="text/javascript">

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Project Quote</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>
<input type="submit" value="Print" style="float: none;" onclick="PrintElem('.wrap')" />
</div>

<BR><BR>
<?php //} ?>
<?php }} ?>