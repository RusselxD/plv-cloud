<?php

use App\Models\Course;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->boolean('is_public');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Course::class)->nullable();
            $table->foreignIdFor(Folder::class, 'parent_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('folders');
    }
};
