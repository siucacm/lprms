<?php

class XFire {
    function  __construct($uid)
    {
        $this->id_user = SQL::num($uid);
    }

    public function load()
    {
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.MySQL::table('cache_xml_xfire').' WHERE `id_user` = '.$this->id_user.';');
        MySQL::logout();
        if ($result === FALSE || count($result) == 0) return;
        $this->data = $result[0];
    }

    public function commit()
    {
        MySQL::login();
        MySQL::replace('cache_xml_xfire', $this->data, '');
        MySQL::logout();
    }

    public function load_remote()
    {
        if ($this->id == '') return;
        $result = NULL;
        $result = XXML::parse('http://www.xfire.com/xml/'.$this->id.'/profile/');
        if ($result[0]['value'][0]['name'] == 'error')
            return;
        $this->display = SQL::string($result[0]['value'][1]['value']['text']);
        $this->online = ($result[0]['value'][10]['value']['text'] != 'offline')?1:0;
        $this->icon = SQL::string($result[0]['value'][2]['value']['text']);

        if ($this->online)
            $this->realname = SQL::string($result[0]['value'][13]['value']['text']);
        else
            $this->realname = SQL::string($result[0]['value'][12]['value']['text']);
        $this->valid = 1;
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
        'display' => 'Unknown',
        'realname' => 'Unknown',
        'online' => 0,
        'icon' => '',
        'valid' => 0
    );
}
?>
