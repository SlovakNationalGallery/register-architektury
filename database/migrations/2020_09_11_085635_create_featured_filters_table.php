<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturedFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_filters', function (Blueprint $table) {
            $table->id();

            $table->json('description');
            $table->json('architects');
            $table->json('locations');
            $table->json('functions');
            $table->json('year_ranges');
            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('featured_filters');
    }
}
