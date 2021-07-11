<?php

use Illuminate\Support\Str;

/**
 * Convert an array keys to camelcase.
 * 
 * @param  array $arr
 * @return array
 */
function toCamelKeys(array $a)
{
    return array_combine(
        array_map([Str::class, 'camel'], array_keys($a)),
        $a
    );
}

/**
 * Convert an array keys to snakecase.
 * 
 * @param  array $arr
 * @return array
 */
function toSnakeKeys(array $a)
{
    return array_combine(
        array_map([Str::class, 'snake'], array_keys($a)),
        $a
    );
}
