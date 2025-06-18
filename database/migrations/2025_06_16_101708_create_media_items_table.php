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
        Schema::create('media_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); 
            $table->enum('type', ['file', 'folder']);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('path')->nullable(); 
            $table->string('mime_type')->nullable(); 
            $table->unsignedBigInteger('size')->default(0)->comment('Sizee in kilobytes');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('parent_id')
                  ->references('id')
                  ->on('media_items')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_items');
    }
};
