<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class AuctionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function create_auction_with_missing_fields() {
        $this->post('/api/auction')->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function create_auction() {
        $user = $this->user();
        $this->actingAs($user);
        $response = $this->post('/api/auction', [
            "car" => [
                "vin" => "ABCDEFGHKLOIYSLKH",
                "make" => "Hyundai",
                "model" => "Tuscon",
                "year" => 2013,
                "body" => "wagon",
                "odometer" => 130000
            ],
            "start_price" => "800",
            "bid_increment" => "100"
        ]);
        $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson([
            "car" => [
                "vin" => "ABCDEFGHKLOIYSLKH",
                "make" => "Hyundai",
                "model" => "Tuscon",
                "style" => null,
                "year" => 2013,
                "seats" => null,
                "doors" => null,
                "engine" => null,
                "transmission" => null,
                "body" => "wagon",
                "interior_color" => null,
                "exterior_color" => null,
                "odometer" => 130000
            ],
            "created_by" => $user->id,
            "start_price" => "800",
            "bid_increment" => "100",
            "as_is" => false
        ]);
        $this->assertDatabaseHas('cars', [
           "vin" =>  "ABCDEFGHKLOIYSLKH"
        ]);

        $this->get('/api/auctions')->assertJson([
            [
                "car" => [
                    "vin" => "ABCDEFGHKLOIYSLKH",
                    "make" => "Hyundai",
                    "model" => "Tuscon",
                    "style" => null,
                    "year" => 2013,
                    "seats" => null,
                    "doors" => null,
                    "engine" => null,
                    "transmission" => null,
                    "body" => "wagon",
                    "interior_color" => null,
                    "exterior_color" => null,
                    "odometer" => 130000
                ],
                "created_by" => $user->id,
                "start_price" => "800",
                "bid_increment" => "100",
                "as_is" => false
            ]
        ]);
    }

    private function user() {
        return User::create([
            "name" => "Masoud Hosseini",
            "email" => "massoud.hosseini@gmail.com",
            "password" => "password"
        ]);
    }
}
