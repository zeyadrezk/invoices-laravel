<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use App\Models\invoices;
use App\Models\invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
		$invoices = invoices::where('id',$id)->first();
		$details = invoices_details::where('id_Invoice',$id)->get();
		$attachments = invoice_attachments::where('invoice_id',$id)->get();
        return view('invoices.details_invoice',compact('invoices','details','attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
		    $attachment = invoice_attachments::findorfail($request->id_file);
		    $attachment->delete();
	        $path= ('Attachments/'.$request->invoice_number.'/'.$request->file_name);
			File::delete($path);
	    
	    return back()->with('deleted','تم حذف المرفق بنجاح ');
		
    }
		
	public function get_file($invoice_number,$file_name)
	
	{
		$contents= public_path('Attachments/'.$invoice_number.'/'.$file_name);
		return response()->download($contents);
	}
	
	
	
	public function open_file($invoice_number,$file_name)
	
	{
		$files = public_path('Attachments/'.$invoice_number.'/'.$file_name);
		return response()->file($files);
	}
	
	public function store_attachment(Request $request)
	
	{
			$request->validate([
				'file_name' => 'required|image|mimes:pdf,jpg,png|max:2048', // Example validation rules
			],[
				'file_name.mimes'=>' تم حفظ الفاتورة ولكن الصورة غير متوافقة '
			]);
			$image = $request->file('file_name');
			$file_name = $image->getClientOriginalName();
			
//			invoice_attachments::create([
//				'file_name' => $file_name,
//				'invoice_number' => $request->invoice_number,
//				'Created_by' => Auth::user()->name,
//				'invoice_id' => $request->invoice_id,
//
//			]);
			$attachments = new invoice_attachments();
			$attachments->file_name = $file_name;
			$attachments->invoice_number = $request->invoice_number;
			$attachments->Created_by = Auth::user()->name;
			$attachments->invoice_id = $request->invoice_id;
			$attachments->save();
			
			// move pic
			$imageName = $request->file_name->getClientOriginalName();
			$request->file_name->move(public_path('Attachments/' . $request->invoice_number), $imageName);
		
		
		
		
		return back()->With('success','تم اضافة المرفق بنجاح');
	}
	
	
	
}
