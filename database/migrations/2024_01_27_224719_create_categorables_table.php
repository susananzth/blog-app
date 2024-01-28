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
        Schema::create('categorables', function (Blueprint $table) {
            $table->bigInteger('category_id');
            $table->morphs('categorable');
            $table->timestamps();

            $table->unique(['category_id', 'categorable_type', 'categorable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorables');
    }
};
