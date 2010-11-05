<?php

class DateInput {
    function __construct($label)
    {
        $this->label = $label;
    }

    public final function render($type = self::TYPE_TABLE)
    {
        ob_start();
        echo '<label for="month">M:</label>';
        echo '<select id="month" name="month">';
        echo '<option value="1">January</option>'."\n";
        echo '<option value="2">February</option>'."\n";
        echo '<option value="3">March</option>'."\n";
        echo '<option value="4">April</option>'."\n";
        echo '<option value="5">May</option>'."\n";
        echo '<option value="6">June</option>'."\n";
        echo '<option value="7">July</option>'."\n";
        echo '<option value="8">August</option>'."\n";
        echo '<option value="9">September</option>'."\n";
        echo '<option value="10">October</option>'."\n";
        echo '<option value="11">November</option>'."\n";
        echo '<option value="12">December</option>'."\n";
        echo '</select>';

        echo ' <label for="day">D:</label>';
        echo '<select id="day" name="day">';
        for ($i = 1; $i <= 31; $i++)
            echo '<option value="'.$i.'">'.$i.'</option>'."\n";
        echo '</select>';

        $now_y = intval(date('Y'));
        echo ' <label for="year">Y:</label>';
        echo '<select id="year" name="year">';
        for ($i = $now_y; $i >= self::LIMIT; $i--)
            echo '<option value="'.$i.'">'.$i.'</option>'."\n";
        echo '</select>';
        $str = ob_get_clean();
        switch ($type)
        {
            case self::TYPE_SOLO:
                echo $this->label.': ';
                echo $str;
                break;
            case self::TYPE_TABLE:
                echo '<th>'.$this->label.'</th>';
                echo '<td>'.$str;
                echo '</td>';
                break;
        }
        echo "\n";
    }

    private $label = '';

    const LIMIT = 1950;
    const TYPE_SOLO = 0;
    const TYPE_TABLE = 1;
}

class Input {

    function __construct($label, $name, $value= '', $type = 'text', $ajax = FALSE)
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
        $this->ajax = $ajax;
    }

    public final function render($type = self::TYPE_TABLE)
    {
        $label = '<label for="'.$this->name.'">'.$this->label.'</label>';
        $field = '<input type="'.$this->type.'" id="'.$this->name.'" name="'.$this->name.'" value="'.$this->value.'" size="'.$this->size.'" />';
        $ajax = '<br /><span id="'.$this->name.'Loading"><img src="'.LPRMS::home().'/common/img/indicator.gif" alt="" /></span>';
        $ajax .= '<span id="'.$this->name.'Result"></span>';
        switch ($type)
        {
            case self::TYPE_SOLO:
                echo $label.': ';
                echo $field;
                if ($this->ajax) echo $ajax;
                break;
            case self::TYPE_TABLE:
                echo '<th>'.$label.'</th>';
                echo '<td>'.$field;
                if ($this->ajax) echo $ajax;
                echo '</td>';
                break;
        }
        echo "\n";
    }

    public final function set_size($size)
    {
        $this->size = $size;
    }

    protected $ajax = FALSE;
    protected $label = 'Label';
    protected $type = 'text';
    protected $name = 'name';
    protected $value = 'value';
    private $size = 15;

    const TYPE_SOLO = 0;
    const TYPE_TABLE = 1;
}

class NonInput {
    function __construct($label, $value= '')
    {
        $this->label = $label;
        $this->value = $value;
    }

    public final function render($type = self::TYPE_TABLE)
    {
        switch ($type)
        {
            case self::TYPE_SOLO:
                echo $this->label.': ';
                echo $this->value;
                break;
            case self::TYPE_TABLE:
                echo '<th>'.$this->label.'</th>';
                echo '<td>'.$this->value.'</td>';
                break;
        }
        echo "\n";
    }

    protected $label = 'Label';
    protected $value = 'value';

    const TYPE_SOLO = 0;
    const TYPE_TABLE = 1;
}

class HiddenInput {
    function __construct($name, $value= '')
    {
        $this->name = $name;
        $this->value = $value;
    }

    public final function render($type = self::TYPE_TABLE)
    {
        switch ($type)
        {
            case self::TYPE_SOLO:
                echo '<input type="hidden" name="'.$this->name.'" value="'.$this->value.'" />';
                break;
            case self::TYPE_TABLE:
                echo '<th colspan="2">'.'<input type="hidden" name="'.$this->name.'" value="'.$this->value.'" />'.'</th>';
                break;
        }
        echo "\n";
    }

    protected $name = 'name';
    protected $value = 'value';

    const TYPE_SOLO = 0;
    const TYPE_TABLE = 1;
}

?>
