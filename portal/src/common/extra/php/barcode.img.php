<?php

define('LPRMS', TRUE);
require_once('../../lprms.php');

if (isset($_GET['username']) && $_GET['username'] != '')
{
    if (isset($_GET['event']) && $_GET['event'] != '')
        Image::generate_barcode($_GET['username'],$_GET['event']);
    else
        Image::generate_barcode($_GET['username']);
}
else
    echo 'Invalid image';

?>
