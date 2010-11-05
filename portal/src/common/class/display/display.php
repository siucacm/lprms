<?php

class Display {

    public static function disclaimer()
    {
        $str  = '<i>'.SQL::getInstance()->queries().' queries executed in '.SQL::getInstance()->time().' seconds</i> | Powered by <a href="http://lprms.sourceforge.net">LPRMS @ SourceForge.NET</a>';
	$str .= '<br /><br />';
	//$str .= '<script type="text/javascript" src="http://www.ohloh.net/p/467142/widgets/project_thin_badge.js"></script>';
        echo $str;
    }

    public static function menu()
    {
        echo '<ul class="nav">
                    <li><a href="'.LPRMS::page().'">Home</a></li>
                    <li><a href="'.LPRMS::page('event').'">Events</a></li>
                    <li><a href="'.LPRMS::page('tournament').'">Tournaments</a></li>
                    <li><a href="'.LPRMS::page('people').'">People</a></li>
                    <li><a href="'.LPRMS::page('purchase').'">Buy Stuff!</a></li>
                    <li><a href="'.LPRMS::page('status').'">Status</a></li>
                    <li><a href="'.LPRMS::page('account').'">Account</a></li>
                </ul>';
    }

    public static function sidebar()
    {
        Widget_SocialNet::render();
    }

    public static function meta()
    {
        $pageinfo = Page::parse_uri();
        switch ($pageinfo['page'])
        {
            case 'event':
                ?>
                <script type="text/javascript" src="<?php echo LPRMS::page('common/extra/js/tabber-min.js'); ?>"></script>
                <style type="text/css">
                    @import url(<?php echo LPRMS::page('common/extra/css/tabber.css'); ?>);
                </style>
                <?php
        }
    }

    public static function header()
    {
        require_once(LPRMS::path('content/themes/'.LPRMS::theme().'/header.php'));
    }

    public static function footer()
    {
        require_once(LPRMS::path('content/themes/'.LPRMS::theme().'/footer.php'));
    }
}
?>
