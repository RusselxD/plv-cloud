<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function folderContributors(){
        return $this->hasMany(FolderContributors::class);
    }

    public function folderRequests(){
        return $this->hasMany(FolderRequests::class);
    }
}
