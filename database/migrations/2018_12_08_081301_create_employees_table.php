<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('payroll_group_id')->unsigned();
            $table->integer('user_info_detail_id')->unsigned();
            $table->string('company_employee_id');
            $table->date('birthdate')->nullable();
            $table->integer('telephone_number')->nullable();
            $table->integer('mobile_number')->nullable();
            $table->decimal('hours_per_day');
            $table->date('date_hired');
            $table->date('date_ended')->nullable();
            $table->integer('location_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->string('country');
            $table->string('region');
            $table->string('city');
            $table->decimal('zip_code');
            $table->string('first_address_line');
            $table->string('second_address_line');
            $table->integer('position_id')->unsigned();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_info_detail_id')->references('id')->on('user_info_details')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
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
