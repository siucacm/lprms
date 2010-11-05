<?php

define('LPRMS', TRUE);
require_once('../common/lprms.php');

if (!isset($_GET['size']) || isset($_GET['uid'])) die();

$size = SQL::num($_GET['size']);


?>
