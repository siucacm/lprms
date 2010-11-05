<?php

class Event extends Object {
    function __construct($id)
    {
        parent::__construct($id, 'core_events');
    }

    public function  __toString()
    {
        $str = parent::__toString();
        $str .= "\n";
        return $str;
    }

    public function load()
    {
        parent::load();
        $this->generate_seat_list();
        $this->load_map();
        $this->load_location();
    }

    public function load_mini()
    {
        parent::load();
    }

    public function num()
    {
        return $this->num;
    }

    public function active()
    {
        $now = time();
        $u_date = strtotime($this->datetime_end);
        return $now < $u_date;
    }

    public function duration()
    {
        $end = strtotime($this->datetime_end);
        $start = strtotime($this->datetime_start);
        return ceil(($end-$start)/60/60);
    }

    public function location()
    {
        $loc = Library::get_location($this->id_location);
        if ($loc === FALSE || $loc == NULL) return 'Unknown';
        return $loc->name;
    }

    public function date()
    {
        $end = strtotime($this->datetime_end);
        $start = strtotime($this->datetime_start);
        return date(LPRMS::conf('dateformat'), $start).' - '.date(LPRMS::conf('dateformat'), $end);
    }

    public function link()
    {
        return LPRMS::page('event/'.$this->sanitized);
    }

    public function prepare()
    {
        parent::prepare();
        unset($this->id);
        $this->name             = MySQL::string($this->name);
        $this->sanitized        = MySQL::alphanum($this->sanitized);
        $this->datetime_start   = MySQL::bday($this->datetime_start);
        $this->datetime_end     = MySQL::bday($this->datetime_end);
        $this->price            = MySQL::float($this->price);
        $this->id_location      = MySQL::num($this->id_location);
        $this->id_map           = MySQL::num($this->id_map);
        $this->capacity         = MySQL::num($this->capacity);
        $this->information      = MySQL::string($this->information);
        $this->rules            = MySQL::string($this->rules);
        $this->agreement        = MySQL::string($this->agreement);
        $this->min_age          = MySQL::num($this->min_age);
    }

    public function get_seat_list()
    {
        return $this->seats;
    }

    private $seats = array();
    private $num = 0;

    private function load_map()
    {
        $table = MySQL::table('core_maps');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.' WHERE `id` = \''.$this->id_map.'\';');
        MySQL::logout();
        if ($result == FALSE || count($result) == 0) $this->map = '';
        else $this->map = $result[0]['xml'];
    }

    private function load_location()
    {
        $this->location = Library::get_location($this->id_location);
    }

    public static final function get_sanitized_by_id($uid)
    {
        $table = MySQL::table('core_events');
        $uid = SQL::num($uid);
        MySQL::login();
        $result = MySQL::query('SELECT `sanitized` FROM '.$table.' WHERE `id` = \''.$uid.'\';');
        MySQL::logout();
        if ($result == FALSE || count($result) == 0) return FALSE;
        return $result[0]['sanitized'];
    }

    public static final function get_id_by_sanitized($sanitized)
    {
        $table = MySQL::table('core_events');
        $sanitized = SQL::alphanum($sanitized);
        MySQL::login();
        $result = MySQL::query('SELECT `id` FROM '.$table.' WHERE `sanitized` = \''.$sanitized.'\';');
        MySQL::logout();
        if ($result == FALSE || count($result) == 0) return FALSE;
        return $result[0]['id'];
    }

    private function generate_seat_list()
    {
        $table = MySQL::table('ref_user_event');
	MySQL::login();
	$seats = MySQL::query('SELECT * FROM '.$table.' WHERE `id_event` = \''.$this->oid().'\';');
	MySQL::logout();

	for ($i = 0; $i < count($seats); $i++)
	{
		$seat = $seats[$i];
                if ($seat['seat'] == '') continue;
		$a = substr($seat['seat'], 0, strlen($seat['seat']) - 1);
		$b = substr($seat['seat'], strlen($seat['seat']) - 1);
		$this->seats[$a][$b] = $seat['id_user'];
                $this->num++;
	}
    }
}
?>
