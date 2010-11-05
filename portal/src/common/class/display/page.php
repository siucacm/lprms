<?php

class Page
{
    public static final function parse_uri()
    {
        $root = LPRMS::page();
        $uri = $_SERVER['REQUEST_URI'];

        if (substr($uri, -1) == '/') $uri = substr($uri, 0, -1);
        if (substr($uri, 0, 1) == '/') $uri = substr($uri, 1);
        $uria = explode('/', $uri);
        
	$root = str_ireplace('http://', '', $root);
        $root = str_replace($_SERVER['SERVER_NAME'], '', $root);
        if (substr($root, 0, 1) == '/') $root = substr($root, 1);
        if (substr($root, -1) == '/') $root = substr($root, 0, -1);
        $roota = explode('/', $root);

        for ($i = 0; $i < count($uria); $i++)
        {
            if (!isset($roota[$i])) break;
            if ($uria[$i] != $roota[$i]) break;
        }
        $result = array();
        if (count($uria) == count($roota) && strlen($root) > 0 && $i >= count($uria)) $result['page'] = 'index';
        else
            $result['page'] = $uria[$i];

        for ($j = 0; $j+$i+1 < count($uria); $j++)
            $result[$j] = $uria[$j+$i+1];
        return $result;
    }

    public static final function render()
    {
        foreach (array('blobs', 'buttons', 'forms', 'tables', 'widgets') as $v1)
            foreach (scandir(LPRMS::path('common/class/display/components/'.$v1)) as $v2)
                if ($v2 != '.' && $v2 != '..' && $v2 != '.svn')
                    LPRMS::load_class('display/components/'.$v1.'/'.$v2);

        $pageinfo = self::parse_uri();

        switch ($pageinfo['page'])
        {
            case 'event':
                LPRMS::load_class('display/page/event.php');
                EventPage::render($pageinfo);
            case 'account':
                LPRMS::load_class('display/page/account.php');
                AccountPage::render($pageinfo);
            case 'common':
                if (isset($pageinfo[0]) && $pageinfo[0] == 'img' && isset($pageinfo[1]) && $pageinfo[1] == 'unknown.png')
                {
                    LPRMS::load_class('datastore/obj/image.php');
                    Image::renderUnknown();
                    exit;
                }
            case 'index':       self::render_index();
            case 'post':
                LPRMS::load_class('display/page/post.php');
                Post::render();
            default:
                LPRMS::load_class('display/page/default.php');
                DefaultPage::render();
        }
    }

    public static final function render_index()
    {
        Display::header();
        echo Datastore::getInstance();
        Display::footer();
        exit;
    }

}

?>
