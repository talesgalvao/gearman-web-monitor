<?php

class database extends PDO{

        private static $handle;
        
        public function __construct()
        {
            if (!self::$handle)
            {
                self::$handle = $this->connect();
            }
        }
        
        public function connect()
        {
                $db_config['host']              = "localhost";
                $db_config['user']              = "root";
                $db_config['password']          = "01017ccf";
                $db_config['name']              = "qa";
                $db_config['type']              = "mysql";
                
                if(self::$handle == NULL){
                    try {
                        self::$handle = new PDO($db_config['type'].':host='.$db_config['host'].';port=3306;dbname='.$db_config['name'].";charset=utf8", $db_config['user'], $db_config['password'], array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" ));
                        self::$handle->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
                    }catch (PDOException $e){
                        echo "Error: " . $e->getMessage();
                        die();
                    }
                }

                
                return self::$handle;
        }
        
        public function disconnect()
        {
                self::$handle = NULL;
        }

        public function insert($table = NULL, $params = NULL)
        {
            $columnString   = implode(',', array_keys($params));
            $valueString    = implode(',', array_fill(0, count($params), '?'));

            $stdm = self::$handle->prepare("INSERT INTO {$table} ({$columnString}) VALUES ({$valueString})");
            $stdm->execute(array_values($params));
            echo "<pre>";print_r($stdm->errorInfo());exit;
        }
}

