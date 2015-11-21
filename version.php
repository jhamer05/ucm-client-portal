<?php
define("SYSTEM_VERSION", "0.6.5");
/*
==============================
UCM Client Portal
v0.6.5 - Nov2015
© 2015 JCH Design, LLC
==============================

==============
v0.6.5
==============
This release is probably the final release from me. I may come back to the project in the future but for now I don't have the time. Information about the project can be found on ucmcp.jchdesign.com and the whole project is available for free on GitHub.


NOTE: 0.6.3 & 0.6.4 were never released. The list below includes changes since 0.6.2

Additions
-Proper thumbnails. Images are coppied and resized into thumbnails. This should help save some bandwidth. (It works on my system but may have issues with older versions of PHP)


Bug Fixes
-Not that kind of update but I caught a few... :-P
-Fixed customer information on quotes
-Fixed a bug with invoice numbers and their link asocciations
-Fixes for default themes (issues from 6.2)
-Fixed Due Date on invoice pages
-Fixed a few spelling mistakes (Thanks Savio)

Changes
-Disabled update and version code. Was linked to ucmclientportal.com
-Added Progress Bars!
-Got rid of the stupid looking seperator lines on the project page title bar.
-Changed the project page thumbnails a bit. Now they are all the same size.
-Any custom status types in UCM will show up as yellow on the project pages.
-Updated the staff tools project list with the same changes as v0.6.1
-Changed the way quotes are read from the DB (again...). Some things were still not working right. Specifically quantities and default task type changes.
-Some of the changes to quotes are also implemented in invoices
-Added project description to quote pages
-Moved the payment button down on invoice pages
-Removed payment and print buttons from printed invoices
-Added link to custom.css in printed invoices (doesn't fully work but things fit better)
-Tweaked project and invoice lists - due dates, etc.
-Various tweaks to project pages such as section titles like "Comments".

Reported Bugs
-Possible error with currency types not being read - can't reproduce error

::: TO DO :::
rearange project pages
more files page
client uploads
zip file support
pdf file support
project files download section
    zip of all files
    individual files (non-image)
    final version (acessible after payment)
? -Integrate project comments with emails (ticket system)
Ticket System Integration
Rework the whole staff tools section
Make settings prettier


==============
v0.6.2
==============
Additions
-Support for other currency types. Values are pulled from UCM - Thanks to "Dan" for the suggestion.
-New "Full Width" theme options. 

Bug Fixes
-Quote prices were not displayed on small screens
-Invoice pages may not have been showing the correct customer info

Changes
-Currency values are rounded to a decimal set in UCM
-Currency seperators (decimals and commas) are not set in UCM
-Currency symbols are now pulled from UCM
-Project description text is now aligned to the left. - Thanks to "msmart" for the suggestion.
-On small screens pages are now full width.
-The "Colors" tab in the admin menu has been renamed to "Themes".
-Minor tweaks to the login page
-Minor tweak to the way the "account status" notification is displayed
-Moved the main wrap to the top for full width layouts
-Thumbnails are now a tad smaller and have a drop shaddow on hover instead of "growing" slightly.
*/
?>