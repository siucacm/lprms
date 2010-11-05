<?php

class Widget_SocialNet {

    public static function render()
    {
        ?>
	<div class="widget">
            <h3>Follow Us!</h3>
            <?php
                echo Twitter::getInstance()->icon();
                echo Facebook::getInstance()->icon();
                echo MySpace::getInstance()->icon();
                echo Steam::getInstance()->icon();
                echo XFire::getInstance()->icon();
            ?>
        </div>


        <?php
    }
}
?>
