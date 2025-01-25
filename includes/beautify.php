<?php

namespace includes\beautify;

class JSON
{
    public static function decode($jsonString, $assoc = true)
    {
        return json_decode($jsonString, $assoc);
    }

    public static function encode($data, $options = 0)
    {
        return json_encode($data, $options);
    }
}

class FILE
{
    public static function getContents($filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception("File not found: " . $filePath);
        }
        return file_get_contents($filePath);
    }
}
