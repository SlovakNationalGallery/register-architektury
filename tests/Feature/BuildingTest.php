<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\RefreshSearchIndex;

class BuildingTest extends TestCase
{
    use RefreshDatabase;

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
        $fake_url = route('building.detail', [$building->id, 'fake-slug']);
        $response = $this->get($fake_url);
        $response->assertRedirect($building->url);
    }

    public function testIndex()
    {
        $response = $this->get(route('building.index'));
        $response->assertStatus(200);
    }

}
