<?php

class XXML {
    public static final function parse($url)
    {
        self::$xmlrsrc = new XMLReader();
        self::$xmlrsrc->open($url);
        $array = self::xparse();
        self::$xmlrsrc->close();
        return $array;
    }
    
    private static final function xparse()
    {
        $xml = self::$xmlrsrc;
        $res = array();
        $res['text'] = '';
        while (@$xml->read())
        {
            if ($xml->nodeType == XMLReader::END_ELEMENT)
                    break;
            else if ($xml->nodeType == XMLReader::ELEMENT)
            {
                $tmp = array('name' => $xml->name);
                $tmp['value'] = self::xparse($xml);
                $res[] = $tmp;
            }
            else if ($xml->nodeType != XMLReader::SIGNIFICANT_WHITESPACE && $xml->nodeType != XMLReader::WHITESPACE)
                $res['text'] .= $xml->value;
        }
        return $res;
    }

    private static $xmlrsrc;
}
?>
