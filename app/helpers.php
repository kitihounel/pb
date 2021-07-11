<?php

use Illuminate\Support\Str;

/**
 * Convert an array keys from snakecase to camelcase.
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
