<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class LegacyRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function testRedirectIndexPages()
    {
        // SK
        $this->refreshApplicationWithLocale('sk');
        $this->assertRedirect('/index.php/sk/objekty.html', route('building.index'));
        $this->assertRedirect('/index.php/sk/architekti.html', route('architects.index'));
        $this->assertRedirect('/index.php/sk/lokality.html', route('building.index'));
        $this->assertRedirect('/index.php/sk/chronologia.html', route('building.index'));
        $this->assertRedirect('/index.php/sk/funkcia.html', route('building.index'));
        $this->assertRedirect('/index.php/sk/mapy.html', route('building.index'));

        $this->assertRedirect('/index.php/sk/docomomo.html', route('about.projects.show', 'docomomo'));
        $this->assertRedirect('/index.php/sk/atrium.html', route('about.projects.show', 'atrium'));
        $this->assertRedirect('/index.php/sk/momowo.html', route('about.projects.show', 'momowo'));
        $this->assertRedirect('/index.php/sk/sur.html', route('about.projects.show', 'sur'));
        $this->assertRedirect('/index.php/sk/udalosti.html', route('about.articles.index'));
        $this->assertRedirect('/index.php/sk/tipy.html', route('home'));

        // EN
        $this->refreshApplicationWithLocale('en');
        $this->assertRedirect('/index.php/en/objects.html', route('building.index'));
        $this->assertRedirect('/index.php/en/architects.html', route('architects.index'));
        $this->assertRedirect('/index.php/en/locations-2.html', route('building.index'));
        $this->assertRedirect('/index.php/en/chronology-2.html', route('building.index'));
        $this->assertRedirect('/index.php/en/function-2.html', route('building.index'));
        $this->assertRedirect('/index.php/en/map-google-2.html', route('building.index'));

        $this->assertRedirect('/index.php/en/docomomo-2.html', route('about.projects.show', 'docomomo'));
        $this->assertRedirect('/index.php/en/atrium-22.html', route('about.projects.show', 'atrium'));
        $this->assertRedirect('/index.php/en/momowo.html', route('about.projects.show', 'momowo'));
        $this->assertRedirect('/index.php/en/sur-3.html', route('about.projects.show', 'sur'));

        $this->assertRedirect('/index.php/en/events.html', route('about.articles.index'));
        $this->assertRedirect('/index.php/en/tips.html', route('home'));
    }

    public function testHandleSecondLevelPages()
    {
        // SK
        $this->refreshApplicationWithLocale('sk');
        $this->assertRedirect('/index.php/sk/uvod/kontakt.html', route('about.department'));
        $this->assertRedirect('/index.php/sk/chronologia/anything', route('building.index'));
        $this->assertRedirect('/index.php/sk/funkcia/anything', route('building.index'));
        $this->assertRedirect('/index.php/sk/mapy/anything', route('building.index'));
        $this->assertRedirect('/index.php/sk/docomomo/anything', route('about.projects.show', 'docomomo'));
        $this->assertRedirect('/index.php/sk/atrium/anything', route('about.projects.show', 'atrium'));
        $this->assertRedirect('/index.php/sk/momowo/anything', route('about.projects.show', 'momowo'));
        $this->assertRedirect('/index.php/sk/sur/anything', route('about.projects.show', 'sur'));

        // EN
        $this->refreshApplicationWithLocale('en');
        $this->assertRedirect('/index.php/en/info/kontakt-2.html', route('about.department'));
        $this->assertRedirect('/index.php/en/chronology-2/anything', route('building.index'));
        $this->assertRedirect('/index.php/en/function-2/anything', route('building.index'));
        $this->assertRedirect('/index.php/en/map-google-2/anything', route('building.index'));
        $this->assertRedirect('/index.php/en/docomomo-2/anything', route('about.projects.show', 'docomomo'));
        $this->assertRedirect('/index.php/en/atrium-22/anything', route('about.projects.show', 'atrium'));
        $this->assertRedirect('/index.php/en/momowo/anything', route('about.projects.show', 'momowo'));
        $this->assertRedirect('/index.php/en/sur-3/anything', route('about.projects.show', 'sur'));
    }

    public function testRedirectsToMatchingBuilding()
    {
        $building = factory(\App\Models\Building::class)->create(['title' => 'Existing building']);
        $this->assertRedirect('/index.php/sk/objekty/999-existing-building.html', $building->url);
        $this->assertRedirect('/index.php/en/objects/999-existing-building.html', $building->url);
    }

    public function testSearchesForNonMatchingBuilding()
    {
        $this->assertRedirect('/index.php/sk/objekty/999-non-existing-building.html', route('building.index', ['search' => 'non existing building']));
        $this->assertRedirect('/index.php/en/objects/999-non-existing-building.html', route('building.index', ['search' => 'non existing building']));
    }

    public function testRedirectsToMatchingArchitect()
    {
        $architect = factory(\App\Models\Architect::class)->create([
            'first_name' => 'architect tibor', // Support multiple first-names
            'last_name' => 'existing',
        ]);
        $this->assertRedirect('/index.php/sk/architekti/999-existing-architect-tibor.html', route('architects.show', $architect));
        $this->assertRedirect('/index.php/en/architects/999-existing-architect-tibor.html', route('architects.show', $architect));
    }

    public function testSearchesForNonMatchingArchitect()
    {
        $this->assertRedirect('/index.php/sk/architekti/999-non-existing-architect.html', route('architects.index', ['search' => 'non existing architect']));
        $this->assertRedirect('/index.php/en/architects/999-non-existing-architect.html', route('architects.index', ['search' => 'non existing architect']));
    }

    private function assertRedirect($from, $to)
    {
        // Strip /index.php (because it behaves inconsistently between server and test)
        $from = Str::replaceFirst('/index.php/', '', $from);
        $locale = Str::of($from)->explode('/')->first();

        // Strip /sk/ prefix from expected route
        if ($locale === 'sk') $to = Str::replaceFirst("/$locale", '', $to);

        $response = $this->get($from);
        $response->assertRedirect($to);
    }
}
