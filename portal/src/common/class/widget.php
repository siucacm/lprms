<?php

class Widget {

    public static final function socialnet()
    {
        ob_start();
	$str = '" width="32" height="32';
        echo '<div class="userwidget"><h3>Follow Us!</h3>';

	if (LPRMS::social('twitter') != '') echo '<a class="nolink" href="http://www.twitter.com/'.LPRMS::social('twitter').'">'.      Image::html(LPRMS::home().'/common/img/icons/socialnet/twitter.png'.$str, 'Follow us on Twitter').'</a>';
	if (LPRMS::social('facebook') != '') echo '<a class="nolink" href="http://www.facebook.com/'.LPRMS::social('facebook').'">'.   Image::html(LPRMS::home().'/common/img/icons/socialnet/facebook.png'.$str, 'Follow us on Facebook').'</a>';
	if (LPRMS::social('myspace') != '') echo '<a class="nolink" href="http://www.myspace.com/'.LPRMS::social('myspace').'">'.      Image::html(LPRMS::home().'/common/img/icons/socialnet/myspace.png'.$str, 'Follow us on MySpace').'</a>';
	if (LPRMS::social('xfire') != '') echo '<a class="nolink" href="http://www.xfire.com/communities/'.LPRMS::social('xfire').'">'.Image::html(LPRMS::home().'/common/img/icons/socialnet/xfire.png'.$str, 'Follow us on XFire').'</a>';
	if (LPRMS::social('steam') != '') echo '<a class="nolink" href="http://steamcommunity.com/groups/'.LPRMS::social('steam').'">'.Image::html(LPRMS::home().'/common/img/icons/socialnet/steam.png'.$str, 'Follow us on Steam').'</a>';

        echo '</div>';

        return ob_get_clean();
    }

    public static final function flash_slideshow()
    {
        ob_start();
        echo '<script type="text/javascript">
			var cacheBuster = "?t=" + Date.parse(new Date());
			var stageW = 600;//"100%";
			var stageH = 400;//"100%";
			var attributes = {};
			attributes.id = \'FlabellComponent\';
			attributes.name = attributes.id;
			var params = {};
			params.bgcolor = "#000000";
			params.menu = "false";
			params.scale = \'noScale\';
			params.wmode = "opaque";
			params.allowfullscreen = "true";
			params.allowScriptAccess = "always";
			var flashvars = {};
			flashvars.componentWidth = stageW;
			flashvars.componentHeight = stageH;
			flashvars.pathToFiles = "common/widgets/";
			flashvars.xmlPath = "xml/slideshow.xml.php";
			swfobject.embedSWF("common/widgets/flash/slideshow.swf"+cacheBuster, attributes.id, stageW, stageH, "9.0.124", "common/widgets/flash/expressInstall.swf", flashvars, params);
</script>';

        echo "\n\n";

        echo '<div id="FlabellComponent">';
	echo '<p>In order to view this object you need Flash Player 9+ support!</p>';
	echo '<a href="http://www.adobe.com/go/getflashplayer">';
	echo '<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player"/>';
	echo '</a></div>';
        return ob_get_clean();
    }

    public static final function ajax_slideshow()
    {
        
    }

    public static final function twitter()
    {
        
    }

    public static final function ticker()
    {
        
    }

    public static final function user_info()
    {
        ob_start();
	$str = ' width="32" height="32"';
        echo '<div class="userwidget"><h3>User Account</h3>';

	if (Session::active())
        {
            echo HTML::link_text(LPRMS::page('account/logout'),'LOGOUT').'<br /><br />';
            $user = Library::get_user(Session::uid());
            if ($user->is_init())
                    $user->load();
            if ($user->role == 1)
                echo HTML::link_text(LPRMS::page('admin'),'ADMINISTRATION').'<br /><br />';
            echo HTML::link_img(LPRMS::page('account'),$user->get_gravatar(80), 'Avatar').'<br />';
            echo $user->uid().'<br /><br />';

            $events = $user->events();
            $eventSeat = $user->eventSeat();
            $oldeventstr = '';
            $eventstr = '';

            echo '<h3>Registered Events</h3>';
            if (count($events) > 0)
            {
                echo '<ul>';
                foreach ($events as $key => $value)
                {
                    
                    $eventstr = '<li>'.HTML::link_text($value->link(),$value->name).'</a>';
                    if ($eventSeat[$key] != '')
                        $eventstr .= ' ('.$eventSeat[$key].')';
                    $eventstr .= '</li>'."\n";
                    if ($value->active())
                        echo $eventstr;
                    else
                        $oldeventstr .= $eventstr;
                }
                $oldeventstr = str_replace('<li>', '<li style="text-decoration: line-through;">', $oldeventstr);
                echo $oldeventstr;
                echo '</ul>';
            }
            else
            {
                echo 'No registered events; perhaps you should <br />'.HTML::link_text(LPRMS::page('event'),'JOIN AN EVENT?');
            }
        }
        else
        {
            echo '<form method="post" action="'.LPRMS::post().'">
                    <input type="hidden" name="form" value="acct_login" />
                    <table class="form" summary="acct_login Form">
                    <tr>
                        <th><label for="uw_username">Username: </label></th>
                        <td><input type="text" id="uw_username" name="username" value="" size="10" /></td>
                     </tr>
                     <tr>
                        <th><label for="uw_password">Password: </label></th>
                        <td><input type="password" id="uw_password" name="password" value="" size="10" /></td>
                     </tr>
                     </table>
                     <input class="login_submit" type="submit" name="Submit" value="Login &raquo;" />
                     </form>';
            echo '<br /><br />'.HTML::link_text(LPRMS::page('account/register'),'REGISTER!');
            echo '<br />'.HTML::link_text(LPRMS::page('account/forgot'),'Forgot your password?');
        }

        
        echo '</div>';

        return ob_get_clean();
    }
}
?>
