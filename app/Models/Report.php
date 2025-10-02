<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
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

    public function reportedFile()
    {
        return $this->belongsTo(File::class, 'reported_file_id');
    }

    public function reportedFolder()
    {
        return $this->belongsTo(Folder::class, 'reported_folder_id');
    }
}