<br>
<div class="invoice-display">
<?php $invoice_query = $Controller->invoice_list(1, $_GET['invoice_id']); ?>
    <?php $num_results = $invoice_query->num_rows; ?>
    <?php if( $num_results > 0){ ?>
    <?php $row = $invoice_query->fetch_assoc(); ?>
        <?php $invoice_job_id = $row['job_id']; ?>
            <?php //if($row['invoice_id'] = $_GET['invoice_id']) { ?>

    
<?php

$currency_query = $Controller->get_project_currency_data('invoice', $_GET['invoice_id']);
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
            /><BR>
    </td>
    <td colspan="2" align="left" valign="top" width="39%">
        <span class="style11" style="font-size: x-large;">INVOICE </span>
        <?php if ($row['invoice_status'] == 'PAID') { ?>
        <span style="font-size: x-large;"><strong>(PAID)</strong></span>
        <?php } ?><BR><BR>
        
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
        <td style="text-align: left; width: 12%;"><strong>Invoice #:</strong></td>
        <td style="text-align: left;">&nbsp;<span><?php echo $row['invoice_name']; ?></span></td>
        
        <td style="text-align: right;"><strong>Due Date:</strong></td>
        <td ><?php echo $row['invoice_date_due']; ?></td>
    </tr>
    <tr>
        <td style="text-align: right;">
            <?php if ($row['invoice_status'] == 'PAID') { ?>
                <span style="font-size: x-large;"><strong>Date Paid: </strong></span>
            <?php } ?>
            <td ></td>
            <?php if ($row['invoice_status'] == 'PAID') { ?>
            <?php echo $row['date_paid']; } ?>
        </td>
        <td style="text-align: right;"><strong>Invoice Date: </strong></td>
        <td ><span><?php echo $row['invoice_date_create']; ?></span></td>
        
    </tr>
    </tbody>
    </table><BR>
    <h2>RECIPIENT</h2>
    <table style="width: 100%;" border="0" cellspacing="0" cellpadding="1" align="center">
    <tbody>
    <tr>
        <td valign="top" width="15%"><strong>Company:</strong></td>
        <td valign="top" width="40%"><?php echo $row['customer_name']; ?></td>
        <td valign="top" width="15%"><strong>&nbsp;Contact&nbsp;Phone:</strong></td>
        <td valign="top" width="30%">&nbsp;<span><?php echo $row['phone']; ?></span></td>
    </tr>
    <tr>
        <td valign="top"><strong>Contact:</strong></td>
        <td valign="top"><?php echo $row['user_first']; ?> <?php echo $row['last_name']; ?></td>
        <td valign="top"><strong>&nbsp;Contact&nbsp;Email:</strong></td>
        <td valign="top">&nbsp;<?php echo $row['email']; ?></td>
    </tr>
    </tbody>
    </table><BR>
<h2>INVOICE DETAILS</h2>
    <table style="width: 100%;">
        <tr class="invoice-list-header">
            <th>#</th>
            <th>Project Item</th>
            <th>Date Done</th>
            <th>Rate/Price</th>
            <th>Hours/Qty.</th>
            <th>Totals</th>
        </tr>
        <?php $task_query = $Controller->task_list('0', 'NULL', '0'); ?>
        <?php $task_results = $task_query->num_rows; ?>
        <?php if( $task_results > 0){ ?>
        <?php 
        $row_color=0;
        while($row_color < $task_results) {
            if($row['invoice_id'] = $_GET['invoice_id']) {
                while($row = $task_query->fetch_assoc()){ 
                    if ($row_color % 2 == 0){
                    echo "<tr class='invoice-list-light'>";
                    } else {
                    echo "<tr class='invoice-list-dark'>";
                    } ?>
        
        <?php
                    
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
                
                if ($row['hourly_rate'] == '-1.00') {
                    $default_rate = $Controller->default_task_type(1);
                } else {
                    $default_rate = $row['hourly_rate'];
                }
    $hourly_rate = number_format((float)$default_rate, $decimal_places, $decimal, $thousands);
                    
                
                    
                    ?>

            <td class="invoice-list" style="max-width: 30px; min-width: 20px; text-align: center;">
                <?php echo $row['task_order']; ?>
            </td>
            <td class="invoice-list" style="max-width: 140px; min-width: 100px; text-align: left;">
                <?php echo $row['description']; ?><BR>
                <?php echo $row['long_description'];?>
            </td>
            <td class="invoice-list" style="width: 12%; text-align: center;">
                <?php echo $row['date_done']; ?>
            </td>
            <td class="invoice-list" style="width: 12%; text-align: center;">
                <?php 
                if($row['hours']== 0 || $task_type == 2) {
                echo "-";
                } elseif($task_type == 1) {
                echo "$";
                echo $hourly_rate . "<span style='font-size: 10px;'>&nbsp;(Price)</span>";
                }else {
                echo "$";
                echo $hourly_rate . "<span style='font-size: 10px;'>&nbsp;(Rate)</span>";
                }
                ?>
            </td>
            <td class="invoice-list" style="width: 12%; text-align: center;">
                <?php 
                    if($row['hours'] == 0 || $task_type == 2) {
                echo "-";
                } else {
                    if ($task_type == 0) {
                    echo number_format((float)$row['hours'], $decimal_places, $decimal, $thousands);
                        echo "<span style='font-size: 10px;'>&nbsp;(Hrs.)</span>";
                    } elseif ($task_type == 1) {
                        echo floor($row['hours']);
                        echo "<span style='font-size: 10px;'>&nbsp;(Qty.)</span>";
                    }
                }
                    
                    
                    
                 ?>
            </td>
            <td class="invoice-list" style="width: 12%; text-align: center;">
                <?php
                if ($row['taxable'] == 1) {
                    $taxable = "<span style='font-size: 10px;'>&nbsp;(+Tax)</span>";
                } else {
                    $taxable = "";
                }
                    
                    
                ?>
                <?php echo "$"; echo $row['amount'] . $taxable;?>
            </td>
        </tr>
        <?php $row_color++; } ?>
        <?php }}} ?>
<?php $task_query = $Controller->task_list('0', 'NULL', '0'); ?>
<?php $task_results = $task_query->num_rows; ?>
<?php if( $task_results > 0){ ?>
<?php $row = $task_query->fetch_assoc(); ?>
    </table>
    <table style="width: 100%; border: 0px solid #000; margin: 5px; padding: 5px;">
        <tr>
            <td style="width: 60%;"></td>
            <td style="text-align: right; padding: 2px; width: 25%;">Sub Total:&nbsp;</td>
            <td style="width: 15%;"><?php 
                    $sub_total = $Controller->task_list_subtotal();

                    echo "<strong>";
                    echo $currency_data['symbol'];
                    echo number_format((float)$sub_total, $decimal_places, $decimal, $thousands);
                    echo "</span></strong>";
                
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right; padding: 2px; width: 25%;">Tax:&nbsp;</td>
            <td style="width: 15%;"><?php 
                    $tax = $row['c_total_amount'] - $Controller->task_list_subtotal(); 
                             
                    echo "<strong>";
                    echo $currency_data['symbol'];
                    echo number_format((float)$tax, $decimal_places, $decimal, $thousands);
                    echo "</span></strong>";
                
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right; padding: 2px; width: 25%;">Total:&nbsp;</td>
            <td style="width: 15%;"><?php 
                    $total = $row['c_total_amount'];
                    
                    echo "<strong>";
                    echo $currency_data['symbol'];
                    echo number_format((float)$total, $decimal_places, $decimal, $thousands);
                    echo "</span></strong>";
                
                ?>
            </td>
        </tr>
        <tr height="10px">        
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right; padding: 2px; width: 25%;">Paid:&nbsp;</td>
            <td><?php 
                    $paid = $row['c_total_amount'] - $row['c_total_amount_due'];
                    if ($paid > 0) {
                        echo "<span style='color: #00c000'><strong>";
                    } else {
                        echo "<span style='color: #f00000'><strong>";
                    }
                    echo "$";
                    echo $paid;
                    echo "</span></strong>";
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right; padding: 2px; width: 25%;">Due:&nbsp;</td>
            <td style="width: 15%;"><?php 
                    $due = $row['c_total_amount_due'];
                    if ($due <= 0) {
                        echo "<span style='color: #00c000'><strong>";
                    } else {
                        echo "<span style='color: #f00000'><strong>";
                    }
                    echo "$";
                    echo $due;
                    echo "</span></strong>";
                ?>
            </td>
        </tr>
    </table>

<?php } ?>
<?php }  //} ?>
    

    </div>
</div>

<div style="margin: 0 auto; width: 90%;">
<table width="95%">
    <tr>
        <td style="vertical-align: top;">
        <h2>PAYMENT</h2>
        </td>
        <td>
<div style="padding: 12px">
You can view payment options for this invoice clicking the "Payment Options" button.
</div>
    </td>
        <td>
<input type="button" value="Payment Options" style="
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
    " onclick="location.href='<?php echo $Controller->invoice_link($_GET['invoice_id']); ?>';" />

        </td>
    </tr>
</table>
</div>
<HR>

<div class="welcome">
    If you would like to print a copy of this invoice for your records, please click the button below.<BR><BR>
<script type="text/javascript">

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'Invoice Print', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Invoice Print</title>');
        /*optional stylesheet*/ 
    mywindow.document.write('<link rel="stylesheet" href="custom/custom.css" type="text/css" />');
        
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>

<input type="submit" value="Print" style="float: none;" onclick="PrintElem('.invoice-display')" />
</div>



