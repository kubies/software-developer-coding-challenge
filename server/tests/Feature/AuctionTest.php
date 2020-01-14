<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Faker\Factory as Faker;

class AuctionTest extends TestCase
{
    use RefreshDatabase;
    private $faker;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->faker = Faker::create();
    }

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

        $this->get("/api/user/{$user->id}/auctions")->assertStatus(200)->assertJson([
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

        $this->get('/api/auction/1')->assertStatus(Response::HTTP_OK)->assertJson([
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
    }

    /**
     * @test
     *
     */
    public function delete_auction() {
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
        $id = $response['id'];
        $this->assertDatabaseHas('auctions',
            [
                'id' => $id
            ]);
        $this->delete("/api/auction/$id")
            ->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('auctions',
            [
                'id' => $id
            ]);
    }

    /**
     * @test
     */
    public function user_can_place_bid() {
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
        $id = $response['id'];
        $this->put("/api/auction/$id")->assertStatus(Response::HTTP_UNAUTHORIZED);

        $user = $this->user();
        $this->actingAs($user);
        $response = $this->put("/api/auction/$id")->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            "amount" => 900,
            "user_id" => $user->id,
            "auction_id" => $id
        ]);
        $this->assertDatabaseHas('bids', [
            "amount" => 900,
            "user_id" => $user->id,
            "auction_id" => $id
        ]);

        $this->put("/api/auction/$id")->assertStatus(Response::HTTP_CREATED)->assertJson([
            "amount" => 1000,
            "user_id" => $user->id,
            "auction_id" => $id
        ]);
        $this->assertDatabaseHas('bids', [
            "amount" => 1000,
            "user_id" => $user->id,
            "auction_id" => $id
        ]);

        $this->get("/api/auction/$id/highestBid")->assertStatus(Response::HTTP_OK)
            ->assertJson([
                "amount" => 1000,
                "user_id" => $user->id,
                "auction_id" => $id
            ]);

        $this->get("/api/auction/$id/bids")->assertStatus(Response::HTTP_OK)
            ->assertJson([
                [
                    "amount" => 1000,
                    "user_id" => $user->id,
                    "auction_id" => $id
                ],
                [
                    "amount" => 900,
                    "user_id" => $user->id,
                    "auction_id" => $id
                ]
            ]);
    }

    private function user() {
        return User::create([
            "name" => $this->faker->name,
            "email" => $this->faker->companyEmail,
            "password" => "password"
        ]);
    }
}
