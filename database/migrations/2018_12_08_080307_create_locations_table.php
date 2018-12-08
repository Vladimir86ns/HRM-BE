<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->string('name');
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('country');
            $table->string('region');
            $table->string('city');
            $table->integer('zip_code');
            $table->string('first_address_line');
            $table->string('second_address_line');
            $table->integer('is_headquarters')->boolean()->default(false);
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')->on('companies')
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
        Schema::dropIfExists('locations');
    }
}
