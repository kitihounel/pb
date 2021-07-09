<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'action',
        'user_id',
        'tuple_id' 
    ];

    public static function store($action, $userId, $tupleId = null)
    {
        try {
            self::create([
                'action' => $action,
                'user_id' => $userId,
                'tuple_id' => $tupleId
            ]);
        } catch (\Throwable $th) {
            $format = 'Error while saving log in db: %s - %d. %s';
            $log = sprintf($format, $action, $userId, $th->getMessage());
            error_log($log);
        }
    }
}
