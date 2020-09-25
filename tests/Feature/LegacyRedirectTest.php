<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\RefreshSearchIndex;

class LegacyRedirectTest extends TestCase
{
    // use RefreshDatabase;

    public function testIndexPages()
    {
        $this->assertRedirect('/index.php/sk/', route('home'));
        $this->assertRedirect('/index.php/sk/uvod/kontakt.html', route('about.department'));
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



    private function assertRedirect($from, $to)
    {
        $response = $this->get($from);
        $response->assertRedirect($to);
    }
}
