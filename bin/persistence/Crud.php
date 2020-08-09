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

    public function update($obj)
    {
        try {
            $fields = "";
            foreach ($obj as $key => $value){
                $fields .= "`$key`=:$key,"; //`names`=:Victorio,`age`=:30
            }
            $fields = rtrim($fields, ",");
            $this->sql = "UPDATE {$this->table} SET {$fields} {$this->wheres}";
            $rowsAffected = $this->execute($obj);
            return $rowsAffected;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function delete(){
        try {
            $this->sql = "DELETE FROM {$this->table} {$this->wheres}";
            $rowsAffected = $this->execute();
            return $rowsAffected;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

    }


    public function where($key, $condition, $value) {
        $this->wheres .= (strpos($this->wheres, "WHERE")) ? " AND " : " WHERE ";
        $this->wheres .= "`$key` $condition " . ((is_string($value)) ? "\"$value\"" : $value) . " ";
        return $this;
    }

    public function orWhere($key, $condition, $value) {
        $this->wheres .= (strpos($this->wheres, "WHERE")) ? " OR " : " WHERE ";
        $this->wheres .= "`$key` $condition " . ((is_string($value)) ? "\"$value\"" : $value) . " ";
        return $this;
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