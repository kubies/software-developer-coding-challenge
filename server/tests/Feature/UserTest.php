<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function register_a_user_with_invalid_request() {
        $this->post('/api/register')->assertStatus(Response::HTTP_BAD_REQUEST);
        $this->post('/api/register', [
            "name" => "Masoud Hosseini",
            "email" => "massoud.hosseini@gmail.com"
        ])->assertStatus(Response::HTTP_BAD_REQUEST);
        $this->post('/api/register', [
            "name" => "Masoud Hosseini",
            "password" => "password"
        ])->assertStatus(Response::HTTP_BAD_REQUEST);
        $this->post('/api/register', [
            "email" => "massoud.hosseini@gmail.com",
            "password" => "password"
        ])->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function register_user() {
        $response = $this->post('/api/register', [
            "name" => "Masoud Hosseini",
            "email" => "massoud.hosseini@gmail.com",
            "password" => "password"
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            "name" => "Masoud Hosseini",
            "email" => "massoud.hosseini@gmail.com",
            "id" => 1
        ]);
        $this->assertDatabaseHas('users', [
            "email" => "massoud.hosseini@gmail.com",
        ]);
    }

    /**
     * @test
     */
    public function user_cannot_register_with_duplicate_email() {
        $this->post('/api/register', [
            "name" => "Masoud Hosseini",
            "email" => "massoud.hosseini@gmail.com",
            "password" => "password"
        ]);
        $this->post('/api/register', [
            "name" => "Masoud Hosseini",
            "email" => "massoud.hosseini@gmail.com",
            "password" => "password"
        ])->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function get_list_of_all_users_when_empty() {
        $this->get('/api/users')->assertJsonCount(0);
    }

    /**
     * @test
     */
    public function get_list_of_all_users() {
        $this->post('/api/register', [
            "name" => "Masoud Hosseini",
            "email" => "massoud.hosseini@gmail.com",
            "password" => "password"
        ]);
        $this->post('/api/register', [
            "name" => "Masoud",
            "email" => "mhosseini@gmail.com",
            "password" => "password"
        ]);

        $this->get('/api/users')->assertStatus(Response::HTTP_OK)->assertJson([
            [
                "name" => "Masoud Hosseini",
                "email" => "massoud.hosseini@gmail.com",
            ],
            [
                "name" => "Masoud",
                "email" => "mhosseini@gmail.com",
            ]
        ]);
    }
}
