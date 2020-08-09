<?php


class GenericModel extends Crud
{
    private $className;
    private $exclude = ["className", "table", "connection", "wheres", "sql", "exclude"];

    function __construct($table, $className, $properties = null)
    {
        parent::__construct($table);
        $this->className = $className;

        if (empty($properties)) {
            return;
        }

        foreach ($properties as $key => $value) {
            $this->{$key} = $value;
        }
    }

    protected function getAttributes()
    {
        $variables = get_class_vars($this->className);
        $attributes = [];
        $max = count($variables);
        foreach ($variables as $key => $value) {
            if (!in_array($key, $this->exclude)) {
                $attributes[] = $key;
            }
        }
        return $attributes;
    }

    protected function parsear($obj = null)
    {
        try {
            $attributes = $this->getAttributes();
            $finalObject = [];

            // Obtenes el objeto desde el modelo
            if ($obj == null) {
                foreach ($attributes as $index => $key) {
                    if (isset($this->{$key})) {
                        $finalObject[$key] = $this->{$key};
                    }
                }
                return $finalObject;
            }

            // Corregir el objeto que recibimos con los atributos del modelo
            foreach ($attributes as $index => $key) {
                if (isset($obj[$key])) {
                    $finalObject[$key] = $obj[$key];
                }
            }
            return $finalObject;
        } catch (Exception $exc) {
            throw new Exception("Error in " . $this->className . ".parsear() => " . $exc->getMessage());
        }
    }

    public function fill($obj) {
        try {
            $attributes = $this->getAttributes();
            foreach ($attributes as $index => $key) {
                if (isset($obj[$key])) {
                    $this->{$key} = $obj[$key];
                }
            }
        } catch (Exception $exc) {
            throw new Exception("Error in " . $this->className . ".fill() => " . $exc->getMessage());
        }
    }

    public function insert($obj = null) {
        $obj = $this->parsear($obj);
        return parent::insert($obj);
    }

    public function update($obj) {
        $obj = $this->parsear($obj);
        return parent::update($obj);
    }

    public function __get($attributeName) {
        return $this->{$attributeName};
    }

    public function __set($attributeName, $value) {
        $this->{$attributeName} = $value;
    }
}