<?php

class Connect {
    public $db;
    public $isConnected;
    public static $instance = null;

    public static function getInstance() {
        if (self::$instance == null) self::$instance = new static();
        return self::$instance;
    }

    private function __construct() {
        $this->isConnected = true;
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=movieApp;charset=UTF8','root','pass');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
        }catch(PDOException $e) {
            $this->isConnected = false;
            throw new Exception($e->getMessage());
        }
    }
}