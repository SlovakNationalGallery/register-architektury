<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait RefreshSearchIndex
{
    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function refreshSearchIndex()
    {
        $this->artisan('regarch:elastic:migrate');
        $this->app[Kernel::class]->setArtisan(null);
    }
}
