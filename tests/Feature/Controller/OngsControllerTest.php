<?php

namespace Tests\Feature\Controller;

use App\Models\Ongs;
use Tests\TestCase;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OngsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_create_a_ong()
    {
        //Given
            //user is authenticated
        $faker = Factory::create();

        $response = $this->json('POST', '/api/ongs', [
            'name' => $name =   $faker->company ,
            'email' => $email  = $faker->companyEmail,
            'whatsapp' => $wpp =  $faker->e164PhoneNumber,
            'city' => $city =  $faker->city,
            'uf' => $uf = $faker->stateAbbr
        ]);

        $response->assertJsonStructure([
            'id'
        ])->assertStatus(201);
    }

    /**
     * @test
     */
    public function can_return_list_ongs()
    {

        $ong  = factory(Ongs::class)->create();

        $reponse = $this->getJson('/api/ongs')
            ->assertStatus(200)
            ->assertJsonStructure([
             '*' => [
                 'id',
                 'name',
                 'email',
                 'whatsapp',
                 'city',
                 'uf',
                 'deleted_at',
                 'created_at',
                 'updated_at'
             ]
        ]);

    }

}
