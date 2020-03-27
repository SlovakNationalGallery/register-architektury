<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->integer('source_id')->unique();

            $table->string('title')->nullable();
            $table->string('title_alternatives')->nullable();
            $table->text('description')->nullable();
            $table->date('processed_date')->nullable();
            $table->string('architect_names')->nullable();
            $table->string('builder')->nullable();
            $table->string('builder_authority')->nullable();
            $table->string('location_city')->nullable();
            $table->string('location_district')->nullable();
            $table->string('location_street')->nullable();
            $table->string('location_gps')->nullable();
            $table->string('project_start_dates')->nullable();
            $table->string('project_duration_dates')->nullable();
            $table->integer('decade')->nullable();
            $table->string('style')->nullable();
            $table->string('status')->nullable();
            $table->string('image_filename')->nullable();
            $table->text('bibliography')->nullable();

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
        Schema::dropIfExists('buildings');
    }
}
