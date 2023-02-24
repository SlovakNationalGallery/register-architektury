<?php

namespace App;

use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpstreamStorage
{
    public static function get($sourcePath)
    {
        $storage = Storage::disk(Config('filesystems.upstream'));
        $normalizedPath = Str::of($sourcePath)->replace('\\', '/');

        if (Str::startsWith($normalizedPath, '//AA20/OddArch/AA20 dáta/')) {
            return $storage->get($normalizedPath->replaceFirst('//AA20/OddArch/AA20 dáta/', ''));
        }

        if (Str::startsWith($normalizedPath, 'S:/AA20 dáta/')) {
            return $storage->get($normalizedPath->replaceFirst('S:/AA20 dáta/', ''));
        }

        if (Str::startsWith($normalizedPath, 'S:/AA20/OddArch/AA20 dáta/')) {
            return $storage->get($normalizedPath->replaceFirst('S:/AA20/OddArch/AA20 dáta/', ''));
        }

        throw new Exception("Unrecognized source path $sourcePath");
    }
}
