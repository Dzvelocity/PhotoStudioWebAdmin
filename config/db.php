
<?php
class Database {
    private static $connection = null;

    public static function getConnection() {
        if (self::$connection === null) {
            $host = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'photo_studio';

            self::$connection = new mysqli($host, $username, $password, $database);

            if (self::$connection->connect_error) {
                die('Database connection failed: ' . self::$connection->connect_error);
            }
        }
        return self::$connection;
    }

    private function __construct() {}
}
?>