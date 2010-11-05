<?php

define('LPRMS', TRUE);
require_once('../../lprms.php');

if (!isset($_GET['size']) || !isset($_GET['username'])) die();

$size = SQL::num($_GET['size']);

Image::xfire_img($_GET['username'], $size);

?>
