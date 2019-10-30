<?php
namespace Election;

class ConstituencyData
{
    private static $data;

    public static function getConstituencyName(string $code)
    {
        self::initialise();

        return self::$data->hexes->{$code}->n;
    }

    private static function initialise()
    {
        if (isset(self::$data)) {
            return;
        }

        self::$data = json_decode(file_get_contents(ROOT . 'data/constituencies.json'));
    }
}
