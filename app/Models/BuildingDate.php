<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BuildingDate extends Model
{
    use HasTranslations;

    public $translatable = [
        'category',
        'note',
    ];

    public function __toString()
    {
        $result = "{$this->from}";
        if ($this->from != $this->to) $result .= " – {$this->to}";
        if ($this->note) $result .= " ({$this->note})";
        return $result;
    }
}
