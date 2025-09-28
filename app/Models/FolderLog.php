<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolderLog extends Model
{
    public $timestamps = false;

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
