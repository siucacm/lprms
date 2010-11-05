<?php

class Session {

    public static final function set_key($key)
    {
        $this->key = 'LPRMS_'.$key;
    }
    
    public static final function init($name)
    {
        session_name(self::$key);
        session_start();
    }

    public static final function start($uid)
    {
        $_SESSION['uid'] = $uid;
    }

    public static final function active()
    {
        if (!isset($_SESSION['uid'])) return FALSE;
	return TRUE;
    }

    public static final function uid()
    {
        return $_SESSION['uid'];
    }

    public static final function store($key, $value)
    {
        $_SESSION['vars'][$key] = $value;
    }

    public static final function get($key)
    {
        if (isset($_SESSION['vars'][$key]))
            return $_SESSION['vars'][$key];
        return '';
    }

    public static final function del($key)
    {
        if (isset($_SESSION['vars'][$key])) unset($_SESSION['vars'][$key]);
    }

    public static final function clear()
    {
        if (isset($_SESSION['vars'])) unset($_SESSION['vars']);
    }

    public static final function destroy()
    {
        $_SESSION = array();
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}
	session_destroy();
    }

    private static $key = 'LPRMS';
}
?>
