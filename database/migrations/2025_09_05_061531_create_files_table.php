<?php

use App\Models\Course;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('storage_path');
            $table->string('file_size');
            $table->string('mime_type');
            $table->integer('download_count')->default(0);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Folder::class)->nullable();
            $table->foreignIdFor(Course::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
