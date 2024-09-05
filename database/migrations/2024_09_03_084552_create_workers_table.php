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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string("name")->comment("Имя исполнителя");
            $table->string("second_name")->nullable()->comment("Отчество исполнителя");
            $table->string("surname")->comment("Фамилия исполнителя");
            $table->string("phone")->unique()->comment("Номер телефона исполнителя");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
