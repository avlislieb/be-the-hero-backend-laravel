<?php

namespace Tests\Feature\Controller;

use App\Models\Incidents;
use App\Models\Ongs;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncidentsControllerTest extends TestCase
{
    /**
     * @test
     */
    public function can_create_incidents()
    {
        $faker = Factory::create();

        $id = '';

        $ongid = factory(Ongs::class)->create([
            'id' => $id = substr(uniqid('', true), 15)
        ]);

        $header = ['authorization' => $id];

        $response = $this->postJson('/api/incidents', [
            'title' => $faker->title,
            'description' => $faker->text(200),
            'value' => $faker->randomFloat()
        ], $header);

        $response->assertStatus(200)
            ->assertJsonStructure(['id']);
    }

    /**
     * @test
     */
    public function can_delete_incidents()
    {
        $ong = \factory(Ongs::class)->create([
            'id' => $id = substr(uniqid('', true), 15)
        ]);

        $incidents = \factory(Incidents::class, 3)->create([
            'ong_id' => $id
        ]);

        $response = $this->deleteJson("/api/incidents/{$incidents[2]->id}",
            [],
            ['authorization' => $id]);

        $response->assertStatus(204);
          # dd($incidents->toArray());
        $this->assertSoftDeleted('Incidents', [
            'id' => $incidents->toArray()[2]['id'],
        ]);
    }

    /**
     * @test
     */
    public function can_return_list_incidents()
    {
        $ong = \factory(Ongs::class)->create([
            'id' => $id = Ongs::generateTokenId()
        ]);

        $incidents = \factory(Incidents::class, 5)->create([
            'ong_id' => $id
        ]);

        $response = $this->getJson('/api/incidents?page=1', []);

        $response->assertOk();

    }
}
