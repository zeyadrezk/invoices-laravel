<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
	    $products=products::all();
	    $sections=sections::all();
	    return view('products.products',compact('products','sections'));
	    
	    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		
	    products::create([
		    'product_name' => $request->product_name,
		    'description' => $request->description,
		    'section_id'=>$request->section_id,
	    
	    ]);
//	    session()->flash('Add', 'تم اضافة القسم بنجاح ');
	    return redirect()->back()->with("success",'تم اضافة المنتج بنجاج');
	    
    }

    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, products $products)
    {
	    $product =  products::findorfail($request->id);
	    $product->update( ['product_name' =>$request->product_name,
			    'description'=> $request->description,'section_id'=>$request->section_id]
	    );
	    
	    return redirect()->back()->with("success",'تم تعديل القسم بنجاج');
	    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(products $products)
    {
	    products::destroy($request->id);
	    
	    return redirect()->back()->with("success",'تم حذف المنتج بنجاج');
    }
}
