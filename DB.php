<?php

class DB
{
    protected $pdo;

    public function __construct($dbConfigPath='config/parameters.ini')
    {
        if (!($pdoConfig = parse_ini_file($dbConfigPath))) {
            throw new Exception("Ошибка парсинга файла инициализации бд", 1);
        }

        try {
            $this->pdo = new PDO('mysql:host='.$pdoConfig['host'].';dbname='.$pdoConfig['dbname'],
            $pdoConfig['login'], 
            $pdoConfig['password']);
        } catch (PDOException $e) {
            echo "Ошибка подключения к БД: " . $e->getMessage();
            die();
        }
    }

    public function getDBHandler()
    {
        return $this->pdo;
    }
}