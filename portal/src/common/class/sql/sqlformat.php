<?php

class SQLFormat {
    public static final function string($string)
    {
        $string = trim($string, "\t\r\n\0\x0B");
        $string = preg_replace(
                array(
                    '/[^\w\^\[\]\.\$\{\*\(\+\)\|\?\<\>\}:@#!&%\-\'"\s\/]/',
                    '/\'/',
                    '/"/'
                    ),
                array(
                    '',
                    '\\\'',
                    '\\"'
                    ),
                $string);
	return $string;
    }

    public static final function alphanum($str)
    {
        $value = preg_replace('/\W/', '', $str);
	return $value;
    }

    public static final function num($value)
    {
        $value = preg_replace('/\D/', '', $value);
	return intval($value);
    }

    public static final function zerofill($value)
    {
        return sprintf('%06d', $value);
    }

    public static final function float($value)
    {
        $value = preg_replace('/[^\d\.-]/', '', $value);
	return floatval($value);
    }

    public static final function email($email)
    {
        $email = preg_replace('/[^\w@\.]/', '', $email);
        return $email;
    }

    public static final function hex($hex)
    {
        $hex = preg_replace('/[^\da-fA-F]/', '', $hex);
        return $hex;
    }

    public static final function datetime($bday)
    {
        $bday = trim($bday, "\t\r\n\0\x0B");
        $bday = preg_replace('/[^\d-:\s]/', '', $bday);
        return $bday;
    }
}
?>
