<?php

define('LPRMS', TRUE);
require_once('../../lprms.php');

if (isset($_GET['thumbnail']) && $_GET['thumbnail'] == 1)
    Map::gen_map_img(TRUE);
else
    Map::gen_map_img(FALSE);

?>
