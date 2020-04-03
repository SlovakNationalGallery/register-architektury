<?php

namespace Tests\Feature;

use App\Jobs\Upstream\ImportAll as ImportAllJob;
use App\Jobs\Upstream\ResetDatabase as ResetDatabaseJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class UpstreamTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDatabaseReset()
    {
        Bus::fake();

        $response = $this->post('/api/sync/reset');
        Bus::assertDispatched(ResetDatabaseJob::class);
        $response->assertStatus(200);
    }

    public function testImportAll()
    {
        Bus::fake();

        $response = $this->post('/api/sync/start');
        Bus::assertDispatched(ImportAllJob::class);
        $response->assertStatus(200);
    }
}
