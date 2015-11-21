<?php
if (file_exists('custom/style-config.php')) {
    require('custom/style-config.php');
}
if (!file_exists('custom')) {
    mkdir('custom', 0777, true);
}


if(defined('WRAP_WIDTH') && constant('WRAP_WIDTH') == '100%') {
    $wrap_border_radius = '0';
    $wrap_border_width = '0';
} else {
    $wrap_border_radius = constant('GENERAL_BORDER_RADIUS');
    $wrap_border_width = constant('WRAP_BORDER_WIDTH');
}

if (defined('WRAP_WIDTH')){
    $wrap_width_type = trim(str_replace(range(0,9),'',constant('WRAP_WIDTH')));
    $wrap_margin_type = trim(str_replace(range(0,9),'',constant('WRAP_MARGINS')));
    if ($wrap_width_type != '%' && $wrap_margin_type != 'auto') {
        $str0 = constant('WRAP_WIDTH');
        $wrap_width_value = filter_var($str0, FILTER_SANITIZE_NUMBER_INT);
    //echo $wrap_width_value . '<br>';
        $str1 = constant('WRAP_MARGINS');
        $wrap_margins_value = filter_var($str1, FILTER_SANITIZE_NUMBER_INT);
    //echo $wrap_margins_value . '<br>';
        $wrap_margin_compensation = $wrap_width_value + ($wrap_margins_value * 2);
    //echo $wrap_margin_compensation . '<br>';
    } else {
        $wrap_margin_compensation = '980';
    }
} else {
    $wrap_margin_compensation = '980';
}
    


    
    
