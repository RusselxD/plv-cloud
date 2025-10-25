<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Notifiable;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function sentNotifications()
    {
        return $this->hasMany(Notification::class, 'sender_id');
    }

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    public function folderContributors()
    {
        return $this->hasMany(FolderContributors::class);
    }

    public function folderRequests()
    {
        return $this->hasMany(FolderRequests::class);
    }

    public function folderLogs()
    {
        return $this->hasMany(FolderLog::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function userActivities()
    {
        return $this->hasMany(UserActivity::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function saves()
    {
        return $this->hasMany(Save::class);
    }
}