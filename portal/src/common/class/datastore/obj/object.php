<?php
abstract class Object
{
    function __construct($table)
    {
        $this->table = $table;
    }

    public function inject($params)
    {
        $this->data = array_merge($this->data, $params);
    }

    public function __get($var)
    {
        if (isset($this->data[$var])) return $this->data[$var];
        return '';
    }

    public final function __set($var, $value)
    {
        $this->data[$var] = $value;
    }

    public function commit()
    {
        $this->prepare();
        SQLProcedure::getInstance()->updateEntry($table, $this->data);
    }

    public function __toString()
    {
        ob_start();
        echo '<pre>';
        print_r($this->data);
        echo '</pre>';
        return ob_get_clean();
    }

    protected abstract function prepare();

    private $table;
    protected $data;
}
?>
