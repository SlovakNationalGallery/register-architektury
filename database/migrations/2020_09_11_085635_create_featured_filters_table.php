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

            $table->json('description')->nullable();
            $table->json('architect_tags')->nullable();
            $table->json('location_tags')->nullable();
            $table->json('function_tags')->nullable();
            $table->json('year_range_tags')->nullable();
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
