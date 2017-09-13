<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','price'] ;
    
    // If you see the resource routes then it has post request has '/products'
    // route and store function in ProductController.php file. So we need to
    // code the store function in order to save the data in the database.
    //
    // One thing to keep in mind that, we need to include the namespace of
    // Product.php model in the ProductController.php file. So type the
    // following line at the starting of ProductController.php file.
}
