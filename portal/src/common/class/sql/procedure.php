<?php

abstract class SQLProcedure {
    public static final function init($data)
    {
        switch (strtoupper($data['sql']))
        {
            case 'MYSQL':
                LPRMS::load_class('sql/mysql/procedure.php');
                self::$instance = new MySQLProcedure();
            break;
            default: die('Invalid SQL type!');
        }
    }

    public static final function getInstance()
    {
        return self::$instance;
    }

    private static $instance = NULL;

    public abstract function getSettings();
    public abstract function getLocationList();
    public abstract function getEventList();

    public abstract function updateEntry($table, $data);
}
?>
