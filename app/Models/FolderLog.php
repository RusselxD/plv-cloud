<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolderLog extends Model
{
    protected $fillable = ['folder_id', 'details', 'user_id'];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
