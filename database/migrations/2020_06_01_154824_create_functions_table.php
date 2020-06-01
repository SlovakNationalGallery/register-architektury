<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('functions', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->timestamps();
        });

        Schema::table('buildings', function ($table) {
            $table->integer('current_function_id')->after('status');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buildings', function ($table) {
            $table->dropColumn('current_function_id');
        });

        Schema::dropIfExists('functions');
    }
}
