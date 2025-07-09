<?php

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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignUuid('user_id')->references('uuid')->on('users')->nullOnDelete();
            $table->foreignUuid('category_id')->references('uuid')->on('categories')->nullOnDelete();
            $table->string('image')->nullable();
            $table->string('title', 255);
            $table->enum('status', ['draft', 'publish'])->default('draft');
            $table->integer('view_total')->default(0);
            $table->text('content_body')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
