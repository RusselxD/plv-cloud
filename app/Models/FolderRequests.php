<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolderRequests extends Model
{
    public $timestamps = false; 

    protected $casts = [
        'created_at' => 'datetime',
    ];
    
    public function folder(){
        return $this->belongsTo(Folder::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
