<?php

use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('folder_contributors', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Folder::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('folder_contributors');
    }
};
