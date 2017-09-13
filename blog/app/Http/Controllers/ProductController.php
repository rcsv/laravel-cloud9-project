<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product ;

class ProductController extends Controller
{
    // Next step would be to go to ProductController.php file and add into
    // create function some code.
    
    /**
     * Show the form for creating a new resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'products.create' ) ;
    }
    
    public function store( Request $request )
    {
        $product = $this->validate(request(), [
            'name' => 'required',
            'price'=> 'required|numeric'
        ]);
        
        Product::create($product);
        
        return back()->with('success', 'Product has been added') ;
    }
}
