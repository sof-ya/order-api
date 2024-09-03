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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('type_id')->unsigned()->comment("Тип заказа из таблицы order_types");
            $table->integer('partnership_id')->unsigned()->comment("Индентификатор компании, от лица которой создан заказ");
            $table->integer('user_id')->unsigned()->comment("Индентификатор пользователя, создавшего заказ");
            $table->text("description")->comment("Описание заказа");
            $table->date('date')->comment('Дата заказа');
            $table->string('address')->comment('Адрес выполнения заказа');
            $table->integer('amount')->comment('Стоимость заказа');
            $table->enum('status', ['Создан', 'Назначен исполнитель', 'Завершен'])->comment('Статус заказа');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
