<?php
require "connect.php";

class Service
{
    static $conn;

    static function _connect($dbservername,$dbusername,$dbname,$dbpass) {
        
        self::$conn = new mysqli($dbservername,$dbusername,$dbname,$dbpass);

      
        if (self::$conn->connect_error){ 
        die("Fatal Error".self::$conn->connect_error);
        }
    }

}
