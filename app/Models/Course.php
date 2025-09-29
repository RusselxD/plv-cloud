<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'abbreviation', 'slug'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            $course->slug = Str::slug($course->abbreviation);
        });

        static::updating(function ($course) {
            if ($course->isDirty('abbreviation')) {
                $course->slug = Str::slug($course->abbreviation);
            }
        });
    }
}
