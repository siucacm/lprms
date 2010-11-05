<?php

class Dropdown {
    function __construct($label, $name)
    {
        $this->label = $label;
        $this->name = $name;
    }

    public function add_option($key, $value)
    {
        $this->options[$key] = $value;
    }

    public function render($type = self::TYPE_TABLE)
    {
        $dropdown = '<select name="'.$this->name.'" size="1">';
        $dropdown .= "\n";
        $dropdown .= '<option value="0">None</option>';
        $dropdown .= "\n";
        foreach ($this->options as $key => $value)
        {
            $dropdown .= '<option value="'.$key.'">'.$value.'</option>';
            $dropdown .= "\n";
        }
        $dropdown .= '</select>';
        $dropdown .= "\n";

        switch ($type)
        {
            case self::TYPE_SOLO:
                echo $this->label.': '.$dropdown;
                break;
            case self::TYPE_TABLE:
                echo '<tr>';
                echo '<th>'.$this->label.'</th>';
                echo '<td>'.$dropdown.'</td>';
                echo '</tr>';
                break;
        }
    }

    protected $options = array();
    protected $selected = 0;
    protected $name = '';
    protected $label = 'Dropdown';
    
    const TYPE_SOLO = 0;
    const TYPE_TABLE = 1;
}

class MonthDropdown extends Dropdown {
    function __construct($selected = 1)
    {
        parent::__construct('Month', 'month');
        parent::add_option(1, 'January');
        parent::add_option(2, 'February');
        parent::add_option(3, 'March');
        parent::add_option(4, 'April');
        parent::add_option(5, 'May');
        parent::add_option(6, 'June');
        parent::add_option(7, 'July');
        parent::add_option(8, 'August');
        parent::add_option(9, 'September');
        parent::add_option(10, 'October');
        parent::add_option(11, 'November');
        parent::add_option(12, 'December');

        $this->selected = $selected;
    }
}

class YearDropdown extends Dropdown {
    function __construct($selected = 2010)
    {
        parent::__construct('Year', 'year');
        $now_y = date('Y');

        for ($i = self::LIMIT; $i <= $now_y; $i++)
            parent::add_option($i, $i);

        $this->selected = $selected;
    }

    const LIMIT = 1950;
}

class DayDropdown extends Dropdown {
    function __construct($selected = 1)
    {
        parent::__construct('Day', 'day');

        for ($i = 1; $i <= 31; $i++)
            parent::add_option($i, $i);

        $this->selected = $selected;
    }

}

class RoleDropdown extends Dropdown {
    function __construct($selected = 0)
    {
        parent::__construct('Role', 'id_role');
        $table = MySQL::table('type_roles');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.';');
        MySQL::logout();
        if ($result == FALSE || count($result) == 0) return;
        for ($i = 0; $i < count($result); $i++)
            parent::add_option($result[$i]['id'], $result[$i]['name']);
        $this->selected = $selected;
    }
}

class AttendeeDropdown extends Dropdown {
    function __construct($selected = 0)
    {
        parent::__construct('Classification', 'id_attendee');
        $table = MySQL::table('type_attendees');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.';');
        MySQL::logout();
        if ($result == FALSE || count($result) == 0) return;
        for ($i = 0; $i < count($result); $i++)
            parent::add_option($result[$i]['id'], $result[$i]['description']);
        $this->selected = $selected;
    }
}

class GameDropdown extends Dropdown {
    function __construct($selected = 0)
    {
        parent::__construct('Game', 'id_game');
        $table = MySQL::table('type_games');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.';');
        MySQL::logout();
        if ($result == FALSE || count($result) == 0) return;
        for ($i = 0; $i < count($result); $i++)
            parent::add_option($result[$i]['id'], $result[$i]['name']);
        $this->selected = $selected;
    }
}

class PlatformDropdown extends Dropdown {
    function __construct($selected = 0)
    {
        parent::__construct('Platform', 'id_platform');
        $table = MySQL::table('type_platforms');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.';');
        MySQL::logout();
        if ($result == FALSE || count($result) == 0) return;
        for ($i = 0; $i < count($result); $i++)
            parent::add_option($result[$i]['id'], $result[$i]['name']);
        $this->selected = $selected;
    }
}

class MatchDropdown extends Dropdown {
    function __construct($selected = 0)
    {
        parent::__construct('Game Type', 'id_match');
        $table = MySQL::table('type_matches');
        MySQL::login();
        $result = MySQL::query('SELECT * FROM '.$table.';');
        MySQL::logout();
        if ($result == FALSE || count($result) == 0) return;
        for ($i = 0; $i < count($result); $i++)
            parent::add_option($result[$i]['id'], $result[$i]['name']);
        $this->selected = $selected;
    }
}

?>
