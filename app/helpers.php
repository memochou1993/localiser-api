<?php

use Hashids\Hashids;
use Illuminate\Support\Str;

if (! function_exists('hash_id')) {
    function hash_id($salt_suffix = '')
    {
        $length = 6;
        $key = Str::of(config('app.key'))->substr(7, $length);
        $salt = sprintf("%s_%s", $key, $salt_suffix);
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return new Hashids($salt, $length, $alphabet);
    }
}
