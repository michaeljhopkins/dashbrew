<?php

namespace Dashbrew\Util;

class Registry {

    protected static $objects = array();

    public static function set($key, $value) {

        self::$objects[$key] = $value;
        return true;
    }

    public static function get($key) {

        if(!isset(self::$objects[$key])){
            return null;
        }

        return self::$objects[$key];
    }

    public static function getAll() {

        return self::$objects;
    }

    public static function check($key) {

        if(isset(self::$objects[$key])){
            return true;
        }

        return false;
    }

    public static function remove($key) {

        if(isset(self::$objects[$key])){
            unset(self::$objects[$key]);
        }
    }
}
