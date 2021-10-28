<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_department', function (Blueprint $table) {
            $table->foreignId('department_id')->constrained()->onDelete('RESTRICT');
            $table->foreignId('employee_id')->constrained()->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_department', function (Blueprint $table) {
            $table->dropForeign('employee_department_department_id_foreign');
            $table->dropForeign('employee_department_employee_id_foreign');
        });
        Schema::dropIfExists('employee_department');
    }
}
