<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
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

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}