<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Tripdata extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
        'speed',
        'engine_rpm',
        'engine_load',
        'ambiant_temp',
        'throttle_pos',
        'inst_fuel',
        'zone',
        'place',
        'created_at',
        'user_id',
        'sensor'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
