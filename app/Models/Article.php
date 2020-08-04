<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Traits\Publishable;

class Article extends Model
{
    use CrudTrait, HasSlug, Publishable, HasTranslations;

    protected $guarded = ['id'];
    protected $dates = ['published_at'];
    protected $translatable = ['title', 'content'];

    public function getContentHtmlAttribute()
    {
        $dom = new Dom;
        $dom->loadStr($this->content);

        foreach($this->findHeadingsForNavigation($dom) as $index => $heading) {
            $heading->setAttribute('id', Str::slug($heading->text) . "-$index");
        }

        return $dom;
    }

    public function getNavigationHeadingsAttribute()
    {
        $dom = new Dom;
        $dom->loadStr($this->content);

        return collect($this->findHeadingsForNavigation($dom))
            ->map(fn ($heading, $index) => (object) [
                'text' => $heading->text,
                'href' => '#' . Str::slug($heading->text) . "-$index",
            ]);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    private function findHeadingsForNavigation($dom)
    {
        return $dom->find('h1,h2,h3');
    }
}
