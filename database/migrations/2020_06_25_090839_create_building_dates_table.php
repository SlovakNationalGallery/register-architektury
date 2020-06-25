<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_dates', function (Blueprint $table) {
            $table->id();
            $table->integer('source_id')->unique();
            $table->foreignId('building_id')->constrained()->onDelete('cascade');

            $table->smallInteger('from');
            $table->smallInteger('to');
            $table->json('category');
            $table->json('note');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('building_dates');
    }
}
