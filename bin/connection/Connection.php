<?php

class Connection
{
    private $connection;
    private $setting = [
        "driver" => "mysql",
        "host" => "localhost",
        "database" => "project1",
        "port" => "3306",
        "username" => "root",
        "password" => "secret",
        "charset" => "utf8mb4",
    ];

    /**
     * @return mixed
     */
    /**
     * @return mixed
     */
    public function __construct()
    {

    }

    public function connect()
    {
        try {
            $CONTROLLER = $this->setting["driver"];
            $SERVER     = $this->setting["host"];
            $DATABASE   = $this->setting["database"];
            $PORT       = $this->setting["port"];
            $USER       = $this->setting["username"];
            $PASSWORD   = $this->setting["password"];
            $CODING     = $this->setting["charset"];

            $url = "{$CONTROLLER}:host={$SERVER}:{$PORT};"
                . "dbname={$DATABASE};charset={$CODING}";
            // Create connection
            $this->connection = new PDO($url, $USER, $PASSWORD);
            return $this->connection;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}