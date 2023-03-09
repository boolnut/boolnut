<?php
namespace Boolnut\Core\Inc;

class Helper
{
    public static function makeDir($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    public static function capitalizedCase($string)
    {
        return mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    }

    public static function camelCase($string)
    {
        return lcfirst(self::capitalizedCase($string));
    }

    public static function snakeCase($string)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }

    public static function kebabCase($string)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $string));
    }

    public static function lowerCase($string)
    {
        return strtolower($string);
    }


}