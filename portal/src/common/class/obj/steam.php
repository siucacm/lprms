<?php

class Steam {
    function  __construct($uid)
    {
        $this->id_user = SQL::num($uid);
    }

    public function load()
    {
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.MySQL::table('cache_xml_steam').' WHERE `id_user` = '.$this->id_user.';');
        MySQL::logout();
        if ($result === FALSE || count($result) == 0) return;
        $this->data = $result[0];
    }

    public function commit()
    {
        MySQL::login();
        MySQL::replace('cache_xml_steam', $this->data, '');
        MySQL::logout();
    }

    public function load_remote()
    {
        if ($this->id_numeric == 0 && $this->id == '') return;
        $result = NULL;
        //echo 'http://steamcommunity.com/profiles/'.$this->id_numeric.'?xml=1'."\n";
        //echo 'http://steamcommunity.com/id/'.$this->id.'?xml=1'."\n";
        if ($this->id_numeric != 0)
            $result = XXML::parse('http://steamcommunity.com/profiles/'.$this->id_numeric.'?xml=1');
        if ($result == NULL || $result[0]['value'][0]['name'] == 'error')
        {
            //echo 'Error!';
            if ($this->id != '')
            {
                //echo 'Trying alpha id';
                $result = XXML::parse('http://steamcommunity.com/id/'.$this->id.'?xml=1');
                //print_r($result);
            }
        }
        if ($result == NULL || $result[0]['value'][0]['name'] == 'error')
            return;
        //print_r($result);
        $this->id_numeric = SQL::string($result[0]['value'][0]['value']['text']);
        $this->display = SQL::string($result[0]['value'][1]['value']['text']);
        $this->online = ($result[0]['value'][2]['value']['text'] != 'offline')?1:0;
        $this->state = SQL::string($result[0]['value'][3]['value']['text']);
        $this->iconFull = SQL::string($result[0]['value'][8]['value']['text']);
        $this->iconMedium = SQL::string($result[0]['value'][7]['value']['text']);
        $this->icon = SQL::string($result[0]['value'][6]['value']['text']);
        //echo count($result[0]['value'])."\n";
        if (count($result[0]['value']) > 12)
        {
            $this->id = SQL::string($result[0]['value'][11]['value']['text']);
            $offset = 0;
            if ($result[0]['value'][13]['name'] == 'inGameInfo')
                $offset+=2;
            $this->headline = SQL::string($result[0]['value'][15+$offset]['value']['text']);
            $this->summary = SQL::string($result[0]['value'][18+$offset]['value']['text']);
            $this->rating = SQL::string($result[0]['value'][13+$offset]['value']['text']);
            $this->realname = SQL::string($result[0]['value'][17+$offset]['value']['text']);
        }
        $this->valid = 1;
        //print_r($data);
    }

    public function __get($var)
    {
        if (isset($this->data[$var])) return $this->data[$var];
        return '';
    }

    public function __set($var, $value)
    {
        $this->data[$var] = $value;
    }

    private $data = array(
        'id' => '',
        'id_numeric' => 0,
        'id_user' => 0,
        'display' => 'Unknown',
        'realname' => 'Unknown',
        'online' => 0,
        'state' => 'Offline',
        'iconFull' => '',
        'iconMedium' => '',
        'icon' => '',
        'headline' => '',
        'summary' => '',
        'rating' => 0,
        'valid' => 0
    );

}
?>
