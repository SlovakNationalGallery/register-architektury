<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BuildingTest extends TestCase
{
    public function testDetailUrl()
    {
        $building = factory(\App\Models\Building::class)->create();
        $url = route('building.detail', [$building->id, $building->slug]);
        $response = $this->get($url);

        $response->assertStatus(200);
    }

    public function testDetailUrlRedirectOnFakeSlug()
    {
        $building = factory(\App\Models\Building::class)->create();
        $url = route('building.detail', [$building->id, 'fake-slug']);
        $response = $this->get($url);

        $response->assertStatus(302);
    }
}
