<?php
session_start();

class DB_connect
{
    private static $host = "localhost";
    private static $user = "root";
    private static $pass = "";
    private static $db = "blogsite_db";

    private static $conn = null;

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
