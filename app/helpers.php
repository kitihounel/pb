<?php

use \Illuminate\Http\Request;
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

/**
 * Handle a simple restful controller index request.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param string  $className  Eloquent model class
 * @param array  $options  Options
 * @return array
 */ 
function apiControllerIndex(Request $request, string $className, array $options)
{
    $page = $request->query('page');
    if ($page && !preg_match('/^[1-9][\d]*$/', $page))
        abort(400);
    
    $instance = new $className;
    if (array_key_exists('sort', $options)) {
        foreach ($options['sort'] as $column => $order) {
            $instance->orderBy($column, $order);
        }
    }
    $paginator = $instance->paginate();

    return toCamelKeys($paginator->toArray());
}
