<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Step 5: Create one controller and route to display the Product form
// go to the terminal and type the following command.
//
// $ php artisan make:controller ProductController -- resource
//
// It will create one controller file called ProductController.php and it has
// the CRUD Functions, we need to seek.
//
// Here, we have used resource parameter, so by default, it prodvides us some
// routing patterns, but right now, we will not see until we register one route
// in routes >> web.php file. So let us do it.
Route::resource( 'products', 'ProductController' ) ;

// Now, switch to your terminal and type the following command.
// $ php artisan route:list