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
          Schema::table('posts', function (Blueprint $table) {
                $table->timestamps();
        });
           Schema::table('tags', function (Blueprint $table) {
                  $table->timestamps();
        });
            Schema::table('posts_tags', function (Blueprint $table) {
                  $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
