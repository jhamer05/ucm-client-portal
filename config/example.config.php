<?php

//UCM Database Settings
//Make sure these match your UCM installation!
define('DB_NAME', 'UCM_DB');
define('DB_USER', 'Username');
define('DB_PASSWORD', 'pass');
define('DB_HOST', '127.0.0.1');
define('_DB_PREFIX', 'ucm_');

//UCM Settings
//!IMPORTANT! - This is the decryption key for the file links to UCM.
//Change this to match your UCM installation
define('_UCM_SECRET','h7297ea2b61277fb48f1dcah80dcb403'); 

//URL settings
//URL of your UCM installation's top folder
$_GET['ucm_url'] = 'http://www.example.com/UCM/';
//URL for this system's top folder
$_GET['base_url'] = 'http://www.example.com/SCP/';

//Client Portal Settings
//There may be issues with the dashboard lists if no timezone is set.
define("TIME_ZONE", "America/Denver");
//This is used for the page titles and a few other things here and there.
define('SITE_TITLE', 'Simple Client Portal');
//There is a link in the main menu to go to this address
define('MAIN_SITE', 'http://jchdesign.com/simple-client-portal/');
//Email address where all comment notifications will be sent
//This will change later and addresses will be pulled for staff members asigned to a project
define('SYSTEM_EMAIL', 'info@example.com');
//This is just used on quotes and invoices
define('PHONE_NUMBER', '(555) 555-5555');
//Name of your company - Used for sending emails
define('COMPANY_NAME', 'Sample Company, INC');
//Logo Image - Used for Quotes & Invoices
define("LOGO_IMG", "images/sample-logo.png");

// Demo mode
define('DEMO_MODE', 'off');

?>