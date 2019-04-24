<?php
class ConnectionFactory{
    
    public static $factory;
    public static $db;

    public static function getFactory(){
        if (!isset(self::$factory)){
            self::$factory = new ConnectionFactory();
            //$this->db = null;
        }
        return self::$factory;
    }

    public function getConnection(){
        if (is_null($this->db))
            $this->db = new mysqli('10.162.104.214', 'pguat', 'pguat', 'testSpaysez');
            if ($this->db->connect_error){
                throw new Exception("Connect Error ("
                    . $this->db->connect_errno
                    . ") "
                    . $this->db->connect_error
            );
        }
        return $this->db;
    }

    public function closeConnection(){
       if (!is_null($this->db)){
           $this->db->close();
           $this->db = null;
       }
    }
}

function connect(){
    $conn = ConnectionFactory::getFactory()->getConnection();
    return $conn;
}

