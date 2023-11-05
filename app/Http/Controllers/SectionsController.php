<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
	
	
	function __construct()
	{
		
		$this->middleware('permission:الاقسام', ['only' => ['index']]);
		$this->middleware('permission:اضافة قسم', ['only' => ['create','store']]);
		$this->middleware('permission:تعديل قسم', ['only' => ['edit','update']]);
		$this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
		
	}
	
	
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
    public function store(StoreSectionRequest $request)
    {
	   
	    sections::create([
		    'section_name' => $request->section_name,
		    'description' => $request->description,
		    'Created_by' => (Auth::user()-> name )
	    
	    ]);
//	    session()->flash('Add', 'تم اضافة القسم بنجاح ');
	    return redirect()->back()->with("success",'تم اضافة القسم بنجاج');
	    
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
    public function update(UpdateSectionRequest $request)
    {
		$section =  sections::findorfail($request->id);
		$section->update( ['section_name' =>$request->section_name,
	        'description'=> $request->description]
    );
	    
	    return redirect()->back()->with("success",'تم تعديل القسم بنجاج');
	    
	    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        		  sections::destroy($request->id);
				  
	    return redirect()->back()->with("success",'تم حذف القسم بنجاج');
	    
    }
}
