<?php if ($_SESSION['is_staff'] == 1) { ?>


<table style="width: 100%; 
    <?php if (isset($_GET['quote_id'])) { echo 'display: none;'; } ?> ">
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
    <?php $quote_query = $Controller->quote_list(); ?>
    <?php if( $num_results > 0){ ?>
    <?php while($row = $quote_query->fetch_assoc()){ ?>
            <tr class="job-list" onclick="document.location = 'index.php?page=staff&quote_id=<?php echo $row['quote_id']; ?>';">
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
                    <?php echo $row['customer_name']; ?>
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
                    
                </td>
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
    </tbody>
</table>
    <?php } ?>





<?php if (isset($_GET['quote_id'])) { 
//$_GET['quote_id'] = $_GET['quote'];?>
<BR>
<a href="index.php?page=staff"><div class="due-date" style="max-width: 200px;">Quote List</div></a>
<BR>
    <?php $quote_query = $Controller->quote_list(); ?>
    <?php $num_results = $quote_query->num_rows; ?>
    <?php if( $num_results > 0){ ?>
    <?php $row = $quote_query->fetch_assoc(); ?>
        <?php if($row['quote_id'] = $_GET['quote_id']) { ?>

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

<table style="width: 100%;">
        <tr class="invoice-list-header">
            <th>#</th>
            <th>Project Item</th>
            <th>Hourly Rate</th>
            <th>Est. Hours</th>
            <th>Est. Amount</th>
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
                    } ?>

            <td class="invoice-list" style="max-width: 30px; min-width: 20px; text-align: center;">
                <?php echo $row['task_order']; ?>
            </td>
    
        <form method="post">
    
    
            <td class="invoice-list" style="max-width: 140px; min-width: 100px; text-align: center;">
                <input type="username" name="description" value="<?php echo htmlspecialchars($row['description']); ?>" 
                       style="width: 100%;">
                <input type="text" name="long_description" value="<?php echo htmlspecialchars($row['long_description']); ?>" 
                       style="width: 100%;">     
                <input type="submit" style="float: none;" name="quote_task_submit" value="Update">
            </td>
            <td class="invoice-list" style="width: 15%; text-align: center; vertical-align: top;">
                
                
                <input type="hidden" name="assigned_user" value="<?php echo $assigned_user; ?>">
                <input type="hidden" name="quote_id" value="<?php echo $_GET['quote_id']; ?>">
                <input type="hidden" name="task_order" value="<?php echo $task_results + 1; ?>">
                <input type="hidden" name="quote_task_id" value="<?php echo $row['quote_task_id']; ?>">
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
            <td class="invoice-list" style="width: 15%; text-align: center; vertical-align: top;">
                <input type="checkbox" name="no_hours" <?php if($row['hours']== 0) { echo 'checked'; }?>>N/A
                <input type="number" name="hours" value="<?php echo $row['hours']; ?>" 
                       style="width: 100%;">
            </td>
            <td class="invoice-list" style="width: 15%; text-align: center; vertical-align: top;">
                
                
                <input type="checkbox" name="taxable" value="1"
                       <?php if($row['taxable'] == 1) { echo 'checked'; }?>>Taxable
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
    </form>
        <?php $row_color++; } ?>
        <?php }}} ?>
<?php $task_query = $Controller->quote_list(); ?>
<?php $task_results = $task_query->num_rows; ?>
<?php if( $task_results > 0){ ?>
<?php $row = $task_query->fetch_assoc(); ?>
    </table>
    <table style="width: 100%; border: 0px solid #000; margin: 5px; padding: 5px;">
        <tr>
            <td style="width: 60%;"></td>
            <td style="text-align: right; padding: 2px; width: 25%;">Sub Total:&nbsp;</td>
            <td style="width: 10%;"><?php 
                    if($row['total_amount'] > 0) {
                        $total_amt = $row['total_amount'];
                    } else {
                        $total_amt = 0;
                    }                        
                    if ($row['total_hours'] > 0 && $row['total_amount'] == 0) {
                        $total_hourly = $row['hourly_rate'] * $row['total_hours'];
                    } elseif ($row['total_hours'] <= 0) {
                        $total_hourly = 0;
                    } else {
                        $total_hourly = 0;
                    }
                             
                    echo "<strong>$";
                    echo $total_amt + $total_hourly;
                    echo "</span></strong>";?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right; padding: 2px; width: 25%;">Tax <span style="font-size: 10px;">(<?php echo $row['percent'] ?>%)</span>:&nbsp;</td>
            <td style="width: 10%;">
                <?php 

                $taxable_query = $Controller->quote_get_tax_amount($row['quote_id']); 
                $taxable_results = $taxable_query->num_rows; 
                if( $taxable_results > 0){ 
                $row1 = $taxable_query->fetch_assoc(); 
                    if ($row1['total_hours_taxable'] > 0) {
                        $hourly_taxable = $row1['total_hours_taxable'] * $row1['hourly_rate'];
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
                    echo ($total_amt + $total_hourly) + $tax;
                    echo "</span></strong>";?>
            </td>
        </tr>
        <tr height="10px">        
        </tr>
        
    </table>
<?php } ?>

<?php
if (isset($_POST['quote_task_submit'])) {
    //$Controller->write_quote();
}?>
        <?php //echo $row['date_approved']; ?>

        <?php if($row['date_approved'] >= 0) { ?>
    
    
        <?php } ?>
    <?php } ?>
    <?php } ?>

    <?php } ?>

<?php } ?>