<?php

class MySQL extends SQL {
    public function __construct($data)
    {
        if (isset($data['hostname']))   $this->host     = $data['hostname'];
        if (isset($data['username']))   $this->username = $data['username'];
        if (isset($data['password']))   $this->password = $data['password'];
        if (isset($data['database']))   $this->db       = $data['database'];
        if (isset($data['prefix']))     $this->prefix   = $data['prefix'];
    }

    public function error($query = '')
    {
        return '<pre>('.mysql_error().': '.$query.')</pre>';
    }

    public function logout()
    {
        if (mysql_close($this->link) === FALSE)
            Error::throw_error(ErrorMessage::SQL_DISCONNECT, Error::CRITICAL);
        $this->link = FALSE;
    }

    public function login()
    {
        if ($this->link !== FALSE)
        {
            echo 'was still logged in for some reason...'."\n";
            $this->logout();
        }
        $this->link = mysql_connect($this->host, $this->username, $this->password, TRUE);
	if ($this->link === FALSE) Error::throw_error(ErrorMessage::SQL_CONNECT, Error::CRITICAL);

	if (mysql_select_db($this->db, $this->link) === FALSE) Error::throw_error(ErrorMessage::SQL_CONNECT, Error::CRITICAL);
    }

    public function query($query)
    {
        $start = microtime();
        $resource = mysql_query($query, $this->link);
	if ($resource === FALSE)
	{
		$errmsg = $this->error($query);
		$this->logout();
		Error::throw_error(ErrorMessage::SQL_QUERY.$errmsg, Error::MINOR);
	}
	elseif ($resource === TRUE)
		return TRUE;

	$array = array();

	while (($row = mysql_fetch_assoc($resource)))
			array_push($array, $row);
	mysql_free_result($resource);
        $this->time += (microtime() - $start);
	$this->numqueries++;
	return $array;
    }

    public function update($table, $assoc, $condition)
    {
        if (count($assoc) == 0) return;
        $query_str = '';
        foreach ($assoc as $key => $value)
        {
            $query_str .= '`'.$key.'` = \''.$value.'\', ';
        }
        if ($query_str != '')
            $query_str = substr($query_str, 0, strlen($query_str) - 2).' ';
        $table = $this->table($table);
        $query_str = 'UPDATE '.$table.' SET '.$query_str.$condition.';';
        $this->query($query_str);
    }

    public function replace($table, $assoc, $condition)
    {
        if (count($assoc) == 0) return;
        $query_str = '';
        $cols = '';
        $vals = '';
        foreach ($assoc as $key => $value)
        {
            $cols .= '`'.$key.'`,';
            $vals .= "'".$value."',";
        }
        if ($cols != '')
            $cols = substr($cols, 0, strlen($cols) - 1);
        if ($vals != '')
            $vals = substr($vals, 0, strlen($vals) - 1);
        $table = $this->table($table);
        $query_str = 'REPLACE INTO '.$table.' ('.$cols.') VALUES ('.$vals.') '.$condition.';';
        $this->query($query_str);
    }

    public function insert($table, $assoc, $condition)
    {
        if (count($assoc) == 0) return;
        $query_str = '';
        $cols = '';
        $vals = '';
        foreach ($assoc as $key => $value)
        {
            $cols .= '`'.$key.'`,';
            $vals .= "'".$value."',";
        }
        if ($cols != '')
            $cols = substr($cols, 0, strlen($cols) - 1);
        if ($vals != '')
            $vals = substr($vals, 0, strlen($vals) - 1);
        $table = $this->table($table);
        $query_str = 'INSERT INTO '.$table.' ('.$cols.') VALUES ('.$vals.') '.$condition.';';
        $this->query($query_str);
    }

    public function delete($table, $condition)
    {
        $table = $this->table($table);
        $query_str = 'DELETE FROM '.$table.' '.$condition.';';
        $this->query($query_str);
    }

    public function table($table)
    {
        return '`'.$this->prefix.$table.'`';
    }

    protected $host = 'localhost';
    protected $db = 'lprms';
    protected $username = 'lprms';
    protected $password = 'lprms';
    protected $prefix = 'lprms_';
    protected $link = FALSE;
}

?>
