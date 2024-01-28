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
        Schema::create('taggeables', function (Blueprint $table) {
            $table->bigInteger('tag_id');
            $table->morphs('taggeable');
            $table->timestamps();

            $table->unique(['tag_id', 'taggeable_type', 'taggeable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taggeables');
    }
};
