<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
     * Return User information
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $user = User::find($id);
        if($user === null) {
            return response()->json(['errors' => ['User Not Found']], Response::HTTP_NOT_FOUND);
        }
        return $user;
    }

    /**
     * Return all auctions created by user
     */
    public function auctions($id) {
        $user = User::find($id);
        if($user === null) {
            return response()->json(['errors' => ['User Not Found']], Response::HTTP_NOT_FOUND);
        }
        return $user->auctions;
    }

    /**
     * Return all bids placed by user ordered by creation time and id
     */
    public function bids($id) {
        $user = User::find($id);
        if($user === null) {
            return response()->json(['errors' => ['User Not Found']], Response::HTTP_NOT_FOUND);
        }
        return $user->bids()->orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
    }

    /**
     * Create a new user (user registration)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
            'password' => Hash::make($request->get('password'))
        ]);
    }

    public function login(Request $request)  {
        if(auth()->user() !== null) {
            return response()->json(['errors' => ['you are logged in']], Response::HTTP_BAD_REQUEST);
        }
        $validator = Validator::make($request->all(),
            [
                'email' => ['required'],
                'password' => ['required']
            ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    "errors" => collect($validator->messages()->messages())->flatten(1)
                ],
                Response::HTTP_BAD_REQUEST);
        }
        $user = User::where('email', $request->get('email'))->first();
        if($user === null || !Hash::check($request->get('password'), $user->password)) {
            return response()->json(['errors' => ['Invalid username or password']], Response::HTTP_BAD_REQUEST);
        }

        $token = Str::random(80);
        $user->forceFill([
            'api_token' => hash('sha256', $token)
        ])->save();
        return ['token' => $token];
    }

    public function logout() {
        if(auth()->user() === null) {
            return;
        }
        auth()->user()->forceFill([
            'api_token' => null
        ])->save();
    }

    public function me() {
        return auth()->user();
    }
}
