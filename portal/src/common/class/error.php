<?php

class ErrorMessage {
    const SQL_CONNECT = 'Error establishing connection to SQL server; perhaps you should double-check your configuration file?';
    const SQL_DISCONNECT = 'Error closing connection to SQL server.';
    const SQL_TYPE = 'Invalid SQL type defined in configuration file.';
    const SQL_QUERY = 'Error performing SQL query.';
    const SQL_DATA = 'Data is missing from the database; are you sure LPRMS is installed correctly?';

    const NODEFINE = 'Please visit the index page';

    const POST_MISSING = 'Invalid POST headers were sent; perhaps you should retry your query?';
    const POST_INVALID = 'Form type is invalid; perhaps you should retry your query?';

}

class Error {
    public static function disp_header()
    {
        echo '<html>
	<head>
		<title>Error</title>
	</head>
	<body>
		<div class="content">';
    }

    public static function disp_footer()
    {
        echo '</div>
	</body>
</html>';
    }

    public static final function throw_error($message, $type = self::MINOR)
    {
        switch ($type)
        {
            case self::CRITICAL:
                self::disp_header();
                echo '<pre>'.$message.'</pre>';
                self::disp_footer();
                exit;
            case self::MINOR:
                echo '<pre>'.$message.'</pre>';
                return;
            default: exit;
        }
    }

    public static final function set_persistent_error($message)
    {
        Session::store('error', $message.'<br /><br />');
    }

    public static final function view_persistent_error()
    {
        return Session::get('error');
    }

    public static final function clear_persistent_error()
    {
        Session::del('error');
    }

    const CRITICAL = 0;
    const MINOR = 1;
}
?>
