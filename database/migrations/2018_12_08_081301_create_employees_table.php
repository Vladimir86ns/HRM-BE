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
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('payroll_group_id')->unsigned()->nullable();
            $table->integer('user_info_detail_id')->unsigned()->nullable();
            $table->string('company_employee_id');
            $table->string('password');
            $table->date('birthdate')->nullable();
            $table->string('telephone_number')->nullable();
            $table->string('mobile_number')->nullable();
            $table->decimal('hours_per_day')->nullable();
            $table->date('date_hired')->nullable();
            $table->date('date_ended')->nullable();
            $table->integer('location_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->decimal('zip_code')->nullable();
            $table->string('first_address_line')->nullable();
            $table->string('second_address_line')->nullable();
            $table->integer('position_id')->unsigned()->nullable();
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
