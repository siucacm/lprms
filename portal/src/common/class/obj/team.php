<?php

class Team extends Object {
    function __construct($id)
    {
        parent::__construct($id, 'core_teams');
    }

    public function __toString()
    {
        $str = parent::__toString();
        $str .= 'Members: '.implode(',',array_keys($this->members))."\n";
        $str .= 'Size: '.$this->num_players()."\n\n";
        return $str;
    }

    public function load()
    {
        parent::load();
        $this->load_members();
    }

    public function link()
    {
        return LPRMS::home().'team/'.$this->sanitized;
    }

    public function num_players()
    {
        return count($this->members);
    }

    private $members = array();

    public function prepare()
    {
        
    }

    private function load_members()
    {
        $table = MySQL::table('ref_user_team');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.' WHERE `id_team` = '.$this->oid().';');
        MySQL::logout();
        $this->members = array();
        if ($result !== FALSE && count($result) > 0)
        {
            for ($i = 0; $i < count($result); $i++)
            {
                $entry = $result[$i];
                $this->members[$entry['id_user']] = Library::get_user($entry['id_user']);
            }
        }
    }

}
?>
