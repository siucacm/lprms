<?php

class Post
{
    public static function render()
    {
        $form = $_POST['form'];
        $action = $_POST['action'];
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';

        exit;
    }
}

?>
