<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\RefreshSearchIndex;
use Mcamara\LaravelLocalization\LaravelLocalization;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Boot the testing helper traits.
     *
     * @return array
     */
    protected function setUpTraits()
    {
        $uses = parent::setUpTraits();
        if (isset($uses[RefreshSearchIndex::class])) {
            $this->setUpSearchIndexes();
        }
    }

    protected function refreshApplicationWithLocale($locale)
    {
        self::tearDown();
        putenv(LaravelLocalization::ENV_ROUTE_KEY . '=' . $locale);
        self::setUp();
    }

    protected function tearDown(): void
    {
        putenv(LaravelLocalization::ENV_ROUTE_KEY);
        parent::tearDown();
    }
}
