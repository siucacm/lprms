<?php

define('LPRMS', TRUE);
require_once('../../lprms.php');

if (!isset($_GET['event'])) die();

Image::location_img($_GET['event']);

?>
