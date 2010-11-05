<?php

class Display {
    public static final function render($name)
    {
        require_once(LPRMS::root().'common/class/page/'.$name.'.php');
        Page::render();
    }

    public static final function top_link()
    {
        return '<a class="link" style="float: right;" href="#top"> &#94; top</a>';
    }

    public static final function menu()
    {
        echo '<div id="nav_menu">
				<ul>
					<li><a class="menu_item" href="'.LPRMS::home().'">Home</a></li>
					<li><a class="menu_item" href="'.LPRMS::home().'/profile/">People</a></li>
					<li><a class="menu_item" href="'.LPRMS::home().'/event/">Events</a></li>
					'.//<li><a class="menu_item" href="'.LPRMS::home().'/team/">Teams</a></li>
					//<li><a class="menu_item" href="'.LPRMS::home().'/tournament/">Tournaments</a></li>
					//<li><a class="menu_item" href="'.LPRMS::home().'/match/">Matches</a></li>
                                        '<li><a class="menu_item" href="'.LPRMS::home().'/tshirt/">T-shirts</a></li>
                                        <li><a class="menu_item" href="'.LPRMS::home().'/cable/">LAN Cables</a></li>
					<li><a class="menu_item" href="'.LPRMS::home().'/account/">Account</a></li>
				</ul>';
	echo '</div>';
    }

    public static final function sidebar()
    {
        echo Widget::socialnet();
        echo Widget::user_info();
    }

    public static final function header()
    {
        require_once(LPRMS::root().'content/themes/'.LPRMS::theme().'/header.php');
    }

    public static final function footer()
    {
        require_once(LPRMS::root().'content/themes/'.LPRMS::theme().'/footer.php');
        Error::clear_persistent_error();
        exit;
    }

    public static final function meta()
    {
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
    }

}
?>
