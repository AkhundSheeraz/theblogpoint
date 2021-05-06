<?php
session_start();

class DB_connect
{
    protected $host = "localhost";
    protected $user = "root";
    protected $pass = "admin";
    protected $db = "blogsite_db";

    public $conn = null;

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->conn = mysqli_connect($this->host,$this->user,$this->pass,$this->db);
        if($this->conn->connect_error){
            echo "Fail". $this->conn->connect_error;
        }
    }
}



// $host = "localhost";
// $user = "root";
// $pass = "admin";
// $db = "blogsite_db";

// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// $conn = new mysqli($host, $user, $pass, $db);

// if ($conn->connect_error) {
//     die("connection failed: " . $conn->connect_error);
// }
