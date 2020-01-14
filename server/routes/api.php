<?php

use Illuminate\Http\Request;

Route::post('/register', 'UserController@create');

Route::get('/users', 'UserController@index');                               //All Users
Route::get('/auctions', 'AuctionController@index');                         //All Auctions

Route::get('/user/{id}', 'UserController@show');                            //User
Route::get('/user/{id}/auctions', 'UserController@auctions');               //User Auctions
Route::get('/user/{id}/bids', 'UserController@bids');                       //User bids

Route::get('/auction/{id}', 'AuctionController@show');                      //Auction
Route::get('/auction/{id}/bids', 'AuctionController@bids');                 //All auction bids
Route::get('/auction/{id}/highestBid', 'AuctionController@highestBid');     //Auction win bid

Route::post('/auction', 'AuctionController@create');                        //Creating Auction
Route::delete('/auction/{id}', 'AuctionController@destroy');                //Deleting Auction
Route::put('/auction/{id}', 'AuctionController@bid');                       //Creating Bid
