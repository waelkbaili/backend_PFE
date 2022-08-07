<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_start',
        'date_end',
        'vin',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
