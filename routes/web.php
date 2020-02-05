<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group([
	'prefix'=> 'api/v1',
],
	function ()use ($router)
	{
		//User Authentication
		$router->post('/user/login', 'UserController@authenticate');

		//User Create
		$router->post('/user/create', 'UserController@store');

		//User List
		$router->get('/user/list', 'UserController@index');

		//User Show
		$router->get('/user/show/{id}', 'UserController@show'); 

		//User Update
		$router->post('/user/update/{id}', 'UserController@update');

		//User Delete
		$router->delete('/user/delete/{id}', 'UserController@destroy');

		//Restricted Routes
		$router->group(['middleware' =>'auth:api'], function () use ($router) {
		 	//User List
			$router->get('/user/list', 'UserController@index');
		 });


		//Category Create
		$router->post('/category/create', 'CategoryController@store');

	    //Category list
		$router->get('/category/list', 'CategoryController@index');

		//Category show
		$router->get('/category/show/{id}', 'CategoryController@show');

		//Category update
		$router->post('/category/update/{id}', 'CategoryController@update');

		//Category delete
		$router->delete('/category/delete/{id}', 'CategoryController@destroy');


		//Item Create
		$router->post('/item/create', 'ItemController@store');

		//Item List
		$router->get('/item/list', 'ItemController@index');

		//Item Show
		$router->get('/item/show/{id}', 'ItemController@show');

		//Item update
		$router->post('/item/update/{id}', 'ItemController@update');

		//Item delete
		$router->delete('/item/delete/{id}', 'ItemController@destroy');


		//Package Create
		$router->post('/package/create', 'PackageController@store');

		//Package List
		$router->get('/package/list', 'PackageController@index');

		//Package Show
		$router->get('/package/show/{id}', 'PackageController@show');

		//Package update
		$router->post('/package/update/{id}', 'PackageController@update');

		//Package delete
		$router->delete('/package/delete/{id}', 'PackageController@destroy');


		//Order Create
		$router->post('/order/create', 'OrderController@store');

		//Order List
		$router->get('/order/list', 'OrderController@index');

		//Order Show
		$router->get('/order/show/{id}', 'OrderController@show'); 

		//Order Update
		$router->post('/order/update/{id}', 'OrderController@update');

		//Order Delete
		$router->delete('/order/delete/{id}', 'OrderController@destroy');


		//Transaction Create
		$router->post('/transaction/create', 'TransactionController@store');

		//Transaction List
		$router->get('/transaction/list', 'TransactionController@index');

		//Transaction Show
		$router->get('/transaction/show/{id}', 'TransactionController@show'); 

		//Transaction Update
		$router->post('/transaction/update/{id}', 'TransactionController@update');

		//Transaction Delete
		$router->delete('/transaction/delete/{id}', 'TransactionController@destroy');


		//Payment Create
		$router->post('/payment/create', 'PaymentController@store');

		//Payment List
		$router->get('/payment/list', 'PaymentController@index');

		//Payment Show
		$router->get('/payment/show/{id}', 'PaymentController@show'); 

		//Payment Update
		$router->post('/payment/update/{id}', 'PaymentController@update');

		//Payment Delete
		$router->delete('/payment/delete/{id}', 'PaymentController@destroy');

	}
);

