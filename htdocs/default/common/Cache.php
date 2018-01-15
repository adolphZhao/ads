<?php

namespace Common;

class Cache {
    private static function filePath() 
    {
        $path = dirname(dirname(__FILE__)) . '/data/';
        if(!is_dir($path)) {
            mkdir($path);
        }
        return $path;
    }
    
    public static function get($key) 
    {
        $filename = self::filePath() . $key;
        if(is_file($filename)) {
            return @unserialize(file_get_contents($filename));
        }
        return null;
    }
    
    public static function set($key, $value) 
    {
        $filename = self::filePath() . $key;
        file_put_contents($filename, serialize($value));
        return true;
    }

    public static function drop($key)
    {
        $filename = self::filePath() . $key;
        @unlink($filename);
        return true;
    }

    public static function isExpired($key, $expire=31536000)
    {
        $filename = self::filePath() . $key;
        if(!is_file($filename)) {
            return true;
        }
        clearstatcache();
        $fmt = filemtime( $filename );
        $now = time();

        if(($now-$fmt)>$expire){
            return true;
        }
        return false;
    }
}