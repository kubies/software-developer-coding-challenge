<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token', 'email_verified_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bids() {
        return $this->hasMany(Bid::class);
    }

    public function auctions() {
        return $this->hasMany(Auction::class, 'created_by');
    }

    public function createAuction($auction) {
        $auction = collect($auction);
        $car_data = collect($auction->get('car'));
//        $car = Car::create();
        $auction = $this->auctions()->create([
            "created_by" => $this->id,
            "start_price" => $auction->get("start_price"),
            "bid_increment" => $auction->get("bid_increment"),
            "as_is" => $auction->get('as_is', false)
        ]);
        $auction->addCar(
            [
                "vin" => $car_data->get("vin"),
                "make" => $car_data->get("make"),
                "model" => $car_data->get("model"),
                "style" => $car_data->get("style", null),
                "year" => $car_data->get("year"),
                "seats" => $car_data->get("seats", null),
                "doors" => $car_data->get("doors", null),
                "engine" => $car_data->get("engine", null),
                "transmission" => $car_data->get("transmission", null),
                "body" => $car_data->get("body"),
                "interior_color" => $car_data->get("interior_color", null),
                "exterior_color" => $car_data->get("exterior_color", null),
                "odometer" => $car_data->get("odometer")
            ]
        );
        return $auction;
    }

}
