<?php

class HTML {
    public static final function link_text($url, $text, $style = 'link')
    {
        return '<a class="'.$style.'" href="'.$url.'">'.$text.'</a>';
    }

    public static final function link_img($url, $img, $text)
    {
        return '<a class="nolink" href="'.$url.'"><img src="'.$img.'" alt="'.$text.'" /></a>';
    }
}
?>
