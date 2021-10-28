<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255)->comment('Имя');
            $table->string('middle_name', 255)->comment('Отчество');
            $table->string('last_name', 255)->comment('Фамилия');
            $table->unsignedTinyInteger('gender')->default(0)->comment('Пол/род');
            $table->unsignedBigInteger('salary')->comment('Зарплата (целое число)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
