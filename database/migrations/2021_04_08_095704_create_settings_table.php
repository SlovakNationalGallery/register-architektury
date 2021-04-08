<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->json('menu_item_1_title');
            $table->json('menu_item_2_title');
            $table->json('menu_item_3_title');
            $table->json('menu_item_4_title');
            $table->foreignId('menu_item_1_project_id')->nullable()->constrained('projects');
            $table->foreignId('menu_item_2_project_id')->nullable()->constrained('projects');
            $table->foreignId('menu_item_3_project_id')->nullable()->constrained('projects');
            $table->foreignId('menu_item_4_project_id')->nullable()->constrained('projects');

            $table->timestamps();
        });

        $projects = DB::table('projects')
            ->select('id','slug')
            ->whereIn('slug', [
                'docomomo',
                'unintended-city-architectural-and-town-planning-conceptions-of-19th-and-20th-century-in-the-urban-structure-of-bratislava',
                'momowo',
                'sur'
              ])
            ->get();

        DB::table('settings')->insert([
            'menu_item_1_title' => json_encode(['sk' => 'Do.co,mo.mo']),
            'menu_item_2_title' => json_encode(['sk' => '(Ne)plánovaná Bratislava', 'en' => '(Un)planned City']),
            'menu_item_3_title' => json_encode(['sk' => 'MoMoWo']),
            'menu_item_4_title' => json_encode(['sk' => 'ŠUR']),
            'menu_item_1_project_id' => $projects->firstWhere('slug', 'docomomo')->id ?? null,
            'menu_item_2_project_id' => $projects->firstWhere('slug', 'unintended-city-architectural-and-town-planning-conceptions-of-19th-and-20th-century-in-the-urban-structure-of-bratislava')->id ?? null,
            'menu_item_3_project_id' => $projects->firstWhere('slug', 'momowo')->id ?? null,
            'menu_item_4_project_id' => $projects->firstWhere('slug', 'sur')->id ?? null,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
