<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoice_attachments;
use App\Models\invoices_details;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
	    $invoices = invoices::with('section')->get();
	    return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
	    $sections = sections::all();
	    return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
	    invoices::create([
		    'invoice_number' => $request->invoice_number,
		    'invoice_Date' => $request->invoice_Date,
		    'Due_date' => $request->Due_date,
		    'product' => $request->product,
		    'section_id' => $request->section_id,
		    'Amount_collection' => $request->Amount_collection,
		    'Amount_Commission' => $request->Amount_Commission,
		    'Discount' => $request->Discount,
		    'Value_VAT' => $request->Value_VAT,
		    'Rate_VAT' => $request->Rate_VAT,
		    'Total' => $request->Total,
		    'Status' => 'غير مدفوعة',
		    'Value_Status' => 2,
		    'note' => $request->note,
	    ]);
	    $invoice_id = invoices::latest()->first()->id;
	    invoices_details::create([
		    'id_Invoice' => $invoice_id,
		    'invoice_number' => $request->invoice_number,
		    'product' => $request->product,
		    'section_id' => $request->section_id,
		    'Status' => 'غير مدفوعة',
		    'Value_Status' => 2,
		    'note' => $request->note,
		    'user' => (Auth::user()->name),
	    ]);


	    if ($request->hasFile('pic')) {
		    $request->validate([
			    'pic' => 'required|image|mimes:pdf,jpg,png|max:2048', // Example validation rules
		    ],[
				'pic.mimes'=>'تم حفظ الفاتورة ولكن الصورة غير متوافقة '
		    ]);
		    $invoice_id = Invoices::latest()->first()->id;
		    $image = $request->file('pic');
		    $file_name = $image->getClientOriginalName();
		    $invoice_number = $request->invoice_number;

		    $attachments = new invoice_attachments();
		    $attachments->file_name = $file_name;
		    $attachments->invoice_number = $invoice_number;
		    $attachments->Created_by = Auth::user()->name;
		    $attachments->invoice_id = $invoice_id;
		    $attachments->save();

		    // move pic
		    $imageName = $request->pic->getClientOriginalName();
		    $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
	    }

	    
	    // $user = User::first();
	    // Notification::send($user, new AddInvoice($invoice_id));
//
//	    $user = User::get();
//	    $invoices = invoices::latest()->first();
//	    Notification::send($user, new \App\Notifications\Add_invoice_new($invoices));
//
//
//	    event(new MyEventClass('hello world'));
//
	    session()->flash('success', 'تم اضافة الفاتورة بنجاح');
	    return back();
	    
    }

    /**
     * Display the specified resource.
     */
    public function show(invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = invoices::findorfail($id);
		$sections = sections::all();
		return view('invoices.edit_invoice', compact('invoice', 'sections'));
	
	}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $invoice = invoices::findorfail($request->invoice_id);
		$invoice->update([
			'invoice_number' => $request->invoice_number,
			'invoice_Date' => $request->invoice_Date,
			'Due_date' => $request->Due_date,
			'product' => $request->product,
			'section_id' => $request->section_id,
			'Amount_collection' => $request->Amount_collection,
			'Amount_Commission' => $request->Amount_Commission,
			'Discount' => $request->Discount,
			'Value_VAT' => $request->Value_VAT,
			'Rate_VAT' => $request->Rate_VAT,
			'Total' => $request->Total,
			'note' => $request->note,
		]);
		
		
	 
		return back()->with('success',"تم تعديل الفاتورة بنجاح");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoices $invoices)
    {
        //
    }
	public function getproducts($id)
	{
		$products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
		return json_encode($products);
	}
	
}
