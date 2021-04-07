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
SpawConfig::setStaticConfigItem("dropdown_data_varinsert_varinsert",
  array(
    '{applicationname}' => 'Application Name',
    '{email}'           => 'Email Address',
    '{ip}'              => 'IP Address',
    '{firstname}'       => 'First Name',
    '{lastname}'        => 'Last Name',
    '{mailinglist}'     => 'Mailing List',
    '{msgid}'           => 'Message ID',
    '{onlineviewurl}'   => 'View Online Link',
    '{reg_date}'        => 'Registration Date',
    '{remote_host}'     => 'Remote Host',
    '{unsubscribe}'     => 'Unsubscribe Link'
  )
);
?>
