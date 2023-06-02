<?php

namespace App\Traits;

trait EnumContract
{
    public static function values()
    {
        return array_column(self::cases(), 'value');
    }

    public static function keys()
    {
        return array_column(self::cases(), 'name');
    }

    public static function keyValue()
    {
        $data = [];
        foreach (self::cases() as $value) {
            $data[$value->name] = $value->value;
        }
        return $data;
    }
}
