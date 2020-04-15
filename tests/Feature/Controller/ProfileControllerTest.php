<?php

namespace Tests\Feature\Controller;

use App\Models\Incidents;
use App\Models\Ongs;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    /**
     * @test
     */
    public function can_return_list_incidents_of_a_ong()
    {
        $ongOne = factory(Ongs::class)->create([
            'id' => $idOngOne = Ongs::generateTokenId()
        ]);

        $ongTwo = factory(Ongs::class)->create([
            'id' => $idOngTwo = Ongs::generateTokenId()
        ]);

        $incidentsOne = factory(Incidents::class, 5)->create([
            'ong_id' => $idOngOne
        ]);

        $incidentsTwo = factory(Incidents::class, 3)->create([
            'ong_id' => $idOngTwo
        ]);


        #dd($incidentsOne->toArray(), $incidentsTwo->toArray());

        $response = $this->getJson('/api/profile', ['authorization' => $idOngOne]);
        $response->assertOk()->assertJsonCount(5);

        $response = $this->getJson('/api/profile', ['authorization' => $idOngTwo]);
        $response->assertOk()->assertJsonCount(3);

        $response = $this->getJson('/api/profile', ['authorization' => Ongs::generateTokenId()]);
        $response->assertStatus(422);
    }

}
