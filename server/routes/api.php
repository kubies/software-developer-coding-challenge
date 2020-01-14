<?php

use Illuminate\Http\Request;

Route::post('/register', 'UserController@create');
Route::post('/login', 'UserController@login')->name('login');
Route::middleware('auth:api')->post('/logout', 'UserController@logout')->name('logout');

Route::get('/users', 'UserController@index');                               //All Users
Route::get('/auctions', 'AuctionController@index');                         //All Auctions

Route::get('/user/{id}', 'UserController@show');                            //User
Route::get('/user/{id}/auctions', 'UserController@auctions');               //User Auctions
Route::get('/user/{id}/bids', 'UserController@bids');                       //User bids

Route::get('/auction/{id}', 'AuctionController@show');                      //Auction
Route::get('/auction/{id}/bids', 'AuctionController@bids');                 //All auction bids
Route::get('/auction/{id}/highestBid', 'AuctionController@highestBid');     //Auction win bid

Route::middleware('auth:api')->post('/auction', 'AuctionController@create');                        //Creating Auction
Route::middleware('auth:api')->delete('/auction/{id}', 'AuctionController@destroy');                //Deleting Auction
Route::middleware('auth:api')->put('/auction/{id}', 'AuctionController@placeBid');                  //Creating Bid
