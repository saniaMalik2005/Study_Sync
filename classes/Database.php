<?php
require_once __DIR__ . '/../config/database.php';

class Database
{
    // Ekbar connection khule sob jaygay seta-i use hobe
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $dsn = "mysql:host=" . DB_HOST
                 . ";port=" . DB_PORT
                 . ";dbname=" . DB_NAME
                 . ";charset=" . DB_CHARSET;

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // error hole exception dibe
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // data array hishebe ashbe
                PDO::ATTR_EMULATE_PREPARES   => false,                   // asol prepared statement
            ];

            try {
                self::$connection = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                // Asol error file e jabe, user ke friendly message dekhabe
                error_log($e->getMessage());
                die("Something went wrong. Please try again later.");
            }
        }

        return self::$connection;
    }
}