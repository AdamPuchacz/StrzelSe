<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Competition;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompetitionTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    use RefreshDatabase;
    public function test_it_detects_when_competition_is_full()
    {
        $organizer = User::factory()->create();

        $competition = Competition::factory()->create([
            'max_participants' => 3,
            'created_by' => $organizer->id,
        ]);

        $participants = User::factory()->count(3)->create();
        $competition->participants()->attach($participants->pluck('id'));

        $this->assertTrue($competition->fresh()->isFull());
    }

    public function test_it_detects_when_competition_is_not_full()
    {
        $organizer = User::factory()->create();

        $competition = Competition::factory()->create([
            'max_participants' => 3,
            'created_by' => $organizer->id,
        ]);

        $participants = User::factory()->count(2)->create();
        $competition->participants()->attach($participants->pluck('id'));

        $this->assertFalse($competition->fresh()->isFull());
    }
}
