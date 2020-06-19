<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\RefreshSearchIndex;

class ArchitectTtest extends TestCase
{
    use RefreshDatabase;
    use RefreshSearchIndex;

    public function testIndex()
    {
        $response = $this->get(route('architects.index'));
        $response->assertStatus(200);
    }
}
