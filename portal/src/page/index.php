<?php

if (!isset($_GET['page'])) header('Location: ../');

define('LPRMS', TRUE);
require_once('../common/lprms.php');

Display::render($_GET['page']);

?>
