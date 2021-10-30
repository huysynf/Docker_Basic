<?php

define('USER_NAME', 'root');
define('HOST', 'mysql');
define('PASSWORD', 'root');
define('DB_NAME', 'test');

class Connect
{
    protected $database;
    protected $password;
    protected $host;
    protected $userName;
    private $connect;
    static protected $instance;

    protected function __construct()
    {
        $this->userName = USER_NAME;
        $this->password = PASSWORD;
        $this->host = HOST;
        $this->database = DB_NAME;
        $this->connect = new PDO(
            "mysql:host=$this->host;dbname=$this->database;charset=utf8",
            $this->userName,
            $this->password
        );
    }

    static public function getInstance()
    {
        if (!self::$instance) { // If no instance then make one
            self::$instance = new Connect();
        }
        return self::$instance;
    }

    public function connectDB()
    {
        return $this->connect;
    }
}

class Database
{
    protected $connect;

    protected $sql;

    public function __construct()
    {
        $this->connect = Connect::getInstance()->connectDB();
    }

    public function executeSql($sql)
    {
        $this->setSql($sql);
        $result = $this->connect->prepare('SELECT * from users');
        $result->setFetchMode(PDO::FETCH_OBJ);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_OBJ);;
    }

    public function getSql()
    {
        return $this->sql;
    }

    public function setSql($sql)
    {
        return $this->sql = $sql;
    }
}
