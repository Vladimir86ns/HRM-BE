<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('account_id');
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('email');
            $table->string('website')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('telephone_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->timestamps();

            $table->foreign('country_id')
                ->references('id')->on('countries')
                ->onDelete('cascade');

            $table->foreign('account_id')
                ->references('id')->on('accounts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
