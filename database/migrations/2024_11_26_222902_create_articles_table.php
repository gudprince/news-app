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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('author')->nullable(); //some api has many authors whick makes the string longer
            $table->string('source_name')->nullable();
            $table->string('article_url')->nullable();
            $table->text('image_url')->nullable(); //some api has longer string for image path
            $table->timestamp('published_at')->nullable();
            $table->string('slug');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
