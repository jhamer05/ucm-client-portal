<BR><BR>
<?php if ($_SESSION['user_id'] == 1) { ?>
<?php require_once('version.php'); ?>
<div class="inner">
<form method="post" enctype="multipart/form-data" id="main">
    <div style="text-align: right;">

<?php /*
$CurlStart = curl_init();
curl_setopt ($CurlStart, CURLOPT_URL, "http://www.gamersfirst.com/warrock/?q=Player&nickname=soldier");
curl_setopt ($CurlStart, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt ($CurlStart, CURLOPT_REFERER, $url);
curl_setopt ($CurlStart, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; nl; rv:1.9.1.11) Gecko/20100701 Firefox/3.5.11");
curl_setopt ($CurlStart, CURLOPT_HEADER, 1);
curl_setopt ($CurlStart, CURLOPT_FOLLOWLOCATION, true);
$source = curl_exec ($CurlStart);
curl_close ($CurlStart);

$a=preg_match("/>Level:.*.\n.*.>([0-9]*)</",$source,$b);
$Level = $b;//[1];
echo "Level: $Level";
*/?>
<ul style="padding: 10px;">
    <?php
/* ====== Check Versions ====== */
    if (!isset($_POST['file_select'])) {
$url = 'http://ucmclientportal.com/version-history/';
if ($content = @file_get_contents($url)) {
    $first_step = explode( '<strong id="current_version">' , $content );
    $second_step = explode("</strong>" , $first_step[1] );

    $latest_version = $second_step[0];
} else {
    $latest_version = "unavailable";
}

    ?><center>
        The version of this system is <strong>
        v<?php echo constant('SYSTEM_VERSION') ?>.</strong><BR>
    <?php 
        
    if ($latest_version != "unavailable") { /* ?>
        The latest stable version is <strong><?php echo $latest_version; ?>
    <?php */ ?>
    </strong><BR><BR>
        </center>
    <div style="margin: 0 auto; text-align: left; width: 80%; border: 1px solid; padding: 5px;">
    <?php 
/* ====== Version Messages & Links ====== */
    echo "This project is now open source. For more information please visit <a href='http://ucmcp.jchdesign.com/'>UCMCP.JCHDesign.com</a>.";
          /*                                 
    if ($latest_version > constant('SYSTEM_VERSION')) { 
        
        echo 'Please download the update to have access to the latest features and fixes. More information on this update can be found on <a href="http://ucmclientportal.com/version-history/">UCMClientPortal.com</a>.<BR>
        <input type="submit" style="padding: 4px; width: auto;" name="get_latest" value="Get the Latest Version"/>
        <BR><!--
        You can also find the latest version on the <a href="http://codecanyon.net/item/ucm-client-portal/9457490" target="_blank">Envato Market</a>.-->
        ';
    
        if (isset($_POST['get_latest'])) {
        echo "<script>window.location = 'http://ucmclientportal.com/checkout/purchase-history/'</script>";
        }
    } elseif ($latest_version < constant('SYSTEM_VERSION')) {
        
        echo 'Looks like you\'re using a beta or test build that is newer than the current version. If you\'re having problems with instability please use the updater to roll back to the latest stable build.<BR>
        <input type="submit" style="padding: 4px; width: auto;" name="get_latest" value="Get the Latest Version"/>
        <BR><!--
        You can also find the latest version on the <a href="http://codecanyon.net/item/ucm-client-portal/9457490" target="_blank">Envato Market</a>.-->
        ';
            
        if (isset($_POST['get_latest'])) {
        echo "<script>window.location = 'http://ucmclientportal.com/checkout/purchase-history/'</script>";
        }
    } else {
        echo "Looks like you're all up to date. For a complete version history please visit <a href='http://ucmcp.jchdesign.com/index.php?page=version_history'>UCMCP.JCHDesign.com</a>.";
    } */
        ?>
    </div>
    <?php 
    } else {
        echo "<BR><strong>There was a problem contacting the server.</strong><BR>
        For more information please visit <a href='http://ucmcp.jchdesign.com/'>UCMCP.JCHDesign.com</a>.";
        echo "</center>";
    }
    ?>
<BR><BR>
<?php
/* ====== File Selection ====== */

?>
    <center>
        Please select the update you wish to apply.
    </center>
<BR>
<div style="border: 0px solid; width: 80%; text-align: left; padding: 0px; margin: 0 auto;">
    <table style="width: 100%; border: 1px solid;">
        <tr class="wrap-header"><td style="padding: 2px;">
            <h2 class="wrap-title" style="font-size: 18px; text-align: left;">List of files:</h2>
        </thead>
        <tr>
            <td style="padding: 2px;">
        <?php
    if ($handle = opendir('views/admin/update/update-files')) {
    $ignore = array( 'cgi-bin', '.', '..','._' );
    while (false !== ($file = readdir($handle))) {
        if (!in_array($file,$ignore) and substr($file, 0, 1) != '.') {
            
            $select_file = "views/admin/update/update-files/" . $file;
            echo '
            <tr><td style="padding: 5px;">
            <input type="radio" name="file_select" value="' . $select_file . '" >
            <a href="views/admin/update/update-files/'.$file.'">'.$file.'</a>
            </td></tr>';
            $files_exist = 1;
        } else {
            $files_exist = 0;
        }
    }
    closedir($handle);
        if ($files_exist != 1) {
            echo "You have not uploaded any update files.";
        }
}
?>
    
            </td>
        </tr>
    </table>
    <input type="submit" style="padding: 4px; width: auto;" name="delete_all_files" value="Delete All Update Files" />
</div>
    <BR><BR>
    Upload a new file
    &nbsp;-&nbsp;
    <input name="file" type="file" /><BR>
    
</ul>
    <input type="hidden" name="admin_tab=3">
    <input type="hidden"  name="update_page">
        
    <div class="welcome">
        <table style="width: 100%; padding: 5px; margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
    <input type="submit"  name="update_file_input" value="Upload" />
            </td>
            <td style="text-align: center;">
    <input type="submit" name="submit_update" value="Update" />
            </td>
        </tr>
        </table>
    </div>
       
        
        
<?php
/* ====== Check If File is Selected ====== */
    if (isset($_POST['submit_update']) && !isset($_POST['file_select'])) {
        echo "<p style='text-align: center; color: #b60000; background: #f0f0f0; padding: 5px;'>
        Please choose an update to apply before pressing \"Update\".
        </p>";
    }
?>
        
        
    <?php
/* ====== Delete Files ====== */
    if (isset($_POST['delete_all_files'])) {
        $files = glob('views/admin/update/update-files/*'); // get all file names
        foreach($files as $file){ // iterate files
          if(is_file($file))
            unlink($file); // delete file
        }
        echo "<script>window.location = 'index.php?page=admin&admin_tab=3&update_page=1'</script>";
    }
    ?>

<BR><BR>
</form>
<?php
        
        
        
/* ====== Confirmation ====== */
        
    } elseif (isset($_POST['file_select']) && !isset($_POST['confirm_update'])) {
        //$_POST['file_select'] = $_POST['file_select'];
        
        echo "<center><strong>" . $_POST['file_select'] . "</center></strong>";
        
        $file_info = new SplFileInfo($_POST['file_select']);
        if ($file_info->getExtension() == "zip") { 
            $zip = new ZipArchive();
            $file = $_POST['file_select'];
            if (!$zip->open($file)) {
                exit('failed');
                echo "There was an error opening the file.";
            } 
            $locate_version_php = $zip->locateName('version.php', ZipArchive::FL_NOCASE|ZipArchive::FL_NODIR);
$zip->close();
            //if($zip->open($_POST['file_select']) === TRUE ) {  
            if ($locate_version_php !== "false") {
                $package_verification_min = 1;
                } else {
                    $package_verification_min = 0;
                }
            
            if ($package_verification_min == 0) {
                echo "<p style='text-align: center; color: #b60000; background: #f0f0f0; padding: 5px;'>
                    This is not a proper update package!</p> Please download a valid package to continue. Valid \".zip\" files are available on <a href='http://ucmclientportal.com/'>UCMClientPortal.com</a> or on the Envato Market.<BR><BR>";
            } elseif ($package_verification_min == 1) {
            
    ?>
        <div style="margin: 0 auto; text-align: left; width: 80%; border: 1px solid; padding: 5px;">
        This updater will copy the contents of the selected ".zip" file into the base directory of this system. It will overwrite any existing files in the process. The "custom" and "config" folders are generaly safe from this process so you shouldn't lose any custom settings.
        <BR><BR>
        <center>
            Are you sure you wish to continue?
            <form method="post" enctype="multipart/form-data" id="confirm">
            <input type="hidden" name="admin_tab=3">
            <input type="hidden"  name="update_page">
            <input type="hidden"  name="file_select" value="<?php echo $_POST['file_select']; ?>" />
            <input type="submit"  name="confirm_update" value="Proceed" />
            </form>
        </center>
        </div>
        <?php }
        
        
        } else {
            echo "<p style='text-align: center; color: #b60000; background: #f0f0f0; padding: 5px;'>
                    This is not a proper update package!</p> Please download a valid package to continue. Valid \".zip\" files are available on <a href='http://ucmclientportal.com/'>UCMClientPortal.com</a> or on the Envato Market.<BR><BR>";
        }
    }

/* ====== Start Updater Script ====== */
if (isset($_POST['confirm_update'])) {
//echo "<script>window.location = 'index.php?page=admin&admin_tab=3&update_page=1'</script>";
echo "<center>
    <form method='post'>
    <input type='submit'  name='return_update_page' value='Finished' />
    </form>
    </center>";
echo "<BR>";
echo "<center><strong>" . $_POST['file_select'] . "</center></strong>";
echo "<HR><BR>";    

        ini_set('max_execution_time',60);
        $zipHandle = zip_open($_POST['file_select']);
            echo '<ul>';
            while (false !== ($aF = zip_read($zipHandle))) {
                $file_with_path = zip_entry_name($aF);
                $file_without_path = basename($file_with_path);
                if (substr(zip_entry_name($aF), 0, 9) !== '__MACOSX/') {
                if (substr($file_without_path, 0, 2) != '.D') {
                if (substr($file_without_path, 0, 2) != '._') {
                if (substr($file_without_path, 0, 7) != 'cgi-bin') {
                
                    $thisFileName = zip_entry_name($aF);
                    $thisFileDir = dirname($thisFileName);
                
            //Continue if its not a file
                    if ( substr($thisFileName,-1,1) == '/') continue;
                   
    
                    //Make the directory if we need to...
                    if ( !is_dir ( $thisFileDir ) )
                    {
                         mkdir ( $thisFileDir );
                         echo '<li>Created Directory '.$thisFileDir.'</li>';
                    }
                   
                    //Overwrite the file
                    if ( !is_dir($thisFileName) ) {
                        echo '<li>'.$thisFileName.'...........';
                        $contents = zip_entry_read($aF, zip_entry_filesize($aF));
                        $contents = str_replace("\\r\\n", "\\n", $contents);
                        $updateThis = '';
                       
                        //If we need to run commands, then do it.
                        if ( $thisFileName == 'upgrade.php' )
                        {
                            $upgradeExec = fopen ('upgrade.php','w');
                            fwrite($upgradeExec, $contents);
                            fclose($upgradeExec);
                            include ('upgrade.php');
                            unlink('upgrade.php');
                            echo' EXECUTED</li>';
                        }
                        else
                        {
                            $updateThis = fopen($thisFileName, 'w');
                            fwrite($updateThis, $contents);
                            fclose($updateThis);
                            unset($contents);
                            echo' <strong style="color: #00b600;">UPDATED</strong></li>';
                    }
                }
                    
                }
                }
                }
                }
            }
    if (file_exists('classes/class.phpmailer.php')) {
        unlink('classes/class.phpmailer.php');
    }
    if (file_exists('classes/class.smtp.php')) {
        unlink('classes/class.smtp.php');
    }
    if (file_exists('classes/PHPMailerAutoload.php')) {
        unlink('classes/PHPMailerAutoload.php');
    }
    if (file_exists('images/previews')) {
        unlink('images/previews');
    }

        echo "</ul>";
        echo "<BR><BR>";
    
/* ====== End Updater Script ====== */
        require_once('version.php');
        echo "<p style='text-align: center; color: #00b600; background: #f0f0f0; padding: 5px;'>
        Everything seems ok!</p>
        <p style='text-align: left;'>If you experience any issues with the update or if it wasn't applied correctly please report the problem on <a href='http://ucmclientportal.com/forums/forum/support/'>UCMClientPortal.com</a></p>
        <BR>
        <center>
    <form method='post'>
    <input type='submit'  name='return_update_page' value='Finished' />
    </form>
        </center>";
    } 
    
                                      
if (isset($_POST['return_update_page'])) {
    echo "<script>window.location = 'index.php?page=admin&admin_tab=3&update_page=1'</script>";
}
                                      
?>





        
<?php 
//$target_dir = "images/";
//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//$uploadOk = 1;
//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image


                                      
    ?>
    <?php
    if (isset($_POST['update_file_input'])) {
        
    if (!empty($_FILES["file"])) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Error: " . $_FILES["file"]["error"] . "<br>";
            $logo_img = constant('LOGO_IMG');
        } else {
            //echo "Stored file:".$_FILES["file"]["name"]."<br/>Size:".($_FILES["file"]["size"]/1024)." kB<br/>";
            move_uploaded_file($_FILES["file"]["tmp_name"],'views/admin/update/update-files/' . $_FILES["file"]["name"]);
            echo "<script>window.location = 'index.php?page=admin&admin_tab=3&update_page=1'</script>";
            //$logo_img = 'views/admin/update/update-files/' . $_FILES["file"]["name"];
           }
    } else {
        echo "There was an error uploading the file. Please try again.";
        $logo_img = constant('LOGO_IMG');
    }

    
    
    if (isset($_POST['demo'])) {
        $demo_mode = 'on';
    } else {
        $demo_mode = 'off';
    }

if (constant('DEMO_MODE') != 'on') {
       
}
        /*
        if (isset($_GET['section']) && $_GET['section'] < 2.5) {
            echo "<script>window.location = 'install.php?section=2.5'</script>";
        } elseif (!isset($_GET['section'])) {
            echo "<script>window.location = 'install.php?section=2.5'</script>";
        }*/
    }
    
//}
// --- End Section 2 ---

                                      
// --- Start Section 3 ---

?>
</div>
<?php
} else {
?>

<?php } ?>