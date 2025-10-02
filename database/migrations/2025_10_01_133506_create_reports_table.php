<?php

use App\Models\File;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(File::class, 'reported_file_id')->nullable();
            $table->foreignIdFor(Folder::class, 'reported_folder_id')->nullable();
            $table->text('reason');
            $table->boolean('is_acknowledged')->default(false);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};