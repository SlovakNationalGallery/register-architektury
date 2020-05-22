<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSourcePathAndPathToImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('images')->whereNull('source')->delete();

        Schema::table('images', function ($table) {
            $table->string('source')->nullable(false)->change();
            $table->string('path')->after('source')->nullable();
            $table->renameColumn('source', 'source_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function ($table) {
            $table->renameColumn('source_path', 'source');
            $table->dropColumn('path');
            $table->string('source_path')->nullable()->change();
        });
    }
}
