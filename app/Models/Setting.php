<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Setting extends Model {
    use CrudTrait, HasTranslations;

    protected $fillable = [
        'menu_item_1_title',
        'menu_item_2_title',
        'menu_item_3_title',
        'menu_item_4_title',
        'menu_item_1_project_id',
        'menu_item_2_project_id',
        'menu_item_3_project_id',
        'menu_item_4_project_id',
    ];

    protected $translatable = [
        'menu_item_1_title',
        'menu_item_2_title',
        'menu_item_3_title',
        'menu_item_4_title',
    ];

    protected static function booted()
    {
        static::updated(function () {
            Cache::forget('settings.current');
            Cache::forget('settings.menu_projects');
        });
    }

    public static function menuItems()
    {
        $setting = Cache::rememberForever('settings.current', function () {
            return self::first();
        });

        return $setting->getMenuItems();
    }

    private function getMenuItems()
    {
        $featuredProjects = Cache::rememberForever('settings.menu_projects', function () {
            return Project::whereIn('id', [
                $this->menu_item_1_project_id,
                $this->menu_item_2_project_id,
                $this->menu_item_3_project_id,
                $this->menu_item_4_project_id,
            ])->get();
        });

        return Collection::times(4, function ($number) use ($featuredProjects) {
            $projectId = $this->{"menu_item_{$number}_project_id"};
            $project = $featuredProjects->firstWhere('id', $projectId);

            return (object) [
              'title' => $this->{"menu_item_" . $number . "_title"},
              'project_id' => $project->id ?? null,
              'project_slug' => $project->slug ?? null,
              'project_title' => $project->title ?? null,
            ];
        });
    }
}
