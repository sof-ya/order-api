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
        Schema::create('order_worker', function (Blueprint $table) {
            $table->string("order_id")->comment("Идентификатор заказа");
            $table->string("worker_id")->comment("Идентификатор исполнителя");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_worker');
    }
};
