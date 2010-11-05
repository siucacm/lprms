<?php

abstract class Object {
    function __construct($id, $table)
    {
        $this->oid = SQL::num($id);
        $this->table = $table;
    }

    public function load()
    {
        $table = MySQL::table($this->table);
        $id = SQL::num($this->oid);
        MySQL::login();
        $array = MySQL::query('SELECT * FROM '.$table.' WHERE `id` = \''.$id.'\';');
        if (count($array > 0))
            $this->data = $array[0];
        MySQL::logout();
        $this->oldkeys = $this->data;
        $this->init = TRUE;
    }

    protected function data()
    {
        return $this->data;
    }

    public function inject($params)
    {
        $this->data = array_merge($this->data, $params);
    }

    public final function __get($var)
    {
        if ($this->is_init() === FALSE && $this->oid() != 0) $this->load();
        if (isset($this->data[$var])) return $this->data[$var];
        return FALSE;
    }

    public final function __set($var, $value)
    {
        if ($this->is_init() === FALSE && $this->oid() != 0) $this->load();
        $this->data[$var] = $value;
    }

    public final function __unset($var)
    {
        if (isset($this->data[$var])) unset($this->data[$var]);
    }

    public function  __toString()
    {
        if ($this->is_init() === FALSE && $this->oid() != 0) $this->load();
        $str = 'Class: '.__CLASS__."\n".'Data ';
        ob_start();
        print_r($this->data);
        $str .= ob_get_clean();
        $str .= "\n";
        $str .= 'Extra ';
        ob_start();
        print_r($this->extra);
        $str .= ob_get_clean();
        $str .= "\n";
        return $str;
    }

    public final function is_init()
    {
        return $this->init;
    }

    public final function oid()
    {
        return $this->oid;
    }

    public final function table()
    {
        return $this->table;
    }

    public function commit()
    {
        $this->prepare();
        MySQL::login();
        MySQL::update($this->table, $this->data, 'WHERE `id` = '.($this->oid));
        MySQL::logout();
        $this->load();
    }
    public function prepare()
    {
        foreach ($this->data as $key => $value)
                if (!array_key_exists($key, $this->oldkeys))
                        unset($this->data[$key]);
    }

    public function create_new()
    {
        $this->fill_keys();
        unset($this->data['id']);
        if (isset($this->data['username'])) $this->data['username'] = md5(rand());
        if (isset($this->data['sanitized'])) $this->data['sanitized'] = md5(rand());
        if (isset($this->data['email'])) $this->data['email'] = substr(md5(rand()),0,10).'@localhost';
        if (isset($this->data['birthday'])) $this->data['birthday'] = '0000-00-00';
        if (isset($this->data['joined'])) $this->data['birthday'] = '0000-00-00 00:00:00';
        $this->prepare();
        MySQL::login();
        MySQL::insert($this->table,$this->data, '');
        $result = MySQL::query('SELECT LAST_INSERT_ID() AS `id`;');
        MySQL::logout();
        $this->oid = $result[0]['id'];
        $this->load();
    }

    public function fill_keys()
    {
        $table = MySQL::table($this->table);
        MySQL::login();
        $results = MySQL::query('SHOW COLUMNS FROM '.$table.';');
        MySQL::logout();
        if ($results === FALSE || count($results) == 0) return;
        for ($i = 0; $i < count($results); $i++)
            $this->data[$results[$i]['Field']] = $results[$i]['Default'];
        $this->oldkeys = $this->data;
    }

    private $oid = 0;
    private $init = FALSE;
    private $table = '';
    private $oldkeys = array();
    private $data = array();
    private $extra = array();

}
?>
