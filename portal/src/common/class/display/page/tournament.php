<?php

class Page {
    public static final function render()
    {
        Display::header();
        echo '<h1 class="title">Tournaments</h1>';
        echo 'Coming soon';
        Display::footer();
    }
}
?>
