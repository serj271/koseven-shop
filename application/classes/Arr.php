<?php defined('SYSPATH') or die('No direct script access.');

class Arr extends Kohana_Arr {

    public static function to_object(array $array, $class = 'stdClass')
    {
        $object = new $class;
        foreach ($array as $key => $value)
        {
                if (is_array($value))
                {
                // Convert the array to an object
                        $value = arr::to_object($value, $class);
                }
                // Add the value to the object
                $object->{$key} = $value;
        }
        return $object;
    }
}