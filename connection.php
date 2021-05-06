<?php
session_start();

class DB_connect
{
    private static $host = "localhost";
    private static $user = "root";
    private static $pass = "admin";
    private static $db = "blogsite_db";

    private static $conn = null;

    // private final function __construct()
    // {
    //     mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //     $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
    //     if ($this->conn->connect_error) {
    //         echo "Fail" . $this->conn->connect_error;
    //     }
    // }

    public static function getConn()
    {
        if (self::$conn == null) {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            self::$conn = mysqli_connect(self::$host, self::$user, self::$pass, self::$db);
            if (self::$conn->connect_error) {
                echo "Fail" . self::$conn->connect_error;
            }
        }
        return self::$conn;
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
