<?php

class Crud
{
    protected $table;
    protected $connection;
    protected $wheres = "";
    protected $sql = null;

    /**
     * @return mixed
     */
    public function __construct($table = null)
    {
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $this->connection = (new Connection())->connect();
        $this->table = $table;
    }

    /**
     * @return null
     */
    public function get()
    {
        try {
            $this->sql = "SELECT * FROM {$this->table} {$this->wheres}";
            $sth = $this->connection->prepare($this->sql);
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * @return null
     */
    public function insert($obj)
    {
        try {
            $fields = implode("`, `", array_keys($obj)); //names`, `surnames`, `age
            $values = ":" . implode(", :", array_keys($obj)); //:names, :surnames, :age
            $this->sql = "INSERT INTO {$this->table} (`{$fields}`) VALUES ({$values})";
            $this->execute($obj);
            $id = $this->connection->lastInsertId();
            return $id;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    private function execute($obj = null)
    {
        $sth = $this->connection->prepare($this->sql);
        if ($obj !== null) {
            foreach ($obj as $key => $value) {
                if (empty($value)) {
                    $value = NULL;
                }
                $sth->bindValue(":$key", $value);
            }
        }
        $sth->execute();
        $this->resetValues();
        return $sth->rowCount();
    }

    private function resetValues()
    {
        $this->wheres = "";
        $this->sql = null;
    }

}