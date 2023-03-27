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
        Schema::create('customerlist', function (Blueprint $table) {
            $table->id();
            $table->string('plate_name');
            $table->string('plate_code');
            $table->string('driver');
            $table->integer('id_no');
            $table->integer('phone');
            $table->string('company');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customerlist');
    }
};
