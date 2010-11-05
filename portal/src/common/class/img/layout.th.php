<?php

if (!isset($_GET['event']) || $_GET['event'] == '') exit;

define('LPRMS', TRUE);
define('EXT', TRUE);
require_once('../../core.php');

//echo get_root_dir().$_GET['xml'];
gen_map_img($_GET['event'], TRUE);

?>