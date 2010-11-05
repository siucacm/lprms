<?php

class Form {
    function __construct($type, $button_txt, $size = 15)
    {
        $this->type = $type;
        $this->size = $size;
        $this->button_txt = $button_txt;
    }

    public function add_dropdown($label, $name, $assoc)
    {
        $dropdown = new Dropdown($label, $name);
        foreach ($assoc as $key => $value)
            $dropdown->add_option($key, $value);
        $this->fields[] = $dropdown;
    }

    public function add_separator()
    {
        $this->fields[] = NULL;
    }

    public function add_date($label)
    {
        $this->fields[] = new DateInput($label);
    }

    public function add_recaptcha()
    {
        $this->add_text(array('label' => '', 'value' => Captcha::display()));
    }

    public function add_text($assoc)
    {
        if (!isset($assoc['label'])) $assoc['label'] = 'Label: ';
        if (!isset($assoc['value'])) $assoc['value'] = '';
        $this->fields[] = new NonInput(
                    $assoc['label'],
                    $assoc['value']
                );
    }

    public function add_hidden($assoc)
    {
        if (!isset($assoc['name'])) $assoc['name'] = 'name';
        if (!isset($assoc['value'])) $assoc['value'] = '';
        $this->fields[] = new HiddenInput(
                    $assoc['name'],
                    $assoc['value']
                );
    }

    public function add_field($assoc)
    {
        if (!isset($assoc['label'])) $assoc['label'] = 'Label: ';
        if (!isset($assoc['name'])) $assoc['name'] = 'name';
        if (!isset($assoc['value'])) $assoc['value'] = '';
        if (!isset($assoc['type'])) $assoc['type'] = 'text';
        if (!isset($assoc['ajax'])) $assoc['ajax'] = FALSE;
        $input = new Input(
                    $assoc['label'],
                    $assoc['name'],
                    $assoc['value'],
                    $assoc['type'],
                    $assoc['ajax']
                );
        $this->fields[] = $input;
        $input->set_size($this->size);
    }

    public function render()
    {
        echo '<div style="text-align: center; width:100%">';
        echo '<form method="post" action="'.LPRMS::post().'">';
        echo "\n";
        echo '<input type="hidden" name="form" value="'.$this->type.'" />';
        echo "\n";
        echo '<table class="form" summary="'.$this->type.' Form">';
        for ($i = 0; $i < count($this->fields); $i++)
        {
            if ($this->fields[$i] == NULL)
                echo '<tr><th colspan="2">'.self::SEPARATOR.'</th></tr>';
            else
            {
                echo '<tr>';
                $this->fields[$i]->render();
                echo '</tr>';
            }
        }
        echo '</table>';
        echo '<input class="login_submit" type="submit" name="Submit" value="'.$this->button_txt.'" />';
        echo '</form>';
        echo '</div>';
    }

    protected $recaptcha = FALSE;
    protected $type = 'form';
    protected $button_txt = 'Submit &raquo;';
    protected $fields = array();
    protected $custom = '';
    private $size = 15;

    const SEPARATOR = '<br /><hr /><br />';
}
?>
