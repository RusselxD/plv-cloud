<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    public $timestamps = false; 

    protected $casts = [
        'created_at' => 'datetime',
    ];
    
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
