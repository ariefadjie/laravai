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
        Schema::create('embedding_chunks', function (Blueprint $table) {
            $table->uuid('guid')->primary();
            $table->uuid('embedding_guid');
            $table->longText('text');
            $table->timestamps();

            $table->foreign('embedding_guid')->references('guid')->on('embeddings')->onDelete('cascade');
        });

        DB::statement("ALTER TABLE embedding_chunks ADD vector vector;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embeddings');
    }
};
