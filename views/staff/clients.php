<?php if ($_SESSION['is_staff'] == 1) { ?>


<table style="width: 100%; 
    <?php if (isset($_GET['user_id'])) { echo 'display: none;'; } ?> ">
    <thead>
        <tr class="list-header" >
        <th >Contact</th>
        <th >Status</th>
    <?php if ($_SESSION['is_staff'] == '1') { ?>
        <th >Customer</th>
    <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php $user_query = $Controller->get_user_info_staff(); ?>
    <?php if( $num_results > 0){ ?>
    <?php while($row = $user_query->fetch_assoc()){ ?>
        
<?php $quote_query = $Controller->quote_list($row['customer_id']); ?>
    <?php $num_results = $quote_query->num_rows; ?>
    <?php if( $num_results > 0){ ?>
        <?php $row_q = $quote_query->fetch_assoc(); ?>
    <?php } ?>
                        
<?php /*$invoice_query = $Controller->invoice_list(); ?>
    <?php $num_results = $invoice_query->num_rows; ?>
    <?php if( $num_results > 0){ ?>
        <?php $row_i = $invoice_query->fetch_assoc(); ?>
    <?php } */?>
                        
<?php $project_query = $Controller->projects_list('0, 1', 0, $row['customer_id']); ?>
    <?php $num_results = $project_query->num_rows; ?>
    <?php if( $num_results > 0){ ?>
        <?php $row_p = $project_query->fetch_assoc(); ?>
    <?php } ?>

            <tr class="job-list" onclick="document.location = 'index.php?page=staff&staff_tab=4&user_id=<?php echo $row['user_id']; ?>';">
                <td style="text-align: center;">
                    <div class="list-large-screen" style="text-align: left;">
                        <?php echo $row['name']; ?>
                        <?php echo $row['last_name']; ?>
                    </div>
                    <div class="list-small-screen">
                                <div style='width: 100%; text-align: center; font-weight: 600; font-size: 18px;'>
                                    <?php echo $row['name']; ?>
                                    <?php echo $row['last_name']; ?>
                                </div>
                            </div>
                    <div class="list-small-screen" style="width: 100%;">
                    <?php echo $row['customer_name']; ?>
                    </div>
                    <div class="list-small-screen" style="width: 100%;">
                        
                            <?php
                                    echo $row_q['date_approved'];
                                if ($row_q['date_approved'] != 0) {
                                    echo "<div class='due-date' id='pending'>";
                                    echo 'Pending Quote';
                                    echo "</div>";
                                }
                             ?>
                    </div>
                    
                </td>
                </td>
                
                
                <td class="list-large-screen" style="text-align: center;">
                    <?php
                        $row_q = $quote_query->fetch_assoc();
                            if ($row['primary_user_id'] == $row['user_id']) {
                                if ($row_q['date_approved'] == 0) {
                                    echo "<div class='due-date' id='pending'>";
                                    echo 'Pending Quote(s)';
                                    echo "</div>";
                                }
                                
                                $project_query2 = $Controller->projects_list('0, 1', 0, $row['customer_id'], 'inProgress');
                                $num_results = $project_query2->num_rows;
                                if( $num_results > 0){    
                                    
                                    echo "<div class='due-date' id='pending'>";
                                    echo 'Project(s) in progress';
                                    echo "</div>";
                                }
                                
                                $project_query1 = $Controller->projects_list('0, 1', 0, $row['customer_id'], 'pastDue');
                                $num_results = $project_query1->num_rows;
                                if( $num_results > 0){    
                                
                                    echo "<div class='due-date' id='pastDue'>";
                                    echo 'Project(s) Overdue!';
                                    echo "</div>";
                                }
                                
                                $invoice_query2 = $Controller->invoice_list('0', 'NULL', $row['customer_id'], 'inProgress');
                                $num_results2 = $invoice_query2->num_rows;
                                if( $num_results2 > 0){    
                                
                                    echo "<div class='due-date' id='pending'>";
                                    echo 'Pending Invoice(s)';
                                    echo "</div>";
                                }
                                
                                $invoice_query1 = $Controller->invoice_list('0', 'NULL', $row['customer_id'], 'pastDue');
                                $num_results1 = $invoice_query1->num_rows;
                                if( $num_results1 > 0){    
                                
                                    echo "<div class='due-date' id='pastDue'>";
                                    echo 'Overdue Invoice(s)';
                                    echo "</div>";
                                }
                                
                            }
                             ?>
                </td>
            <?php if ($_SESSION['is_staff'] == '1') { ?>
                <td class="list-large-screen" style="text-align: right;">
                    <?php echo $row['customer_name']; ?>
                </td>
            <?php } ?>
                </tr>
                </a>


        <?php } ?>
    </tbody>
</table>
    <?php } ?>





<?php if (isset($_GET['user_id'])) { 
//$_GET['quote_id'] = $_GET['quote'];?>
<BR>
<a href="index.php?page=staff&staff_tab=4"><div class="due-date" style="max-width: 200px;">Client List</div></a>
<BR>
<?
$user_query = $Controller->get_user_info_staff($_GET['user_id']); 
$num_results = $user_query->num_rows; 
if( $num_results > 0){ 
    $row = $user_query->fetch_assoc(); }
?>
<table style="width: 100%; padding: 5px; margin: 0 auto;">
    <tr>
        <td class="jlist-large-screen">
            <a href="http://www.gravatar.com">
            <img src="<?php echo $Controller->avatar($row['email'], '100px'); ?>" 
                 alt="avatar" style="border: 2px solid e0e0e0;">        
            </a>
        </td>
        <td>
<table style="width: 100%; border: 2px solid #f0f0f0; padding: 5px; margin: 0 auto;">
            <tr style="background-color: #f0f0f0;">
                <td style="text-align: right; padding: 5px;">
                    Company:
                </td>
                <td style="text-align: right; padding: 5px;">
                    <?php echo $row['customer_name']; ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right; padding: 5px;">
                    Name:
                </td>
                <td style="text-align: right; padding: 5px;">
                    <?php echo $row['name'] . ' ' . $row['last_name']; ?>
                </td>
            </tr>
            <tr style="text-align: right; background-color: #f0f0f0;">
                <td style="text-align: right; padding: 5px;">
                    Email:
                </td>
                <td style="padding: 5px;">
                    <?php echo $row['email']; ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right; padding: 5px;">
                    Phone:
                </td>
                <td style="text-align: right; padding: 5px;">
                    <?php 
                    echo $row['phone'];
                    ?>
                </td>
            </tr>
        </table> 
        </td>
    </tr>
</table>
    
    
<script language="JavaScript">
function randomPassword(length)
{
  chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
  pass = "";
  for(x=0;x<8;x++)
  {
    i = Math.floor(Math.random() * 62);
    pass += chars.charAt(i);
  }
  return pass;
}
function genPass()
{
  editUserInfo.new_pass.value = randomPassword(editUserInfo.length.value);
  return false;
}
</script>
    
<form method="post" name="editUserInfo">
    <input type="checkbox" id="clientInfoCheckbox" name="edit_client_info" value="1" > Edit Client Info<BR>
<script>
$(document).ready(function () {
     $('#clientInfoCheckbox').click(function () {
         var $this = $(this);
         if ($this.is(':checked')) {
             $('#clientInfoDiv').fadeIn();
             $('#clientInfoDiv').show();
             $('#newPassDiv').fadeIn();
             $('#newPassDiv').hide();
         } else {
             $('#clientInfoDiv').fadeIn();
             $('#clientInfoDiv').hide();
             $('#newPassDiv').fadeIn();
             $('#newPassDiv').show();
         }
     });
 });    
</script>
    <BR>
<div id="clientInfoDiv" style="display: none; text-align: right;">

        <table style="text-align: right; width: 100%;">
        <tr>
            <td style="width: 100%;">
            </td>
            <td style="text-align: right;">
        Name:&nbsp;
            </td>
            <td>
        <input type="username" name="first_name" style="max-width: 140px;" placeholder="<?php echo $row['name']; ?>"><BR>
        <input type="username" name="last_name" style="max-width: 140px;" placeholder="<?php echo $row['last_name']; ?>">
            </td>
        </tr>
        <tr>
            <td style="width: 100%;">
            </td>
            <td style="text-align: right;">
        Email:&nbsp;
            </td>
            <td>
        <input type="username" name="email" style="max-width: 240px;" placeholder="<?php echo $row['email']; ?>">
            </td>
        </tr>
        <tr>
            <td style="width: 100%;">
            </td>
            <td style="text-align: right;">
        Phone:&nbsp;
            </td>
            <td>
        <input type="username" name="phone" style="max-width: 240px;" placeholder="<?php echo $row['phone']; ?>">
            </td>
        </tr>
        <tr>
            <td style="width: 100%;">
            </td>
            <td style="text-align: right;">
        Password:&nbsp;
            </td>
            <td>
        <input type="button" value="Generate" onClick="javascript:genPass()"> 
        <input type="password" name="new_pass" style="max-width: 120px;"><BR>
                <span style="font-size: 10px; color: #b60000;">
                    Only use this option when the client needs a new password. If you leave this field blank the password remain unchanged.
                </span>
            </td>
        </tr>
        <tr>
            <td style="width: 100%;">
            </td>
            <td>
            </td>
            <td>
                <HR style="margin: 5px;">
        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
        <!-- <input type="hidden" name="edit_user_info" value="1"> -->
        <input type="submit" name="update_user_staff" value="Submit">
            </td>
        </tr>
        </table>
    
</div>
    </form>
<div id="newPassDiv">
<BR>
<HR>
<BR>
<div style="width: 85%; margin: 0 auto;">
If you'd like to generate a new password and send it to the client please use the box below. <BR><BR>When you press "Submit" the new password will be written to the database and an email will be sent to the client containing the new password.<BR><BR>
</div>
<div style="border: 1px solid; max-width: 200px; padding: 10px; margin: 0 auto;">
    
<script language="JavaScript">
function randomPassword(length)
{
  chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
  pass = "";
  for(x=0;x<8;x++)
  {
    i = Math.floor(Math.random() * 62);
    pass += chars.charAt(i);
  }
  return pass;
}
function formSubmit()
{
  passform.new_pass.value = randomPassword(passform.length.value);
  return false;
}
</script>

<center>
<form method="post" name="passform">
    New Password:<BR><HR style="margin: 5px;">
<input type="button" value="Generate" onClick="javascript:formSubmit()"> 
<input type="password" name="new_pass" style="max-width: 100px;">
<BR>
<input type="submit" name="update_user_staff" value="Submit">
<input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
</form>
</center>
</div>
</div>
<BR>

<?php } ?>


<?php } ?>