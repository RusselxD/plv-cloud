<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Folder extends Model
{
    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function folderContributors()
    {
        return $this->hasMany(FolderContributors::class);
    }

    public function folderRequests()
    {
        return $this->hasMany(FolderRequests::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    public function folderLogs()
    {
        return $this->hasMany(FolderLog::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reported_folder_id');
    }

    public function saves()
    {
        return $this->hasMany(Save::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($folder) {
            $folder->uuid = (string) Str::uuid();
        });
    }
}
