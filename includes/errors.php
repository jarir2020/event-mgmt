<?php
namespace includes\Errors;

class Errors
{
    public static function database_configuration_error()
    {
        die("Failed to load database configuration.");
    }

    public static function database_connection_error()
    {
        die("Connection failed: " . $conn->connect_error);
    }
}
?>
