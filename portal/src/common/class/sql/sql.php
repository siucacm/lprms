<?php

abstract class SQL {

    public static final function init()
    {
        LPRMS::load_class('sql/sqlformat.php');
        LPRMS::load_class('sql/procedure.php');

        $conf = LPRMS::path(self::CONF);
        if (!file_exists($conf)) return FALSE;
        require_once($conf);
        if (!isset($data) || !isset($data['sql'])) return FALSE;
        
        switch (strtoupper($data['sql']))
        {
            case 'MYSQL':
                LPRMS::load_class('sql/mysql/sql.php');
                self::$instance = new MySQL($data);
            break;
            default: die('Invalid SQL type!');
        }

        SQLProcedure::init($data);
    }

    public static final function getInstance()
    {
        return self::$instance;
    }

    public final function queries()
    {
        return $this->numqueries;
    }

    public final function time()
    {
        return round($this->time, 6);
    }

    private static $instance = NULL;

    protected $numqueries = 0;
    protected $time = 0;

    const CONF = 'config.inc.php';

    public abstract function error();
    public abstract function logout();
    public abstract function login();
    public abstract function query($query);
    public abstract function update($table, $assoc, $condition);
    public abstract function replace($table, $assoc, $condition);
    public abstract function insert($table, $assoc, $condition);
    public abstract function delete($table, $condition);
    public abstract function table($table);
}

?>
