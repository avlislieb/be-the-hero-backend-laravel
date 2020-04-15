<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Ongs;

class SessionControllerTest extends TestCase
{
    /**
     * @test
     */
    public function can_create_session_on_a_ong()
    {
        $ongs = factory(Ongs::class)->create([
            'id' => $id = substr(uniqid('', true), 15)
        ]);

        $response = $this->postJson('/api/session',[
            'id' => $id
        ]);

        $response->assertStatus(200)
            ->assertJson(['name' => $ongs->name]);

    }
}
