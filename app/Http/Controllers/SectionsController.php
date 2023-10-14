<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
	    $sections=sections::all();
	    return view('sections.sections',compact('sections'));
	    
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
	    $request->validate([
		    'section_name' => 'required|unique:sections|min:4|max:25',
		    'description' =>'required|min:10'
	    ],[
		    'section_name.required'=>'يرجي ادخال اسم القسم',
		    'section_name.min'=>'اسم القسم يجب ان يكون 4 احرف علي الاقل',
		    'section_name.max'=>'اسم القسم يجب ان يكون25 حرف علي الاكثر',
		    'section_name.unique'=>'خطأ القسم مسجل مسبقا',
		    'description.required' =>'يرجي ادخال الوصف',
		    'description.min' =>'يجب ان يحتوي الوصف علي 10 حرف علي الاقل',
	    
	    ]);
	    
	    sections::create([
		    'section_name' => $request->section_name,
		    'description' => $request->description,
		    'Created_by' => (Auth::user()-> name )
	    
	    ]);
//	    session()->flash('Add', 'تم اضافة القسم بنجاح ');
	    return redirect()->back()->with("Add",'تم اضافة القسم بنجاج');
	    
    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, sections $sections)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sections $sections)
    {
        //
    }
}