$write = file_put_contents('custom/custom.css', '

/* ------------- GENERAL ------------- */

body{
	color: #' . constant('PRIMARY_TEXT_COLOR') . ';
	background: #' . constant('BODY_BG') . ';
}
a { 
    color: #' . constant('GENERAL_LINK_COLOR') . '
}
a:hover { 
    color: #' . constant('GENERAL_LINK_COLOR_HOVER') . '
}
.welcome {
    color: #' . constant('PRIMARY_TEXT_COLOR') . ';
}
h1 {
    color: #' . constant('PRIMARY_TEXT_COLOR') . ';
}
h2 {
    color: #' . constant('PRIMARY_TEXT_COLOR') . ';
}
h3 {
    color: #' . constant('PRIMARY_TEXT_COLOR') . ';
}
h4{
    background: #' . constant('PRIMARY_COLOR') . ';
    color: #' . constant('BOX_TITLE_TEXT_COLOR') . ';
    border-top: 1px solid #' . constant('WRAP_BORDER_COLOR') . ';
    border-bottom: 1px solid #' . constant('WRAP_BORDER_COLOR') . ';
}

span {
    color: #' . constant('PRIMARY_TEXT_COLOR') . ';
}
/* ------------- HEADERS ------------- */
.header{
    background: ' . constant('HEADER_COLOR') . ';
    color: #' . constant('HEADER_TEXT') . '; 
}
.header-text {
    color: #' . constant('HEADER_TEXT') . ';
}
.header a {
    color: #' . constant('HEADER_A') . ';
}
.header a:hover {
    color: #' . constant('HEADER_A_HOVER') . ';
}

.header-avatar img{
	-webkit-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
	-moz-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
	border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
}

/* ------------- MAIN ------------- */
.wrap{
	max-width: ' . constant('WRAP_WIDTH') . ';
	background: #' . constant('WRAP_COLOR') . ';
    margin-left: auto;
    margin-right: auto;
    border: ' . $wrap_border_width . 'px ' . constant('WRAP_BORDER_TYPE') . ' #' . constant('WRAP_BORDER_COLOR') . ';
    color: ' . constant('WRAP_TEXT') . ';
    -webkit-border-radius: ' . $wrap_border_radius . 'px;
	-moz-border-radius: ' . $wrap_border_radius . 'px;
	border-radius: ' . $wrap_border_radius . 'px;
}
.wrap-header {
    background-color: #' . constant('PRIMARY_COLOR') . ';
    color: #' . constant('BOX_TITLE_TEXT_COLOR') . ';
}
.wrap-title {
    color: #' . constant('BOX_TITLE_TEXT_COLOR') . ';
}

@media (max-width: ' . $wrap_margin_compensation . 'px) {
    .wrap{
        margin-left: ' . constant('WRAP_MARGINS') . ';
        margin-right: ' . constant('WRAP_MARGINS') . ';
    }
}
@media (max-width: 520px) {
    .wrap{
        max-width: 100%;
        min-height: 80%;
        margin: 0 auto;
        margin-left: 0px;
        margin-right: 0px;
        margin-top: 20px;
        border: 0px solid;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
        overflow: hidden;
    }
}
/* ------------- LOGIN ------------- */
.login-box {
    -webkit-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
	-moz-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
	border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
    background: #' . constant('BODY_BG') . ';
    color: #' . constant('PRIMARY_TEXT_COLOR') . ';
}
.login {
    -webkit-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
	-moz-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
	border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
}


/* ------------- BOXES ------------- */

.left-box{
    border-right: ' . constant('LEFT_BOX_BORDER_WIDTH') . 'px ' . constant('LEFT_BOX_BORDER_TYPE') . ' #' . constant('LEFT_BOX_BORDER_COLOR') . ';
    background: #' . constant('LEFT_BOX_COLOR') . ';
    color: #' . constant('PRIMARY_TEXT_COLOR') . ';
}

.project-page-status-not-paid {
    background-color: #' . constant('STATUS_PENDING_BG') . ';
    color: #' . constant('STATUS_PENDING_TEXT') . ';
}
.project-page-status-paid {
    background-color: #' . constant('STATUS_PAID_BG') . ';
    color: #' . constant('STATUS_PAID_TEXT') . ';
}
.project-page-status-paid a{
    color: #' . constant('STATUS_PAID_TEXT') . ';
}
.project-page-status-not-paid a{
    color: #' . constant('STATUS_PAST_DUE_TEXT') . ';
}

.progress-bar-container {
    border: 1px solid #' . constant('STATUS_BORDER_COLOR') . ';
	border-radius: ' . (constant('GENERAL_BORDER_RADIUS') - 1). 'px;
    background: #' . constant('PAST_DUE_BG') . ';
	background-image:linear-gradient(left, #' . constant('STATUS_PAST_DUE_BG') . ' 0%, #' . constant('STATUS_PENDING_BG') . ' 100%);
	background-image:-moz-linear-gradient(left, #' . constant('STATUS_PAST_DUE_BG') . ' 0%, #' . constant('STATUS_PENDING_BG') . ' 100%);
	background-image:-webkit-linear-gradient(left, #' . constant('STATUS_PAST_DUE_BG') . ' 0%, #' . constant('STATUS_PENDING_BG') . ' 100%);
}
.progress-bar {
	border-radius: 0px ' . constant('GENERAL_BORDER_RADIUS') . 'px ' . constant('GENERAL_BORDER_RADIUS') . 'px 0px;
    background: #' . constant('STATUS_PAID_BG') . ';
    color: #' . constant('STATUS_PAID_TEXT') . ';
}

/* ------------- FORMS ------------- */
input[type="submit"] {
	background:#' . constant('BUTTON_COLOR_2') . ';
	background-image:linear-gradient(bottom, #' . constant('BUTTON_COLOR_1') . ' 0%, #' . constant('BUTTON_COLOR_2') . ' 52%);
	background-image:-moz-linear-gradient(bottom, #' . constant('BUTTON_COLOR_1') . ' 0%, #' . constant('BUTTON_COLOR_2') . ' 52%);
	background-image:-webkit-linear-gradient(bottom, #' . constant('BUTTON_COLOR_1') . ' 0%, #' . constant('BUTTON_COLOR_2') . ' 52%);
	color:#' . constant('BUTTON_TEXT_COLOR') . ';
    -webkit-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
	-moz-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
	border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
    border: 1px solid;
}
input[type="submit"]:hover {
	background-image:linear-gradient(bottom, #' . constant('BUTTON_COLOR_2') . ' 0%, #' . constant('BUTTON_COLOR_1') . ' 52%);
	background-image:-moz-linear-gradient(bottom, #' . constant('BUTTON_COLOR_2') . ' 0%, #' . constant('BUTTON_COLOR_1') . ' 52%);
	background-image:-webkit-linear-gradient(bottom, #' . constant('BUTTON_COLOR_2') . ' 0%, #' . constant('BUTTON_COLOR_1') . ' 52%);

}
textarea {
    background: #' . constant('TEXT_BOX_COLOR') . ';
    color: #' . constant('TEXT_BOX_TEXT_COLOR') . ';
}
form {
    color: #' . constant('PRIMARY_TEXT_COLOR') . ';
}


/* ------------- LISTS ------------- */
.tab-links a {
    border-top: 1px solid #' . constant('WRAP_BORDER_COLOR') . ';
    border-left: 1px solid #' . constant('WRAP_BORDER_COLOR') . ';
    border-right: 1px solid #' . constant('WRAP_BORDER_COLOR') . ';
    -webkit-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px ' . constant('GENERAL_BORDER_RADIUS') . 'px 0px 0px;
    -moz-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px ' . constant('GENERAL_BORDER_RADIUS') . 'px 0px 0px;
    border-radius:' . constant('GENERAL_BORDER_RADIUS') . 'px ' . constant('GENERAL_BORDER_RADIUS') . 'px 0px 0px;
    background:#' . constant('JOB_LIST_COLOR_2') . ';
    color:#' . constant('JOB_LIST_TEXT_COLOR') . ';
}
 
.tab-links a:hover {
    background:#' . constant('JOB_LIST_COLOR_3') . ';
}
 
li.active a, li.active a:hover {
    background:#' . constant('PRIMARY_COLOR') . ';
    color:#' . constant('BOX_TITLE_TEXT_COLOR') . ';
    border-top: 1px solid #' . constant('JOB_LIST_COLOR_4') . ';
    border-left: 1px solid #' . constant('JOB_LIST_COLOR_4') . ';
    border-right: 1px solid #' . constant('JOB_LIST_COLOR_4') . ';
}
.due-date {
    -webkit-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
	-moz-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
	border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
    border: 1px solid #' . constant('STATUS_BORDER_COLOR') . ';
}
#pastDue{
    background: #' . constant('STATUS_PAST_DUE_BG') . ';
    color: #' . constant('STATUS_PAST_DUE_TEXT') . ';
}
#pastDue h3{
    color: #' . constant('STATUS_PAST_DUE_TEXT') . ';
}
#paid{
    background: #' . constant('STATUS_PAID_BG') . ';
    color: #' . constant('STATUS_PAID_TEXT') . ';
}
#paid h3{
    color: #' . constant('STATUS_PAID_TEXT') . ';
}
#pending{
    background: #' . constant('STATUS_PENDING_BG') . ';
    color: #' . constant('STATUS_PENDING_TEXT') . ';
}
#pending h3{
    color: #' . constant('STATUS_PENDING_TEXT') . ';
}
#approved{
    background: #' . constant('STATUS_APPROVED_BG') . ';
    color: #' . constant('STATUS_APPROVED_TEXT') . ';
}
#approved h3{
    color: #' . constant('STATUS_APPROVED_TEXT') . ';
}
.job-list {
    border: 0px solid #e4e4e4;
    background: #' . constant('JOB_LIST_COLOR_2') . ';
	background-image:linear-gradient(bottom, #' . constant('JOB_LIST_COLOR_1') . ' 0%, #' . constant('JOB_LIST_COLOR_2') . ' 52%);
	background-image:-moz-linear-gradient(bottom, #' . constant('JOB_LIST_COLOR_1') . ' 0%, #' . constant('JOB_LIST_COLOR_2') . ' 52%);
	background-image:-webkit-linear-gradient(bottom, #' . constant('JOB_LIST_COLOR_1') . ' 0%, #' . constant('JOB_LIST_COLOR_2') . ' 52%);
}
.job-list td {
    color: #' . constant('JOB_LIST_TEXT_COLOR') . ';
}
.job-list:hover {
    border: 0px solid #d4d4d4;
    background: #' . constant('JOB_LIST_COLOR_1') . ';
	background-image:linear-gradient(bottom, #' . constant('JOB_LIST_COLOR_3') . ' 0%, #' . constant('JOB_LIST_COLOR_4') . ' 52%);
	background-image:-moz-linear-gradient(bottom, #' . constant('JOB_LIST_COLOR_3') . ' 0%, #' . constant('JOB_LIST_COLOR_4') . ' 52%);
	background-image:-webkit-linear-gradient(bottom, #' . constant('JOB_LIST_COLOR_3') . ' 0%, #' . constant('JOB_LIST_COLOR_4') . ' 52%);
}
.single-list-item {
    background: ' . constant('HEADER_COLOR') . ';
}
.single-list-item td {
    color: #' . constant('HEADER_TEXT') . ';
}

.list-header{
    background: #' . constant('PRIMARY_COLOR') . ';
    color: #' . constant('BOX_TITLE_TEXT_COLOR') . ';
}
.comment-block{
    background: #' . constant('LEFT_BOX_COLOR') . ';
    color: #' . constant('PRIMARY_TEXT_COLOR') . '
    -webkit-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
    -moz-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
    border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
}
.comment-item{
    background: #' . constant('TEXT_BOX_COLOR') . ';
	border: 1px solid #' . constant('WRAP_BORDER_COLOR') . ';
    color: #' . constant('PRIMARY_TEXT_COLOR') . '
    -webkit-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
    -moz-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
    border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
}
.comment-post {
    color: #' . constant('TEXT_BOX_TEXT_COLOR') . ';
}
.comment-avatar img{
    -webkit-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
    -moz-border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
    border-radius: ' . constant('GENERAL_BORDER_RADIUS') . 'px;
    border: 2px solid #' . constant('WRAP_BORDER_COLOR') . ';
}
.invoice-list-header {
    background: #' . constant('PRIMARY_COLOR') . ';\
}
.invoice-list-header th {
    color: #' . constant('BOX_TITLE_TEXT_COLOR') . ';
}
.invoice-list-light {
    background: #' . constant('JOB_LIST_COLOR_2') . ';
}
.invoice-list-dark {
    background: #' . constant('JOB_LIST_COLOR_1') . ';
}


/* ------------- MENU ------------- */

.panel {
    background: #' . constant('MENU_COLOR') . ';
}
.menu-item {
    color: #' . constant('MENU_TEXT') . ';
    background: #' . constant('MENU_ITEM_BG') . ';
    border-top: 1px solid #' . constant('MENU_ITEM_BORDER') . ';
    border-bottom: 1px solid #' . constant('MENU_ITEM_BORDER') . ';
    
}

.menu-item:hover {
    background: #' . constant('MENU_ITEM_BG_HOVER') . ';
}
.menu-item a {
    color: #' . constant('MENU_TEXT') . ';
}
.menu-item a:link {
    color: #' . constant('MENU_TEXT') . ';
}
');
    
    
    //echo "<script>window.location = 'index.php?page=admin'</script>";
//} else {
//    echo 'bla';
//}
if ($write) {
    echo "<script>window.location = 'index.php?page=admin'</script>";
} else {
    echo "Something went wrong... Please refresh the page and try again.";
}

?>
