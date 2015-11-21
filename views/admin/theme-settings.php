<?php 
if ($_SESSION['user_id'] == 1) { ?>
<script type="text/javascript" src="js/jscolor/jscolor.js"></script>
<div class="inner">
<?php
if (file_exists('custom/style-config.php')) {
    require_once('custom/style-config.php');
} else {
    echo '  <center><span>There is no settings file! Please press the button below to create one.</span><BR>
            <strong>NOTE:</strong> This will overwrite existing files if there are any.
            <BR><BR>';
    echo '<form method="post"><input type="submit" name="default_style" value="Continue"></form></center>';
}
?>
<script>
$(document).ready(function () {
     $('#customCheckbox').click(function () {
         var $this = $(this);
         if ($this.is(':checked')) {
             $('#customColors').fadeIn();
             $('#colorPresets').hide();
             $('#customColors').show();
         } else {
             $('#colorPresets').fadeIn();
             $('#customColors').hide();
             $('#colorPresets').show();
         }
     });
 });    
</script>
<?php if (file_exists('custom/style-config.php')) { ?>
<form method="post">
    <input type="checkbox" id="customCheckbox" > Use custom settings?
</form>
    <BR>
<form method="post" id="colorPresets">
<table style="width: 100%; border: 1px solid;">
    <tr class="wrap-header"><td style="padding: 2px;">
<h2 class="wrap-title" style="font-size: 18px; text-align: left;">PRESETS:</h2>
    </td></tr>
    <tr>
        <td style="padding-top: 10px; text-align: center;">
            
            
    <table style="width: 100%; margin: 0 auto;">
        <tr>
            <td style="width: 50%; text-align: center;">
<a href="views/admin/themes/previews/full-width.jpg" data-featherlight='image'>
<img src="views/admin/themes/previews/thumbnails/full-width.jpg" style="border: 2px solid; max-width: 100px;"></a><BR>Full Width Pages<BR>
<input type="radio" name="FULL_WIDTH_PRESET" value="true" style="margin-bottom: 8px;">
            </td>
            <td style="width: 50%; text-align: center;">
<a href="views/admin/themes/previews/constrained.jpg" data-featherlight='image'>
<img src="views/admin/themes/previews/thumbnails/constrained.jpg" style="border: 2px solid; max-width: 100px;"></a><BR>Constrained Pages<BR>
<input type="radio" name="FULL_WIDTH_PRESET" value="false" style="margin-bottom: 8px;">
            </td>
        </tr>
    </table>
            
            
            
            <!--
            <input type="checkbox" name="FULL_WIDTH_PRESET" value="true" 
                   <?php /*
                       if ((defined('WRAP_WIDTH') && constant('WRAP_WIDTH') == '100%') && (defined('WRAP_MARGINS') && constant('WRAP_MARGINS') == 'auto')) {
                            echo 'checked';
                        }*/
                   ?>>
            Full Width Pages&nbsp;
        
            <form method="post" id="FULL_WIDTH_PRESET_FORM_1">
                <input type="hidden" name="FULL_WIDTH_PRESET" value="true">
            <input type="submit" name="FULL_WIDTH_PRESET_SUBMIT" value="Full Width Pages">
            </form>
            <form method="post" id="FULL_WIDTH_PRESET_FORM_2">
                <input type="hidden" name="CONSTRAINED_PAGES" value="true">
            <input type="submit" name="CONSTRAINED_PAGES_SUBMIT" value="Constrained Pages">
            </form>
<HR style="margin-top: 8px;"> -->
        </td>
    </tr>
    <tr><td style="padding: 2px;"><BR>
    <table style="width: 100%; margin: 0 auto;">
        <tr>
            <td style="width: 33%; text-align: center;">
<a href="views/admin/themes/previews/dark.jpg" data-featherlight='image'>
<img src="views/admin/themes/previews/thumbnails/dark.jpg" style="border: 2px solid; max-width: 100px;"></a><BR>Dark Theme<BR>
<input type="radio" name="color_preset" value="theme_dark.php" style="margin-bottom: 8px;">
            </td>
            <td style="width: 33%; text-align: center;">
<a href="views/admin/themes/previews/light.jpg" data-featherlight='image'>
<img src="views/admin/themes/previews/thumbnails/light.jpg" style="border: 2px solid; max-width: 100px;"></a><BR>Light Theme<BR>
<input type="radio" name="color_preset" value="theme_light.php" style="margin-bottom: 8px;">
            </td>
            <td style="width: 33%; text-align: center;">
<a href="views/admin/themes/previews/red.jpg" data-featherlight='image'>
<img src="views/admin/themes/previews/thumbnails/red.jpg" style="border: 2px solid; max-width: 100px;"></a><BR>Red Theme<BR>
<input type="radio" name="color_preset" value="theme_red.php" style="margin-bottom: 8px;">
            </td>
        </tr>
    </table>
<HR style="margin-bottom: 8px;">
    <table style="width: 100%; margin: 0 auto;">
        <tr>
            <td style="width: 50%; text-align: center;">
<a href="views/admin/themes/previews/light_icons.jpg" data-featherlight='image'>
<img src="views/admin/themes/previews/light_icons.jpg" style="border: 2px solid; max-width: 150px;"></a><BR>Light Icon Set<BR>
<input type="radio" name="icon_set" value="images/icons_light" style="margin-bottom: 8px;"><BR>
            </td>
            <td style="width: 50%; text-align: center;">
<a href="views/admin/themes/previews/dark_icons.jpg" data-featherlight='image'>
<img src="views/admin/themes/previews/dark_icons.jpg" style="border: 2px solid; max-width: 150px;"></a><BR>Dark Icon Set<BR>
<input type="radio" name="icon_set" value="images/icons_dark" style="margin-bottom: 8px;"><BR>
            </td>
        </tr>
    </table>
        
        
</td></tr></table>
<BR>
<center>
<input type="checkbox" name="reset_defaults" value="images/icons_default" > Reset Defaults?<BR><BR>
<input type="submit" name="preset_submit" value="Submit">
</center>
</form>
    
<?php
    /*
if (isset($_POST['preset_submit'])) {
    
    if (isset($_POST['color_preset']) || isset($_POST['icon_set']) || isset($_POST['reset_defaults'])) {
        $run_presets = 'true';
    }
    
    if (isset($_POST['FULL_WIDTH_PRESET']) && $run_presets != 'true') {
        $style_submit = 'true';
    }
}
*/ 
    ?>
<?php
    /*
if (isset($_POST['FULL_WIDTH_PRESET_SUBMIT'])){
    $style_submit = 'true';
}
if (isset($_POST['CONSTRAINED_PAGES'])){
    $style_submit = 'true';
} 
   */ 
?>
    
<?php
if (isset($_POST['preset_submit'])) {
    if (isset($_POST['FULL_WIDTH_PRESET'])){
        if ($_POST['FULL_WIDTH_PRESET'] == 'true') {
            $full_width = 'true';
        } elseif ($_POST['FULL_WIDTH_PRESET'] == 'false') {
            $full_width = 'false';
        }
    }
    
    if (isset($_POST['color_preset']) && !isset($_POST['icon_set'])) {
        if($_POST['color_preset'] == "theme_dark.php") {
            $icon_set = "images/icons_light";
        }
        if($_POST['color_preset'] == "theme_red.php") {
            $icon_set = "images/icons_light";
        }
        if($_POST['color_preset'] == "theme_light.php") {
            $icon_set = "images/icons_dark";
        }
    }
    
    
    
    if (isset($_POST['reset_defaults'])) {
        $color_preset = 'theme_default.php';
    }
    if (isset($_POST['color_preset'])) {
        $color_preset = $_POST['color_preset'];
    }
    
    
    if (isset($full_width) && !isset($color_preset)) {
        $style_submit = 'true';
        $global_preset = 'true';
    } 
    
    if (isset($color_preset)) {
        if (isset($full_width) && $full_width == 'true') {
            copy ('views/admin/themes/wide/' . $color_preset, 'custom/style-config.php');
        } else {
            copy ('views/admin/themes/' . $color_preset, 'custom/style-config.php');
        }
    }
        /*if (isset($_POST['FULL_WIDTH_PRESET']) && $_POST['FULL_WIDTH_PRESET'] == 'true') {
            $data = '          
            // Page Width Options
            define("WRAP_WIDTH", "100%");
            define("WRAP_MARGINS", "auto");

            ';
            file_put_contents('custom/style-config.php', $data, FILE_APPEND);
        }
    }*/
    if (isset($_POST['reset_defaults'])) {
        $icon_set = $_POST['reset_defaults'];
    }
    if (isset($_POST['icon_set'])) {
        $icon_set = $_POST['icon_set'];
    }
    if (isset($icon_set)) {
            copy ($icon_set . '/arrow_right.png', 'images/icons/arrow_right.png');
            copy ($icon_set . '/email_icon.png', 'images/icons/email_icon.png');
            copy ($icon_set . '/home_icon.png', 'images/icons/home_icon.png');
            copy ($icon_set . '/invoice_icon.png', 'images/icons/invoice_icon.png');
            copy ($icon_set . '/leave_icon.png', 'images/icons/leave_icon.png');
            copy ($icon_set . '/logout_icon.png', 'images/icons/logout_icon.png');
            copy ($icon_set . '/menu_icon_x.png', 'images/icons/menu_icon_x.png');
            copy ($icon_set . '/menu_icon.png', 'images/icons/menu_icon.png');
            copy ($icon_set . '/project_icon.png', 'images/icons/project_icon.png');
            copy ($icon_set . '/quote_icon.png', 'images/icons/quote_icon.png');
            copy ($icon_set . '/settings_icon.png', 'images/icons/settings_icon.png');
            copy ($icon_set . '/tools_icon.png', 'images/icons/tools_icon.png');
    }
    
    echo "<script>window.location = 'index.php?page=css-write'</script>";
    
}
?>
    
<form method="post" id="customColors" style="display: none;">
<table style="width: 100%; border: 1px solid;">
    <tr class="wrap-header"><td style="padding: 2px;">
<h2 class="wrap-title" style="font-size: 18px; text-align: left;">GENERAL:</h2>
    </td></tr>
    <tr><td style="padding: 2px;">
    <table style="width: 100%; margin: auto;">
        <tr>
            <td style="width: 35%; text-align: center;">
Background Color<BR>
<input class="color" name="body_bg" style="margin: 2px auto;"
       value="<?php echo constant('BODY_BG'); ?>">
            </td>
            <td style="width: 28%; text-align: center;">
Border Radius<BR>
<input type="number" style="width: 70px;" name="general_border_radius" 
       value="<?php echo constant('GENERAL_BORDER_RADIUS'); ?>"> px
            </td>
            <td style="width: 35%; text-align: center;">
Button Gradient Colors<BR>
<input class="color" style="width: 70px; padding-left: 2px; padding-right: 2px; margin: 1px auto;" name="button_color_2" 
       value="<?php echo constant('BUTTON_COLOR_2'); ?>">
<input class="color" style="width: 70px; padding-left: 2px; padding-right: 2px; margin: 1px auto;;" name="button_color_1" 
       value="<?php echo constant('BUTTON_COLOR_1'); ?>">
            </td>
        </tr>
    </table>
<HR style="margin-bottom: 8px;">
    <table style="width: 100%; margin: 0 auto;">
        <tr>
            <td style="width: 33%; text-align: center;">
Link Color<BR>
<input class="color" name="general_link_color" 
       value="<?php echo constant('GENERAL_LINK_COLOR'); ?>"> 
            </td>
            <td style="width: 33%; text-align: center;">
Link Hover<BR>
<input class="color" name="general_link_color_hover" 
       value="<?php echo constant('GENERAL_LINK_COLOR_HOVER'); ?>"> 
            </td>
            <td style="width: 33%; text-align: center;">
Button Text<BR>
<input class="color" name="button_text_color" 
       value="<?php echo constant('BUTTON_TEXT_COLOR'); ?>"> 
            </td>
        </tr>
    </table>
<HR style="margin-bottom: 8px;">
    <table style="width: 100%; margin: auto;">
        <tr>
            <td style="width: 33%; text-align: center;">
Main Text Color<BR>
<input class="color" name="primary_text_color" 
       value="<?php echo constant('PRIMARY_TEXT_COLOR'); ?>">
            </td>
            <td style="width: 33%; text-align: center;">
Page Title Color<BR>
<input class="color" name="primary_color" 
       value="<?php echo constant('PRIMARY_COLOR'); ?>">
            </td>
            <td style="width: 33%; text-align: center;">            
Text Inside Titles<BR>
<input class="color" name="box_title_text_color" 
       value="<?php echo constant('BOX_TITLE_TEXT_COLOR'); ?>"> 
            </td>
        </tr>
    </table>
</td></tr></table>

<BR>

<table style="width: 100%; border: 1px solid;">
    <tr class="wrap-header"><td style="padding: 2px;">
<h2 class="wrap-title" style="font-size: 18px; text-align: left;">Header &amp; Menu:</h2>
    </td></tr>
    <tr><td style="padding: 2px;">

    <table style="width: 100%; margin: auto;">
        <tr>
            <td style="width: 50%; text-align: center;">
Header Color<BR>
<input class="color" name="header_color" 
       value="<?php echo constant('HEADER_COLOR'); ?>"> 
            </td>
            <td style="width: 50%; text-align: center;">            
Header Text Color<BR>
<input class="color" name="header_text" 
       value="<?php echo constant('HEADER_TEXT'); ?>"> 
            </td>
        </tr>
    </table>
<HR style="margin-bottom: 8px;">
    <table style="width: 100%; margin: auto;">
        <tr>
            <td style="width: 50%; text-align: center;">
Menu Color<BR>
<input class="color" name="menu_color" 
       value="<?php echo constant('MENU_COLOR'); ?>">
            </td>
            <td style="width: 50%; text-align: center;">            
Menu Text Color<BR>
<input class="color" name="menu_text" 
       value="<?php echo constant('MENU_TEXT'); ?>">  
            </td>
        </tr>
    </table>
<HR style="margin-bottom: 8px;"> 
    <table style="width: 100%; margin: auto;">
        <tr>
            <td style="width: 33%; text-align: center;">
Menu Item BG<BR>
<input class="color" name="menu_item_bg" 
       value="<?php echo constant('MENU_ITEM_BG'); ?>"> 
            </td>
            <td style="width: 33%; text-align: center;">            
Hover Color<BR>
<input class="color" name="menu_item_bg_hover" 
       value="<?php echo constant('MENU_ITEM_BG_HOVER'); ?>"> 
            </td>
            <td style="width: 33%; text-align: center;">            
Border Color<BR>
<input class="color" name="menu_item_border" 
       value="<?php echo constant('MENU_ITEM_BORDER'); ?>"> 
            </td>
        </tr>
    </table>
</td></tr></table>

<BR>

<table style="width: 100%; border: 1px solid;">
    <tr class="wrap-header"><td style="padding: 2px;">
<h2 class="wrap-title" style="font-size: 18px; text-align: left;">Wrap &amp; Project Pages:</h2>
    </td></tr>
    <tr><td style="padding: 2px;">
    
<table style="width: 100%; margin: auto;">
        <tr>
            <td style="width: 30%; text-align: right;">            
Page Width &nbsp;
            </td>
            <td>
<input type="number" style="width: 100px;" name="wrap_width" 
       value="<?php 
        if (defined('WRAP_WIDTH')) { 
            $str = constant('WRAP_WIDTH');
            $int = filter_var($str, FILTER_SANITIZE_NUMBER_INT);

            echo $int;
        } else {
            echo '960';
        }?>"> 
<select type="dropdown" name="wrap_width_type">
<?php if (defined('WRAP_WIDTH')){ 
    $wrap_width_type = trim(str_replace(range(0,9),'',constant('WRAP_WIDTH')));
} else {
    $wrap_width_type = 'px';
} ?>
<option value="<?php echo $wrap_width_type; ?>"><?php echo $wrap_width_type; ?>(Current)</option>
<option value="px">Pixels</option>
<option value="%">Percent</option>
</select>  
            </td>
        </tr>
    </table>
<HR style="margin-bottom: 8px; margin-top: 8px;">
    
    
<table style="width: 100%; margin: auto;">
        <tr>
            <td style="width: 30%; text-align: right;">            
Wrap Margins &nbsp;
            </td>
            <td>
                
<script>
$(document).ready(function () {
     $('#autoMarginsCheckbox').click(function () {
         var $this = $(this);
         if ($this.is(':checked')) {
             $('#wrapMarginsInput').fadeIn();
             $('#wrapMarginsInput').hide();
         } else {
             $('#wrapMarginsInput').fadeIn();
             $('#wrapMarginsInput').show();
         }
     });
 });    
</script>          

<div id="wrapMarginsInput" style="display: inline;">
<input type="number" style="width: 70px;" name="wrap_margins" 
       value="<?php if (defined('WRAP_MARGINS')){ 
                        $str1 = constant('WRAP_MARGINS');
                        $int1 = filter_var($str1, FILTER_SANITIZE_NUMBER_INT);

                        echo $int1;
                    } else {
                        echo '10';
                    }?>">px
</div>
                
<input id="autoMarginsCheckbox" type="checkbox" name="auto_margins" value="true" <?php 
       if (defined('WRAP_MARGINS') && constant('WRAP_MARGINS') == 'auto') {
                            echo 'checked';
                        }
       ?>> Auto Margins

            </td>
        </tr>
    </table>
<HR style="margin-bottom: 8px; margin-top: 8px;">
    
    
    
<table style="width: 100%; margin: auto;">
        <tr>
            <td style="width: 50%; text-align: center;">
Wrap Color<BR>
<input class="color" name="wrap_color" 
       value="<?php echo constant('WRAP_COLOR'); ?>">
            </td>
            <td style="width: 50%; text-align: center;">            
Wrap Border<BR>
<input type="number" style="width: 70px;" name="wrap_border_width" 
       value="<?php echo constant('WRAP_BORDER_WIDTH'); ?>">px  
<select type="dropdown" name="wrap_border_type">
<option value="<?php echo constant('WRAP_BORDER_TYPE'); ?>">Current</option>
<option value="solid">Solid</option>
<option value="dotted">Dotted</option>
<option value="double">Double</option>
<option value="dashed">Dashed</option>
</select>   
<input class="color" name="wrap_border_color" 
       value="<?php echo constant('WRAP_BORDER_COLOR'); ?>">
            </td>
        </tr>
    </table>
<HR style="margin-bottom: 8px;">
    

    <table style="width: 100%; margin: auto;">
        <tr>
            <td style="width: 50%; text-align: center;">
Left Box Color<BR>
<input class="color" name="left_box_color" 
       value="<?php echo constant('LEFT_BOX_COLOR'); ?>">
            </td>
            <td style="width: 50%; text-align: center;">            
Left Box Border<BR>
<input type="number" style="width: 70px;" name="left_box_border_width" 
       value="<?php echo constant('LEFT_BOX_BORDER_WIDTH'); ?>">px  
<select type="dropdown" name="left_box_border_type">
<option value="<?php echo constant('LEFT_BOX_BORDER_TYPE'); ?>">Current</option>
<option value="solid">Solid</option>
<option value="dotted">Dotted</option>
<option value="double">Double</option>
<option value="dashed">Dashed</option>
</select>   
<input class="color" name="left_box_border_color" 
       value="<?php echo constant('LEFT_BOX_BORDER_COLOR'); ?>">
            </td>
        </tr>
    </table>

    
<HR style="margin-bottom: 8px;">
    
    
<div style="margin: 0 auto; text-align: right; width: 99%;">
    Text Box Background <input class="color" name="text_box_color" 
       value="<?php echo constant('TEXT_BOX_COLOR'); ?>"><BR>
    Text Box Text Color <input class="color" name="text_box_text_color" 
       value="<?php echo constant('TEXT_BOX_TEXT_COLOR'); ?>">
</div>

        
</td></tr></table>

<BR>

<table style="width: 100%; border: 1px solid;">
    <tr class="wrap-header"><td style="padding: 2px;">
<h2 class="wrap-title" style="font-size: 18px; text-align: left;">Dashboard Lists:</h2>
    </td></tr>
    <tr><td style="padding: 2px;">
    
<table style="width: 100%; margin: auto;">
        <tr>
            <td style="width: 33%; text-align: center;">
List Gradient Colors<BR>
<input class="color" style="width: 70px; padding-left: 2px; padding-right: 2px; margin: 1px auto;" name="job_list_color_2" 
       value="<?php echo constant('JOB_LIST_COLOR_2'); ?>">
<input class="color" style="width: 70px; padding-left: 2px; padding-right: 2px; margin: 1px auto;;" name="job_list_color_1" 
       value="<?php echo constant('JOB_LIST_COLOR_1'); ?>">
            </td>
            <td style="width: 33%; text-align: center;">            
Hover Gradient Colors<BR>
<input class="color" style="width: 70px; padding-left: 2px; padding-right: 2px; margin: 1px auto;" name="job_list_color_4" 
       value="<?php echo constant('JOB_LIST_COLOR_4'); ?>">
<input class="color" style="width: 70px; padding-left: 2px; padding-right: 2px; margin: 1px auto;;" name="job_list_color_3" 
       value="<?php echo constant('JOB_LIST_COLOR_3'); ?>">
            </td>
            <td style="width: 33%; text-align: center;">            
Text Color<BR>
<input class="color" style="padding-left: 2px; padding-right: 2px; margin: 1px auto;" name="job_list_text_color" 
       value="<?php echo constant('JOB_LIST_TEXT_COLOR'); ?>">
            </td>
        </tr>
    </table>
        <BR>
        
<div style="margin: 0 auto; text-align: right; width: 100%;">
    Notification Border Color <input class="color" name="status_border_color" 
       value="<?php echo constant('STATUS_BORDER_COLOR'); ?>">
    <BR>
    Past Due Box Color <input class="color" name="status_past_due_bg" 
       value="<?php echo constant('STATUS_PAST_DUE_BG'); ?>">&nbsp;
    Text <input class="color" name="status_past_due_text" 
       value="<?php echo constant('STATUS_PAST_DUE_TEXT'); ?>">&nbsp;
    <BR>
    Paid Box Color <input class="color" name="status_paid_bg" 
       value="<?php echo constant('STATUS_PAID_BG'); ?>">&nbsp;
    Text <input class="color" name="status_paid_text" 
       value="<?php echo constant('STATUS_PAID_TEXT'); ?>">&nbsp;
    <BR>
    Pending Box Color <input class="color" name="status_pending_bg" 
       value="<?php echo constant('STATUS_PENDING_BG'); ?>">&nbsp;
    Text <input class="color" name="status_pending_text" 
       value="<?php echo constant('STATUS_PENDING_TEXT'); ?>">&nbsp;
    <BR>
    Approved Box Color <input class="color" name="status_approved_bg" 
       value="<?php echo constant('STATUS_APPROVED_BG'); ?>">&nbsp;
    Text <input class="color" name="status_approved_text" 
       value="<?php echo constant('STATUS_APPROVED_TEXT'); ?>">&nbsp;
    <BR>
</div>

</td></tr></table>

<BR>
<center>
<input type="submit" name="style_submit" value="Submit">
</center>
</form>
    
<?php  
}  
    
    
if (isset($_POST['default_style'])) {
    if (!file_exists('custom')) {
        mkdir('custom', 0777, true);
    }
    copy("views/admin/custom_default/style-config.php","custom/style-config.php");
    copy("views/admin/custom_default/custom.css","custom/custom.css");
    
    echo "<script>window.location = 'index.php?page=admin&admin_tab=1'</script>";
}
        
    
if (isset($_POST['style_submit']) || isset($style_submit)) {

// General Styling
if($_POST['body_bg'] == '' && $global_preset != 'true') {
    $body_bg = 'e7edee';
} elseif ($_POST['body_bg'] != '') {
    $body_bg = $_POST['body_bg'];
} elseif(defined('BODY_BG')) {
    $body_bg = constant('BODY_BG');
} else {
    $body_bg = 'e7edee';
}  
    
if($_POST['primary_text_color'] == '' && $global_preset != 'true') {
    $primary_text_color = '303030';
} elseif ($_POST['primary_text_color'] != '') {
    $primary_text_color = $_POST['primary_text_color'];
} elseif(defined('PRIMARY_TEXT_COLOR')) {
    $primary_text_color = constant('PRIMARY_TEXT_COLOR');
} else {
    $primary_text_color = '303030';
}  
    
if($_POST['general_link_color'] == '' && $global_preset != 'true') {
    $general_link_color = '303030';
} elseif ($_POST['general_link_color'] != '') {
    $general_link_color = $_POST['general_link_color'];
} elseif(defined('GENERAL_LINK_COLOR')) {
    $general_link_color = constant('GENERAL_LINK_COLOR');
} else {
    $general_link_color = '303030';
}  
    
if($_POST['general_link_color_hover'] == '' && $global_preset != 'true') {
    $general_link_color_hover = '63b2de';
} elseif ($_POST['general_link_color_hover'] != '') {
    $general_link_color_hover = $_POST['general_link_color_hover'];
} elseif(defined('GENERAL_LINK_COLOR_HOVER')) {
    $general_link_color_hover = constant('GENERAL_LINK_COLOR_HOVER');
} else {
    $general_link_color_hover = '63b2de';
}  
    
if($_POST['general_border_radius'] == '' && $global_preset != 'true') {
    $general_border_radius = '5';
} elseif ($_POST['general_border_radius'] != '') {
    $general_border_radius = $_POST['general_border_radius'];
} elseif(defined('GENERAL_BORDER_RADIUS')) {
    $general_border_radius = constant('GENERAL_BORDER_RADIUS');
} else {
    $general_border_radius = '5';
}  
    
if($_POST['primary_color'] == '' && $global_preset != 'true') {
    $primary_color = '63b2de';
} elseif ($_POST['primary_color'] != '') {
    $primary_color = $_POST['primary_color'];
} elseif(defined('PRIMARY_COLOR')) {
    $primary_color = constant('PRIMARY_COLOR');
} else {
    $primary_color = '63b2de';
}  
    
if($_POST['box_title_text_color'] == '' && $global_preset != 'true') {
    $box_title_text_color = 'f5f5f5';
} elseif ($_POST['box_title_text_color'] != '') {
    $box_title_text_color = $_POST['box_title_text_color'];
} elseif(defined('BOX_TITLE_TEXT_COLOR')) {
    $box_title_text_color = constant('BOX_TITLE_TEXT_COLOR');
} else {
    $box_title_text_color = 'f5f5f5';
}   

    
    
// Page Width Options 

if ($_POST['wrap_width_type'] != '' && $global_preset != 'true') {
    $wrap_width_type = $_POST['wrap_width_type'];
} else {
    $wrap_width_type = 'px';
} 

if (isset($full_width) && $full_width == 'true') {
    $wrap_width = '100%';
        $error1 = 'set true';
} elseif (isset($full_width) && $full_width == 'false') {
    $wrap_width = '960px';
    $error1 = 'set false';
} else {
    if($_POST['wrap_width'] == '' && $global_preset != 'true') {
        $wrap_width = '960px';
    } elseif ($_POST['wrap_width'] != '') {
        $wrap_width = $_POST['wrap_width'] . $wrap_width_type;
    } elseif(defined('WRAP_WIDTH')) {
        $wrap_width = constant('WRAP_WIDTH');
    } else {
        $wrap_width = '960px';
    }  
}
    
if (isset($_POST['FULL_WIDTH_PRESET']) && $_POST['FULL_WIDTH_PRESET'] == 'true') {
    $wrap_margins = 'auto';
} elseif (isset($_POST['FULL_WIDTH_PRESET']) && $_POST['FULL_WIDTH_PRESET'] == 'flase') {
    $wrap_margins = '10px';
} else {
    if (isset($_POST['auto_margins'])) {
        $wrap_margins = 'auto';
    } elseif ($_POST['wrap_margins'] != '') {
        $wrap_margins = $_POST['wrap_margins'] . 'px';
    } else {
        $wrap_margins = '10px';
    }  
}
echo $wrap_margins . '<BR>';
    
    
    
// Header
if($_POST['header_color'] == '' && $global_preset != 'true') {
    $header_color = '#404040';
} elseif ($_POST['header_color'] != '') {
    $header_color = '#' . $_POST['header_color'];
} elseif(defined('HEADER_COLOR')) {
    $header_color = constant('HEADER_COLOR');
} else {
    $header_color = '#404040';
} 
    
if($_POST['header_text'] == '' && $global_preset != 'true') {
    $header_text = 'f5f5f5';
} elseif ($_POST['header_text'] != '') {
    $header_text = $_POST['header_text'];
} elseif(defined('HEADER_TEXT')) {
    $header_text = constant('HEADER_TEXT');
} else {
    $header_text = 'f5f5f5';
}  
    
/*if ($_POST['header_a'] != '') {
    $header_a = $_POST['header_a'];
} else {
    $header_a = 'f5f5f5';
}  
if ($_POST['header_a_hover'] != '') {
    $header_a_hover = $_POST['header_a_hover'];
} else {
    $header_a_hover = '63b2de';
}  */

// Page Colors
if($_POST['wrap_color'] == '' && $global_preset != 'true') {
    $wrap_color = 'ffffff';
} elseif ($_POST['wrap_color'] != '') {
    $wrap_color = $_POST['wrap_color'];
} elseif(defined('WRAP_COLOR')) {
    $wrap_color = constant('WRAP_COLOR');
} else {
    $wrap_color = 'ffffff';
}  
    
if($_POST['wrap_border_width'] == '' && $global_preset != 'true') {
    $wrap_border_width = '2';
} elseif ($_POST['wrap_border_width'] != '') {
    $wrap_border_width = $_POST['wrap_border_width'];
} elseif(defined('WRAP_BORDER_WIDTH')) {
    $wrap_border_width = constant('WRAP_BORDER_WIDTH');
} else {
    $wrap_border_width = '2';
}  
    
if($_POST['wrap_border_type'] == '' && $global_preset != 'true') {
    $wrap_border_type = 'solid';
} elseif ($_POST['wrap_border_type'] != '') {
    $wrap_border_type = $_POST['wrap_border_type'];
} elseif(defined('WRAP_BORDER_TYPE')) {
    $wrap_border_type = constant('WRAP_BORDER_TYPE');
} else {
    $wrap_border_type = 'solid';
}  
    
if($_POST['wrap_border_color'] == '' && $global_preset != 'true') {
    $wrap_border_color = 'DBDBDB';
} elseif ($_POST['wrap_border_color'] != '') {
    $wrap_border_color = $_POST['wrap_border_color'];
} elseif(defined('WRAP_BORDER_COLOR')) {
    $wrap_border_color = constant('WRAP_BORDER_COLOR');
} else {
    $wrap_border_color = 'DBDBDB';
}  
    
/*if ($_POST['wrap_text'] != '') {
    $wrap_text = $_POST['wrap_text'];
} else {
    $wrap_text = '303030';
}  */  
    
if($_POST['left_box_border_width'] == '' && $global_preset != 'true') {
    $left_box_border_width = '2';
} elseif ($_POST['left_box_border_width'] != '') {
    $left_box_border_width = $_POST['left_box_border_width'];
} elseif(defined('LEFT_BOX_BORDER_WIDTH')) {
    $left_box_border_width = constant('LEFT_BOX_BORDER_WIDTH');
} else {
    $left_box_border_width = '2';
}    
    
if($_POST['left_box_border_type'] == '' && $global_preset != 'true') {
    $left_box_border_type = 'solid';
} elseif ($_POST['left_box_border_type'] != '') {
    $left_box_border_type = $_POST['left_box_border_type'];
} elseif(defined('LEFT_BOX_BORDER_TYPE')) {
    $left_box_border_type = constant('LEFT_BOX_BORDER_TYPE');
} else {
    $left_box_border_type = 'solid';
}  
    
if($_POST['left_box_border_color'] == '' && $global_preset != 'true') {
    $left_box_border_color = 'f0f0f0';
} elseif ($_POST['left_box_border_color'] != '') {
    $left_box_border_color = $_POST['left_box_border_color'];
} elseif(defined('LEFT_BOX_BORDER_COLOR')) {
    $left_box_border_color = constant('LEFT_BOX_BORDER_COLOR');
} else {
    $left_box_border_color = 'f0f0f0';
}  
    
if($_POST['left_box_color'] == '' && $global_preset != 'true') {
    $left_box_color = 'f8f8f8';
} elseif ($_POST['left_box_color'] != '') {
    $left_box_color = $_POST['left_box_color'];
} elseif(defined('LEFT_BOX_COLOR')) {
    $left_box_color = constant('LEFT_BOX_COLOR');
} else {
    $left_box_color = 'f8f8f8';
}  
    
/*if ($_POST['left_box_text'] != '') {
    $left_box_text = $_POST['left_box_text'];
} else {
    $left_box_text = '303030';
}  */   

if($_POST['text_box_color'] == '' && $global_preset != 'true') {
    $text_box_color = 'f5f5f5';
} elseif ($_POST['text_box_color'] != '') {
    $text_box_color = $_POST['text_box_color'];
} elseif(defined('TEXT_BOX_COLOR')) {
    $text_box_color = constant('TEXT_BOX_COLOR');
} else {
    $text_box_color = 'f5f5f5';
}  
    
if($_POST['text_box_text_color'] == '' && $global_preset != 'true') {
    $text_box_text_color = '303030';
} elseif ($_POST['text_box_text_color'] != '') {
    $text_box_text_color = $_POST['text_box_text_color'];
} elseif(defined('TEXT_BOX_TEXT_COLOR')) {
    $text_box_text_color = constant('TEXT_BOX_TEXT_COLOR');
} else {
    $text_box_text_color = '303030';
}   
    
    
// Dashboard Lists  
if($_POST['job_list_color_1'] == '' && $global_preset != 'true') {
    $job_list_color_1 = 'f4f4f4';
} elseif ($_POST['job_list_color_1'] != '') {
    $job_list_color_1 = $_POST['job_list_color_1'];
} elseif(defined('JOB_LIST_COLOR_1')) {
    $job_list_color_1 = constant('JOB_LIST_COLOR_1');
} else {
    $job_list_color_1 = 'f4f4f4';
} 
    
if($_POST['job_list_color_2'] == '' && $global_preset != 'true') {
    $job_list_color_2 = 'ffffff';
} elseif ($_POST['job_list_color_2'] != '') {
    $job_list_color_2 = $_POST['job_list_color_2'];
} elseif(defined('JOB_LIST_COLOR_2')) {
    $job_list_color_2 = constant('JOB_LIST_COLOR_2');
} else {
    $job_list_color_2 = 'ffffff';
}  
    
if($_POST['job_list_color_3'] == '' && $global_preset != 'true') {
    $job_list_color_3 = 'e0e0e0';
} elseif ($_POST['job_list_color_3'] != '') {
    $job_list_color_3 = $_POST['job_list_color_3'];
} elseif(defined('JOB_LIST_COLOR_3')) {
    $job_list_color_3 = constant('JOB_LIST_COLOR_3');
} else {
    $job_list_color_3 = 'e0e0e0';
}  
    
if($_POST['job_list_color_4'] == '' && $global_preset != 'true') {
    $job_list_color_4 = 'ffffff';
} elseif ($_POST['job_list_color_4'] != '') {
    $job_list_color_4 = $_POST['job_list_color_4'];
} elseif(defined('JOB_LIST_COLOR_4')) {
    $job_list_color_4 = constant('JOB_LIST_COLOR_4');
} else {
    $job_list_color_4 = 'ffffff';
}  
    
if($_POST['job_list_text_color'] == '' && $global_preset != 'true') {
    $job_list_text_color = '303030';
} elseif ($_POST['job_list_text_color'] != '') {
    $job_list_text_color = $_POST['job_list_text_color'];
} elseif(defined('JOB_LIST_TEXT_COLOR')) {
    $job_list_text_color = constant('JOB_LIST_TEXT_COLOR');
} else {
    $job_list_text_color = '303030';
} 


    
    
if($_POST['status_border_color'] == '' && $global_preset != 'true') {
    $status_border_color = 'd4d4d4';
} elseif ($_POST['status_border_color'] != '') {
    $status_border_color = $_POST['status_border_color'];
} elseif(defined('STATUS_BORDER_COLOR')) {
    $status_border_color = constant('STATUS_BORDER_COLOR');
} else {
    $status_border_color = 'd4d4d4';
}    
    
if($_POST['status_past_due_bg'] == '' && $global_preset != 'true') {
    $status_past_due_bg = 'b60000';
} elseif ($_POST['status_past_due_bg'] != '') {
    $status_past_due_bg = $_POST['status_past_due_bg'];
} elseif(defined('STATUS_PAST_DUE_BG')) {
    $status_past_due_bg = constant('STATUS_PAST_DUE_BG');
} else {
    $status_past_due_bg = 'b60000';
}  
    
if($_POST['status_past_due_text'] == '' && $global_preset != 'true') {
    $status_past_due_text = 'ffffff';
} elseif ($_POST['status_past_due_text'] != '') {
    $status_past_due_text = $_POST['status_past_due_text'];
} elseif(defined('STATUS_PAST_DUE_TEXT')) {
    $status_past_due_text = constant('STATUS_PAST_DUE_TEXT');
} else {
    $status_past_due_text = 'ffffff';
}   
    
if($_POST['status_paid_bg'] == '' && $global_preset != 'true') {
    $status_paid_bg = '63b2de';
} elseif ($_POST['status_paid_bg'] != '') {
    $status_paid_bg = $_POST['status_paid_bg'];
} elseif(defined('STATUS_PAID_BG')) {
    $status_paid_bg = constant('STATUS_PAID_BG');
} else {
    $status_paid_bg = '63b2de';
}   
    
if($_POST['status_paid_text'] == '' && $global_preset != 'true') {
    $status_paid_text = 'ffffff';
} elseif ($_POST['status_paid_text'] != '') {
    $status_paid_text = $_POST['status_paid_text'];
} elseif(defined('STATUS_PAID_TEXT')) {
    $status_paid_text = constant('STATUS_PAID_TEXT');
} else {
    $status_paid_text = 'ffffff';
}   
    
if($_POST['status_pending_bg'] == '' && $global_preset != 'true') {
    $status_pending_bg = 'f0b600';
} elseif ($_POST['status_pending_bg'] != '') {
    $status_pending_bg = $_POST['status_pending_bg'];
} elseif(defined('STATUS_PENDING_BG')) {
    $status_pending_bg = constant('STATUS_PENDING_BG');
} else {
    $status_pending_bg = 'f0b600';
}    
    
if($_POST['status_pending_text'] == '' && $global_preset != 'true') {
    $status_pending_text = 'e7edee';
} elseif ($_POST['status_pending_text'] != '') {
    $status_pending_text = $_POST['status_pending_text'];
} elseif(defined('STATUS_PENDING_TEXT')) {
    $status_pending_text = constant('STATUS_PENDING_TEXT');
} else {
    $status_pending_text = '000000';
}   
    
if($_POST['status_approved_bg'] == '' && $global_preset != 'true') {
    $status_approved_bg = '00b600';
} elseif ($_POST['status_approved_bg'] != '') {
    $status_approved_bg = $_POST['status_approved_bg'];
} elseif(defined('STATUS_APPROVED_BG')) {
    $status_approved_bg = constant('STATUS_APPROVED_BG');
} else {
    $status_approved_bg = '00b600';
}   
    
if($_POST['status_approved_text'] == '' && $global_preset != 'true') {
    $status_approved_text = 'ffffff';
} elseif ($_POST['status_approved_text'] != '' && $global_preset != 'true') {
    $status_approved_text = $_POST['status_approved_text'];
} elseif(defined('STATUS_APPROVED_TEXT')) {
    $status_approved_text = constant('STATUS_APPROVED_TEXT');
} else {
    $status_approved_text = 'ffffff';
}    

    
    
    
    
// Menu & Buttons
if($_POST['menu_text'] == '' && $global_preset != 'true') {
    $menu_text = 'f5f5f5';
} elseif ($_POST['menu_text'] != '') {
    $menu_text = $_POST['menu_text'];
} elseif(defined('MENU_TEXT')) {
    $menu_text = constant('MENU_TEXT');
} else {
    $menu_text = 'f5f5f5';
}   
    
if($_POST['menu_color'] == '' && $global_preset != 'true') {
    $menu_color = '404040';
} elseif ($_POST['menu_color'] != '') {
    $menu_color = $_POST['menu_color'];
} elseif(defined('MENU_COLOR')) {
    $menu_color = constant('MENU_COLOR');
} else {
    $menu_color = '404040';
}   
    
if($_POST['menu_item_bg'] == '' && $global_preset != 'true') {
    $menu_item_bg = '202020';
} elseif ($_POST['menu_item_bg'] != '') {
    $menu_item_bg = $_POST['menu_item_bg'];
} elseif(defined('MENU_ITEM_BG')) {
    $menu_item_bg = constant('MENU_ITEM_BG');
} else {
    $menu_item_bg = '202020';
}    
    
if($_POST['menu_item_border'] == '' && $global_preset != 'true') {
    $menu_item_border = '303030';
} elseif ($_POST['menu_item_border'] != '') {
    $menu_item_border = $_POST['menu_item_border'];
} elseif(defined('MENU_ITEM_BORDER')) {
    $menu_item_border = constant('MENU_ITEM_BORDER');
} else {
    $menu_item_border = '303030';
}   
    
if($_POST['menu_item_bg_hover'] == '' && $global_preset != 'true') {
    $menu_item_bg_hover = '606060';
} elseif ($_POST['menu_item_bg_hover'] != '') {
    $menu_item_bg_hover = $_POST['menu_item_bg_hover'];
} elseif(defined('MENU_ITEM_BG_HOVER')) {
    $menu_item_bg_hover = constant('MENU_ITEM_BG_HOVER');
} else {
    $menu_item_bg_hover = '606060';
}   
    
/*if ($_POST['menu_item_link_color'] != '') {
    $menu_item_link_color = $_POST['menu_item_link_color'];
} else {
    $menu_item_link_color = 'f5f5f5';
}*/
    
if($_POST['button_color_1'] == '' && $global_preset != 'true') {
    $button_color_1 = '4895c0';
} elseif ($_POST['button_color_1'] != '') {
    $button_color_1 = $_POST['button_color_1'];
} elseif(defined('BUTTON_COLOR_1')) {
    $button_color_1 = constant('BUTTON_COLOR_1');
} else {
    $button_color_1 = '4895c0';
}
    
if($_POST['button_color_2'] == '' && $global_preset != 'true') {
    $button_color_2 = '63b2de';
} elseif ($_POST['button_color_2'] != '') {
    $button_color_2 = $_POST['button_color_2'];
} elseif(defined('BUTTON_COLOR_2')) {
    $button_color_2 = constant('BUTTON_COLOR_2');
} else {
    $button_color_2 = '63b2de';
}
    
if($_POST['button_text_color'] == '' && $global_preset != 'true') {
    $button_text_color = 'f5f5f5';
} elseif ($_POST['button_text_color'] != '') {
    $button_text_color = $_POST['button_text_color'];
} elseif(defined('BUTTON_TEXT_COLOR')) {
    $button_text_color = constant('BUTTON_TEXT_COLOR');
} else {
    $button_text_color = 'f5f5f5';
}

 
$write = file_put_contents('custom/style-config.php', '<?php

// General Styling
define("BODY_BG", "' . $body_bg . '");
define("PRIMARY_TEXT_COLOR", "' . $primary_text_color . '");
define("GENERAL_LINK_COLOR", "' . $general_link_color . '");
define("GENERAL_LINK_COLOR_HOVER", "' . $general_link_color_hover . '");
define("GENERAL_BORDER_RADIUS", "' . $general_border_radius . '");
define("PRIMARY_COLOR", "' . $primary_color . '");
define("BOX_TITLE_TEXT_COLOR", "' . $box_title_text_color . '");

// Page Width Options
define("WRAP_WIDTH", "' . $wrap_width . '");
define("WRAP_MARGINS", "' . $wrap_margins . '");

// Header
define("HEADER_COLOR", "' . $header_color . '");
define("HEADER_TEXT", "' . $header_text . '");
define("HEADER_A", "");
define("HEADER_A_HOVER", "");

// Page Colors
define("WRAP_COLOR", "' . $wrap_color . '");
define("WRAP_BORDER_WIDTH", "' . $wrap_border_width . '");
define("WRAP_BORDER_TYPE", "' . $wrap_border_type . '");
define("WRAP_BORDER_COLOR", "' . $wrap_border_color . '");
define("WRAP_TEXT", "");
define("LEFT_BOX_BORDER_WIDTH", "' . $left_box_border_width . '");
define("LEFT_BOX_BORDER_TYPE", "' . $left_box_border_type . '");
define("LEFT_BOX_BORDER_COLOR", "' . $left_box_border_color . '");
define("LEFT_BOX_COLOR", "' . $left_box_color . '");
define("TEXT_BOX_TEXT_COLOR", "' . $text_box_text_color . '");
define("TEXT_BOX_COLOR", "' . $text_box_color . '");

define("LEFT_BOX_TEXT", "");

// Dashboard Lists
define("JOB_LIST_COLOR_1", "' . $job_list_color_1 . '");
define("JOB_LIST_COLOR_2", "' . $job_list_color_2 . '");
define("JOB_LIST_COLOR_3", "' . $job_list_color_3 . '");
define("JOB_LIST_COLOR_4", "' . $job_list_color_4 . '");
define("JOB_LIST_TEXT_COLOR", "' . $job_list_text_color . '");
define("STATUS_BORDER_COLOR", "' . $status_border_color . '");
define("STATUS_PAST_DUE_BG", "' . $status_past_due_bg . '");
define("STATUS_PAST_DUE_TEXT", "' . $status_past_due_text . '");
define("STATUS_PAID_BG", "' . $status_paid_bg . '");
define("STATUS_PAID_TEXT", "' . $status_paid_text . '");
define("STATUS_PENDING_BG", "' . $status_pending_bg . '");
define("STATUS_PENDING_TEXT", "' . $status_pending_text . '");
define("STATUS_APPROVED_BG", "' . $status_approved_bg . '");
define("STATUS_APPROVED_TEXT", "' . $status_approved_text . '");


// Menu & Buttons
define("MENU_TEXT", "' . $menu_text . '");
define("MENU_COLOR", "' . $menu_color . '");
define("MENU_ITEM_BG", "' . $menu_item_bg . '");
define("MENU_ITEM_BORDER", "' . $menu_item_border . '");
define("MENU_ITEM_BG_HOVER", "' . $menu_item_bg_hover . '");
define("MENU_ITEM_LINK_COLOR", "");
define("BUTTON_COLOR_1", "' . $button_color_1 . '");
define("BUTTON_COLOR_2", "' . $button_color_2 . '");
define("BUTTON_TEXT_COLOR", "' . $button_text_color . '");

');
    
   
if ($write) {
    echo "<script>window.location = 'index.php?page=css-write'</script>";
} else {
    echo 'There was an error writing the config file.';
}
   
}
    

?>

</div>

<?php 
} else {
?>
<div class="wrap-header">
    <h2 class="wrap-title">Admin</h2>
</div>
<div class="welcome">
    <h2 style="text-align: center;">Please log in as the administrator</h2>
    This page controls various system settings. It is only usable by the system administrator. Please log in as the admin to continue.
    
</div>



<?php } ?>