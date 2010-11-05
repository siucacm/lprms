<?php
class Cacher {
    public final static function update_all()
    {
        self::update_users();
        self::update_events();
    }

    public final static function update_users()
    {
        echo '<pre>';
        $ulist = Library::list_user_ids();
        foreach ($ulist as $uid)
        {
            echo 'Deleting SQL entry'."\n";
            MySQL::login();
            MySQL::delete('cache_xml_steam', 'WHERE `id_user` = '.$uid);
            MySQL::delete('cache_xml_xfire', 'WHERE `id_user` = '.$uid);
            MySQL::logout();
            echo 'Deleting file entry'."\n";
            self::clean('user/'.$uid);
            echo 'Recaching user '.$uid."\n";
            self::update_user($uid);
        }
        echo '</pre>';
    }

    public final static function clean($folder)
    {
        $dir = LPRMS::root().'content/cache/'.$folder;
        $numspaces = count(explode('/', $dir));
        printf('%'.$numspaces.'s Entering folder: %s', '=', $dir);
        echo "\n";
        if (!file_exists($dir)) return;
        $list = scandir($dir);
        foreach ($list as $entry)
        {
            if ($entry == '.' || $entry == '..') continue;
            if (is_dir($dir.'/'.$entry))
            {
                self::clean($folder.'/'.$entry);
                rmdir($dir.'/'.$entry);
            }
            else
            {
                printf('%'.$numspaces.'s Deleting file: %s', ' ', $dir.'/'.$entry);
                echo "\n";
                unlink($dir.'/'.$entry);
            }
        }
    }

    public final static function gen_user_print_labels()
    {
        $print_folder = '../../content/cache/print/user';
        self::clean($print_folder);
        $ulist = Library::list_user_ids();
        $count = 0;
        $last_uid = 0;
        $latex_file = fopen($print_folder.'/users.tex', 'w');
        fwrite($latex_file, '\documentclass{report}
\usepackage[left=0.1525in,top=0.88in,right=0.1525in,bottom=0.88in,nohead,nofoot]{geometry}
\usepackage[pdftex]{graphicx}
\usepackage{multicol}
\newcommand{\gassign}[2]{{#1} \(\rightarrow\) {#2}}
\newcommand{\bkt}[1]{\(<\){#1}\(>\)}
\paperwidth = 8.5in
\paperheight = 11in
\setlength{\columnsep}{0.195in}
\thispagestyle{empty}
\pagestyle{empty}
\begin{document}
\begin{multicols}{2}
\noindent
');
        foreach ($ulist as $uid)
        {
            $user = Library::get_user(SQL::num($uid));
            echo 'Generating Print Label for '.$uid."\n";
            echo $print_folder.'/barcode_'.$uid.'_generic.png'."\n";
            fwrite($latex_file, '\includegraphics[width=4in]{'.$print_folder.'/barcode_'.$uid.'_generic.png}
');
            
            $img = new BarcodePrintIMG($uid, 0);
            $img->cache();
            $events = $user->events();
            foreach ($events as $eid => $value)
            {
                $img = new BarcodePrintIMG($uid, $eid);
                $img->cache();
            }
            
            $count++;
            if ($count % 14 == 0)
            {
                fwrite($latex_file, '\end{multicols}
\newpage
\begin{multicols}{2}
\noindent
');
            }
            $last_uid = $uid;
        }

        for ($i = $uid+1; $i < 300; $i++)
        {
            echo 'Generating Print Label for '.$i."\n";
            echo $print_folder.'/barcode_'.$i.'_generic.png'."\n";
            fwrite($latex_file, '\includegraphics[width=4in]{'.$print_folder.'/barcode_'.$i.'_generic.png}
');
            $img = new BarcodePrintIMG($i, 0);
            $img->cache();

            $count++;
            if ($count % 14 == 0)
            {
                fwrite($latex_file, '\end{multicols}
\newpage
\begin{multicols}{2}
\noindent
');
            }
        }
        fwrite($latex_file, '\end{multicols}
\end{document}
');
        fclose($latex_file);
        system('pdflatex "'.$print_folder.'/users.tex" --aux-directory="'.$print_folder.'" --output-directory="'.$print_folder.'"');
    }

    public final static function gen_item_print_labels()
    {
        $print_folder = '../../content/cache/print/item';
        self::clean($print_folder);
        $count = 0;
        $latex_file = fopen($print_folder.'/items.tex', 'w');
        fwrite($latex_file, '\documentclass{report}
\usepackage[left=0.297in,top=0.505in,right=0.297in,bottom=0.505in,nohead,nofoot]{geometry}
\usepackage[pdftex]{graphicx}
\usepackage{multicol}
\newcommand{\gassign}[2]{{#1} \(\rightarrow\) {#2}}
\newcommand{\bkt}[1]{\(<\){#1}\(>\)}
\paperwidth = 8.5in
\paperheight = 11in
\setlength{\columnsep}{0.302in}
\thispagestyle{empty}
\pagestyle{empty}
\begin{document}
\begin{multicols}{4}
\noindent
');

        for ($i = 1; $i < 1000; $i++)
        {
            echo 'Generating Item Print Label for '.$i."\n";
            echo $print_folder.'/barcode_item_'.$i.'.png'."\n";
            fwrite($latex_file, '\includegraphics[width=1.75in]{'.$print_folder.'/barcode_item_'.$i.'.png}
');
            $img = new BarcodeItemPrintIMG($i, 0);
            $img->cache();

            $count++;
            if ($count % 60 == 0)
            {
                fwrite($latex_file, '\end{multicols}
\newpage
\begin{multicols}{4}
\noindent
');
            }
        }
        fwrite($latex_file, '\end{multicols}
\end{document}
');
        fclose($latex_file);
        system('pdflatex "'.$print_folder.'/items.tex" --aux-directory="'.$print_folder.'" --output-directory="'.$print_folder.'"');
    }

    public final static function update_user($uid)
    {
        $user = Library::get_user(SQL::num($uid));
        
        $steam = $user->steam();
        $steam->load_remote();
        $steam->commit();

        $xfire = $user->xfire();
        $xfire->load_remote();
        $xfire->commit();

        $img = new AvatarIMG($uid);
        $img->cache(256);
        $img->cache(80);
        $img->cache(64);
        $img->cache(32);

        $img = new GravatarIMG($uid);
        $img->cache(256);
        $img->cache(80);
        $img->cache(64);
        $img->cache(32);

        $img = new SteamIMG($uid);
        $img->cache(256);
        $img->cache(80);
        $img->cache(64);
        $img->cache(32);

        $img = new XFireIMG($uid);
        $img->cache(256);
        $img->cache(80);
        $img->cache(64);
        $img->cache(32);

        $img = new BarcodeIMG($uid, 0);
        $img->cache();
        $events = $user->events();
        foreach ($events as $eid => $value)
        {
            $img = new BarcodeIMG($uid, $eid);
            $img->cache();
        }
    }
}
?>
