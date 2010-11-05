<?php

class DefaultPage {
    public static function render() {

        Display::header();
        ?>
<h1>Not Found</h1>
The specified page at <pre><?php echo $_SERVER['REQUEST_URI']; ?></pre> was not found.
        <?php
        Display::footer();
        exit;
    }

}

?>