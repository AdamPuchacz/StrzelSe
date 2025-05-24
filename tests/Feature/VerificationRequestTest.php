<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class VerificationRequestTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_user_can_submit_verification_request()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/verification-request', [
            'first_name' => 'Jan',
            'last_name' => 'Nowak',
            'phone' => '123456789',
            'region' => 'Sosnowiec',
        ]);

        $response->assertRedirect('/verification-request');

        $this->assertDatabaseHas('verification_requests', [
            'user_id' => $user->id,
            'first_name' => 'Jan',
            'region' => 'Sosnowiec',
        ]);
    }
}
