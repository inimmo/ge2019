<?php
namespace Election;

class ConstituencyData
{
    public static function getConstituencyName(string $code)
    {
        $data = json_decode(file_get_contents(ROOT . 'data/constituencies.json'));

        return $data->hexes->{$code}->n;
    }
}
