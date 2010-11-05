<?php

class Type {

    public static function attendeeDescription($type = self::ATTENDEE_NO)
    {
        switch ($type)
        {
            case self::ATTENDEE_NO: return 'None';
            case self::ATTENDEE_WI: return 'Walk-in';
            case self::ATTENDEE_PR: return 'Pre-registered';
            case self::ATTENDEE_EB: return 'Early-bird';
            case self::ATTENDEE_DS: return 'Booth';
            case self::ATTENDEE_SP: return 'Speaker';
            case self::ATTENDEE_ST: return 'Staff';
            case self::ATTENDEE_GM: return 'General Manager';
            default:                return 'Undefined';
        }
    }

    public static function attendeePrefix($type = self::ATTENDEE_NO)
    {
        switch ($type)
        {
            case self::ATTENDEE_NO: return 'NO';
            case self::ATTENDEE_WI: return 'WI';
            case self::ATTENDEE_PR: return 'PR';
            case self::ATTENDEE_EB: return 'EB';
            case self::ATTENDEE_DS: return 'DS';
            case self::ATTENDEE_SP: return 'SP';
            case self::ATTENDEE_ST: return 'ST';
            case self::ATTENDEE_GM: return 'GM';
            default:                return 'UN';
        }
    }

    public static function attendeeDefault()
    {
        return self::ATTENDEE_NO;
    }

    const ATTENDEE_NO = 0;
    const ATTENDEE_WI = 1;
    const ATTENDEE_PR = 2;
    const ATTENDEE_EB = 3;
    const ATTENDEE_DS = 4;
    const ATTENDEE_SP = 5;
    const ATTENDEE_ST = 6;
    const ATTENDEE_GM = 7;

    public static function platformDescription($type = self::PLATFORM_NA)
    {
        switch($type)
        {
            case self::PLATFORM_NA:         return 'Not Applicable';
            case self::PLATFORM_WINDOWS:    return 'Microsoft Windows';
            case self::PLATFORM_LINUX:      return 'Linux';
            case self::PLATFORM_MAC:        return 'Apple Mac';
            case self::PLATFORM_XBOX360:    return 'Microsoft Xbox 360';
            case self::PLATFORM_PS3:        return 'Sony Playstation 3';
            case self::PLATFORM_WII:        return 'Nintendo Wii';
            case self::PLATFORM_XBOX:       return 'Microsoft Xbox (Original)';
            case self::PLATFORM_PS2:        return 'Sony Playstation 2';
            case self::PLATFORM_GAMECUBE:   return 'Nintendo Gamecube';
            case self::PLATFORM_PERSON:     return 'People';
            default:                        return 'Undefined';
        }
    }

    public static function platformIcon($type = self::PLATFORM_NA)
    {
        switch($type)
        {
            case self::PLATFORM_NA:         return '';
            case self::PLATFORM_WINDOWS:    return '';
            case self::PLATFORM_LINUX:      return '';
            case self::PLATFORM_MAC:        return '';
            case self::PLATFORM_XBOX360:    return '';
            case self::PLATFORM_PS3:        return '';
            case self::PLATFORM_WII:        return '';
            case self::PLATFORM_XBOX:       return '';
            case self::PLATFORM_PS2:        return '';
            case self::PLATFORM_GAMECUBE:   return '';
            case self::PLATFORM_PERSON:     return '';
            default:                        return '';
        }
    }

    const PLATFORM_NA = 0;
    const PLATFORM_WINDOWS = 1;
    const PLATFORM_LINUX = 2;
    const PLATFORM_MAC = 3;
    const PLATFORM_XBOX360 = 4;
    const PLATFORM_PS3 = 5;
    const PLATFORM_WII = 6;
    const PLATFORM_XBOX = 7;
    const PLATFORM_PS2 = 8;
    const PLATFORM_GAMECUBE = 9;
    const PLATFORM_PERSON = 10;

    public static function roleDescription($type = self::ROLE_NOBODY)
    {
        switch ($type)
        {
            case self::ROLE_NOBODY:         return 'Nobody';
            case self::ROLE_UNCONFIRMED:    return 'Unconfirmed';
            case self::ROLE_USER:           return 'User';
            case self::ROLE_EDITOR:         return 'Editor';
            case self::ROLE_MANAGER:        return 'Event Manager';
            case self::ROLE_ADMINISTRATOR:  return 'Administrator';
            default:                        return 'Undefined';
        }
    }

    const ROLE_NOBODY = 0;
    const ROLE_UNCONFIRMED = 1;
    const ROLE_USER = 2;
    const ROLE_EDITOR = 3;
    const ROLE_MANAGER = 4;
    const ROLE_ADMINISTRATOR = 5;

    public static function matchDescription($type = self::MATCH_NA)
    {
        switch ($type)
        {
            case self::MATCH_NA:            return 'Not Applicable';
            case self::MATCH_FFA:           return 'Free for All';
            case self::MATCH_CTF:           return 'Capture the Flag';
            case self::MATCH_DCTF:          return 'Double Capture the Flag';
            case self::MATCH_DM:            return 'Death Match';
            default:                        return 'Undefined';

        }
    }

    const MATCH_NA = 0;
    const MATCH_FFA = 1;
    const MATCH_CTF = 2;
    const MATCH_DCTF = 3;
    const MATCH_DM = 4;

}
?>
