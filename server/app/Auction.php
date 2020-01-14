<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $guarded = [];
    public function car() {
        return $this->hasOne(Car::class);
    }

    public function addCar($car) {
        $this->car()->create($car);
    }
}
