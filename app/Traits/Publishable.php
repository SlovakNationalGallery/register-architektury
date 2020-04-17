<?php

namespace App\Traits;

trait Publishable
{
    public function getIsPublishedAttribute()
    {
        if (!isset($this->published_at)) return false;
        return $this->published_at->isPast();
    }
}
