<?php

define('LPRMS', TRUE);
require_once('../../lprms.php');

if (!isset($_GET['tid'])) die();

Image::render_tournament_tree($_GET['tid']);

?>
