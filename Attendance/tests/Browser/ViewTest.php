<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ViewTest extends DuskTestCase
{
    /**
     * A Test for the home page.
     *
     * @return void
     */
    public function testClassicSee()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('ESI - ATTENDANCE')
                    ->assertSee('List Présences')
                    ->visit('/presence')
                    ->assertSee('ESI - ATTENDANCE');
        });
    }

    /**
     * A test for the Back and forth navigation.
     *
     * @return void
     */
    public function testRouteBackAndForth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('List Présences')
                    ->assertPathIs('/presence')
                    ->back() // back to home
                    ->assertPathIs('/')
                    ->forward() // forward to presence
                    ->assertPathIs('/presence');

        });
    }
    /**
     * A test for the link to the accueil page.
     *
     * @return void
     */
    public function testClickLinkAccueil()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/presence')
                    ->click('#Accueil')
                    ->assertPathIs('/')
                    ->click('#Accueil')
                    ->assertPathIs('/');
        });
    }

    /**
     * A test for the title of the table in the presence page.
     *
     * @return void
     */
    public function testTable(){
        $this->browse(function (Browser $browser) {
            $browser->visit('/presence')
                    ->with('table', function ($table) {
                $table->assertSee('MATRICULE')
                      ->assertSee('NAME')
                      ->assertSee('SURNAME')
                      ->assertSee('PRESENCE');
            });
        });
    }

    /**
     * A test for the Take Presence button.
     *
     * @return void
     */
    public function testClickButtonTakePresence(){
        $this->browse(function (Browser $browser) {
            $browser->visit('/presence')
                    ->assertSee('Take presence')
                    ->press('#presence')
                    ->waitForText('Success')
                    ->assertSee('Success')
                    ->assertSee('Student presences successfully taken !');

        });
    }
}
