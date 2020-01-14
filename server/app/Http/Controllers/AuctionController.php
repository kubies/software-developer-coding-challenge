<?php

namespace App\Http\Controllers;

use App\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class AuctionController extends Controller
{
    /**
     * Returns list of all auctions
     */

    public function index() {
        return Auction::all();
    }

    /**
     * Returns an auction
     */
    public function show($id) {
        $auction = Auction::find($id);
        if($auction === null) {
            return response()->json(['errors' => ['Auction Not Found']], Response::HTTP_NOT_FOUND);
        }
        return $auction;
    }

    /**
     * Delete an auction
     */
    public function destroy($id) {
        if(auth()->user() === null) {
            return response()->json(['errors' => ['Please login to access this page']], Response::HTTP_FORBIDDEN);
        }
        $auction = Auction::find($id);
        if($auction === null) {
            return response()->json(['errors' => ['Auction Not Found']], Response::HTTP_NOT_FOUND);
        }
        if($auction->user->id != auth()->user()->id) {
            return response()->json(['errors' => ['Unauthorized operation']], Response::HTTP_UNAUTHORIZED);
        }
        $auction->delete();
    }

    /**
     * Allowing the user to place bid based on aution bid increment
     */
    public function placeBid($id) {
        if(auth()->user() === null) {
            return response()->json(['errors' => ['Please login to access this page']], Response::HTTP_FORBIDDEN);
        }
        $auction = Auction::find($id);
        if($auction === null) {
            return response()->json(['errors' => ['Auction Not Found']], Response::HTTP_NOT_FOUND);
        }
        if($auction->user->id === auth()->user()->id) {
            return response()->json(['errors' => ['Unauthorized operation']], Response::HTTP_UNAUTHORIZED);
        }
        return $auction->placeBid();
    }

    /**
     * Returns highest bid of an auction
     */
    public function highestBid($id) {
        $auction = Auction::find($id);
        if($auction === null) {
            return response()->json(['errors' => ['Auction Not Found']], Response::HTTP_NOT_FOUND);
        }
        return $auction->highestBid();
    }

    /**
     * Returns all bids for an auction ordered by creation time
     */
    public function bids($id) {
        $auction = Auction::find($id);
        if($auction === null) {
            return response()->json(['errors' => ['Auction Not Found']], Response::HTTP_NOT_FOUND);
        }
        return $auction->bids()->orderBy('created_at', 'desc')->orderBy('amount', 'desc')->get();
    }

    /**
     * Create an auction
     */
    public function create(Request $request) {
        if(auth()->user() === null) {
            return response()->json(['errors' => ['Please login to access this page']], Response::HTTP_FORBIDDEN);
        }
        //Check for valid parameters
        $validator = $this->validateAuction($request);
        if ($validator->fails()) {
            return response()->json(
                [
                    "errors" => collect($validator->messages()->messages())->flatten(1)
                ],
                Response::HTTP_BAD_REQUEST);
        }
        return auth()->user()->createAuction($request->all());
        $car = $auction->car;
        return [
            "car" => [
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
            ],
            "created_by" => $auction->created_by,
            "start_price" => $auction->start_price,
            "bid_increment" => $auction->bid_increment,
            "as_is" => $auction->as_is
        ];
    }

    private function validateAuction(Request $request) {
        return $validator = Validator::make($request->all(),
            [
                'car' => ['required'],
                'car.vin' => ['required', 'string', 'min:17', 'max:17'],
                'car.make' => ['required', 'string'],
                'car.model' => ['required', 'string'],
                'car.style' => ['nullable', 'string'],
                'car.year' => ['required', 'integer'],
                'car.seats' => ['nullable', 'integer'],
                'car.doors' => ['nullable', 'integer'],
                'car.engine' => ['nullable', 'string'],
                'car.transmission' => ['nullable', 'string'],
                'car.body' => ['required', Rule::in(['convertible','truck','van','wagon',
                                                    'suv','coupe','sedan','crossover','minivan',
                                                    'truck_crew_cab','truck_extended_cab',
                                                    'truck_long_regular_cab','motorcycle',
                                                    'cargo_van','commercial','trailer','hatchback'])],
                'car.interior_color' => ['nullable', 'string'],
                'car.exterior_color' => ['nullable', 'string'],
                'car.odometer' => ['required', 'integer'],
                'start_price' => ['required', 'string'],
                'bid_increment' => ['required', 'string'],
                'as_is' => ['nullable']
            ]);
    }
}
