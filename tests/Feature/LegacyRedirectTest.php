<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\RefreshSearchIndex;

class LegacyRedirectTest extends TestCase
{
    use RefreshDatabase;
    use RefreshSearchIndex;

    public function tesHandleIndexPages()
    {
        $this->assertRedirect('/index.php/sk/', route('home'));
        $this->assertRedirect('/index.php/sk/objekty.html', route('building.index'));
        $this->assertRedirect('/index.php/sk/lokality.html', route('building.index'));
        $this->assertRedirect('/index.php/sk/architekti.html', route('architects.index'));
        $this->assertRedirect('/index.php/sk/chronologia.html', route('building.index'));
        $this->assertRedirect('/index.php/sk/funkcia.html', route('building.index'));
        $this->assertRedirect('/index.php/sk/mapy.html', route('building.index'));
        $this->assertRedirect('/index.php/sk/docomomo.html', route('about.projects.show', 'docomomo'));
        $this->assertRedirect('/index.php/sk/atrium.html', route('about.projects.show', 'atrium'));
        $this->assertRedirect('/index.php/sk/momowo.html', route('about.projects.show', 'momowo'));
        $this->assertRedirect('/index.php/sk/sur.html', route('about.projects.show', 'sur'));
        $this->assertRedirect('/index.php/sk/udalosti.html', route('about.articles.index'));
        $this->assertRedirect('/index.php/sk/tipy.html', route('home'));

        $this->assertRedirect('/index.php/sk/anything-else', route('home'));
    }

    public function testHandleSecondLevelPages()
    {
        $this->assertRedirect('/index.php/sk/uvod/kontakt.html', route('about.department'));
        $this->assertRedirect('/index.php/sk/chronologia/anything', route('building.index'));
        $this->assertRedirect('/index.php/sk/funkcia/anything', route('building.index'));
        $this->assertRedirect('/index.php/sk/mapy/anything', route('building.index'));
        $this->assertRedirect('/index.php/sk/docomomo/anything', route('about.projects.show', 'docomomo'));
        $this->assertRedirect('/index.php/sk/atrium/anything', route('about.projects.show', 'atrium'));
        $this->assertRedirect('/index.php/sk/momowo/anything', route('about.projects.show', 'momowo'));
        $this->assertRedirect('/index.php/sk/sur/anything', route('about.projects.show', 'sur'));
    }

    public function testRedirectsToMatchingBuilding()
    {
        $building = factory(\App\Models\Building::class)->create(['title' => 'Existing building']);
        $this->assertRedirect('/index.php/sk/objekty/999-existing-building.html', $building->url);
    }

    public function testSearchesForNonMatchingBuilding()
    {
        $this->assertRedirect('/index.php/sk/objekty/999-non-existing-building.html', route('building.index', ['search' => 'non existing building']));
    }

    public function testRedirectsToMatchingArchitect()
    {
        $architect = factory(\App\Models\Architect::class)->create([
            'first_name' => 'architect tibor', // Support multiple first-names
            'last_name' => 'existing',
        ]);
        $this->assertRedirect('/index.php/sk/architekti/999-existing-architect-tibor.html', route('architects.show', $architect));
    }

    public function testSearchesForNonMatchingArchitect()
    {
        $this->assertRedirect('/index.php/sk/architekti/999-non-existing-architect.html', route('architects.index', ['search' => 'non existing architect']));
    }

    private function assertRedirect($from, $to)
    {
        $response = $this->get($from);
        $response->assertRedirect($to);
    }
}
