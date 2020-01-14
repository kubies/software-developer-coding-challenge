<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * This function lists all users
     */
    public function index() {
        return User::all();
    }

    /**
     * Create a new user (user registration)
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(),
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8']
            ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    "errors" => collect($validator->messages()->messages())->flatten(1)
                ],
                Response::HTTP_BAD_REQUEST);
        }
        return User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
    }
}
