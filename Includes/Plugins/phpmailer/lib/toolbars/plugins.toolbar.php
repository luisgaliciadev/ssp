<?php
/*
This script is written for use with PHPMailer-ML when
using the SPAW Editor v.2. It is designed to add a menu option for
variable substitution within an email message body. To use it
you will require the file "inc.campaigns.php" for PHPMailer-ML
version 1.8.1a.
Author: Andy Prevost
License: GPL (see docs/license.txt)
*/
$items = array (
  new SpawTbDropdown('varinsert', 'varinsert', 'isEnabled', 'statusCheck', 'change', '', SPAW_AGENT_ALL,false),
);
?>
