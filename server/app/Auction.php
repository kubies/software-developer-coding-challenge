<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $guarded = [];
    protected $appends = ['car'];
    public function carRelation() {
        return $this->hasOne(Car::class);
    }

    public function addCar($car) {
        $this->carRelation()->create($car);
    }

    public function getCarAttribute() {
        $car = $this->carRelation;
        return [
            "vin" => $car->vin,
            "make" => $car->make,
            "model" => $car->model,
            "style" => $car->style,
            "year" => $car->year,
            "seats" => $car->seats,
            "doors" => $car->doors,
            "engine" => $car->engine,
            "transmission" => $car->transmission,
            "body" => $car->body,
            "interior_color" => $car->interior_color,
            "exterior_color" => $car->exterior_color,
            "odometer" => $car->odometer
        ];
    }
}
