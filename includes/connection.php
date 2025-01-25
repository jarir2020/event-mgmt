<?php

require 'includes/beautify.php';
require 'includes/errors.php';

use includes\beautify\JSON;
use includes\beautify\FILE;
use includes\Errors\Errors;

class DBConfig
{
    private static $connection;
    private static $dbConfig;
    private static $host;
    private static $username;
    private static $password;
    private static $database;

    public static function connect()
    {
        if (!self::$connection) {
            // Load database configuration only once
            if (!self::$dbConfig) {
                self::$dbConfig = JSON::decode(File::getContents('config/database.json'), true);

                // Check if the configuration was loaded correctly
                if (!self::$dbConfig) {
                    Errors::database_configuration_error();
                }
            }

            // Extract database credentials
            self::$host = self::$dbConfig['host'];
            self::$username = self::$dbConfig['username'];
            self::$password = self::$dbConfig['password'];
            self::$database = self::$dbConfig['database'];

            // Create a new MySQLi connection
            self::$connection = new mysqli(self::$host, self::$username, self::$password, self::$database);

            // Check the connection
            if (self::$connection->connect_error) {
                Errors::database_connection_error();
            }
        }

        return self::$connection;
    }
}

$conn = DBConfig::connect();
?>
