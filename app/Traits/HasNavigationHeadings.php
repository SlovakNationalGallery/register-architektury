<?php

namespace App\Traits;

use Illuminate\Support\Str;
use PHPHtmlParser\Dom;

trait HasNavigationHeadings
{
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

    private function findHeadingsForNavigation($dom)
    {
        return $dom->find('h1,h2,h3');
    }
}
