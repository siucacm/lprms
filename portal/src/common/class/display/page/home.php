<?php

class Page {
    public static final function render()
    {
        Display::header();

        echo '<h1 class="title">Home</h1>';
        echo HTML::link_img(LPRMS::page('account/register'),
                LPRMS::page('common/img/registernow.png'),
                'Register Now!');
        Display::footer();
    }
    
}

?>
