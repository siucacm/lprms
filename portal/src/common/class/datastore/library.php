<?php
class Library {
    
    public static function buildEventMapping($list)
    {
        foreach ($list as $value)
            self::$sanitized_to_id[$value['data']['sanitized']] = $value['data']['id'];
    }

    public static function lookupIdFromSanitized($sanitized)
    {
        if (isset(self::$sanitized_to_id[$sanitized])) return self::$sanitized_to_id[$sanitized];
        return 0;
    }

    private static $sanitized_to_id;
}
?>
