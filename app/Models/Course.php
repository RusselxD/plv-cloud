<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function users(){
        return $this->hasMany(User::class);
    }

    public function folders(){
        return $this->hasMany(Folder::class);
    }
}
