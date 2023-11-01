<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoice_attachments;
use App\Models\invoices_details;
use App\Models\sections;
use App\Models\User;
use App\Notifications\Add_invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Notification;


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

	    
//	    event(new MyEventClass('hello world'));
	    
	    $user = User::get();
	    $invoices = invoices::latest()->first();
	    Notification::send($user, new Add_invoice($invoices->id));
	    
	    
	    
	    session()->flash('success', 'تم اضافة الفاتورة بنجاح');
	    return back();
	    
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
//     $invoice = invoices::where('id', $id)->first();
     $invoice = invoices::with('section')->where('id', $id)->first();
	 return view('invoices.status_update',compact('invoice'));
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
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
		$invoice = invoices::where('id',$id)->first();
		
	    if(!$invoice){
			$invoice = invoices::onlyTrashed()->where('id',$id)->first();
		}
			
	    $attachments = invoice_attachments::where('invoice_id',$id)->get();
		
		foreach($attachments as $attachment) {
			if (!empty($attachment->invoice_number)) {
//				Storage::disk('public')->delete('/Attachments/'.$attachment->invoice_number.'/'.$attachment->file_name);
				file::deleteDirectory(public_path('/Attachments/'.$attachment->invoice_number));
			}
		$attachment->delete();
		}
		$invoice ->forceDelete();
		return back()->with('delete_invoice','');
    }
	public function getproducts($id)
	{
		$products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
		return json_encode($products);
	}
	
	public function status_update(Request $request)
	{
		$invoice = invoices::findorfail($request->invoice_id);
		switch ($request->status)
		{
			case ('مدفوعة'):
				$invoice->update([
				'Value_Status'=>1,
				'Status'=>$request->status,
				'Payment_Date'=>$request->payment_date
			]);
			
			invoices_Details::create([
				'id_Invoice' => $request->invoice_id,
				'invoice_number' => $request->invoice_number,
				'product' => $request->product,
				'section_id' => $request->section_id,
				'Status' => $request->status,
				'Value_Status' => 1,
				'note' => $request->note,
				'Payment_Date' => $request->payment_date,
				'user' => (Auth::user()->name),
			]);
			
			break;
			
			case ("مدفوعة جزئيا"):
				
				$invoice->update([
					'Value_Status' => 3,
					'Status' => $request->status,
					'Payment_Date' => $request->payment_date,
				]);
				invoices_Details::create([
					'id_Invoice' => $request->invoice_id,
					'invoice_number' => $request->invoice_number,
					'product' => $request->product,
					'section_id' => $request->section_id,
					'Status' => $request->status,
					'Value_Status' => 3,
					'note' => $request->note,
					'Payment_Date' => $request->payment_date,
					'user' => (Auth::user()->name),
				]);
				break;
				
			default:
				return back()->with('error',"");
			
			
		}
//		if ($request->status=="مدفوعة")
//		{
//			$invoice->update([
//				'Value_Status'=>1,
//				'Status'=>$request->status,
//				'Payment_Date'=>$request->payment_date
//			]);
//
//			invoices_Details::create([
//			'id_Invoice' => $request->invoice_id,
//			'invoice_number' => $request->invoice_number,
//			'product' => $request->product,
//			'section_id' => $request->section_id,
//			'Status' => $request->status,
//			'Value_Status' => 1,
//			'note' => $request->note,
//			'Payment_Date' => $request->payment_date,
//			'user' => (Auth::user()->name),
//		]);
//		}
//		if ($request->status=="مدفوعة جزئيا")
//		{
//			$invoice->update([
//				'Value_Status' => 3,
//				'Status' => $request->status,
//				'Payment_Date' => $request->payment_date,
//			]);
//			invoices_Details::create([
//				'id_Invoice' => $request->invoice_id,
//				'invoice_number' => $request->invoice_number,
//				'product' => $request->product,
//				'section_id' => $request->section_id,
//				'Status' => $request->status,
//				'Value_Status' => 3,
//				'note' => $request->note,
//				'Payment_Date' => $request->payment_date,
//				'user' => (Auth::user()->name),
//			]);
//		}

		 return redirect(route('invoices.index'))
			 ->with('payment',"");
	}
	
	public function invoice_paid()
	{
		$invoices = invoices::with('section')->where('Value_status',1)->get();
		return view('invoices.invoices_paid',compact('invoices'));
		
	}
	
	public function invoice_unpaid()
	{
		$invoices = invoices::with('section')->where('Value_status',2)->get();
		return view('invoices.invoices_unpaid',compact('invoices'));
	}
	
	public function invoice_partial()
	{
		$invoices = invoices::with('section')->where('Value_status',3)->get();
		return view('invoices.invoices_partial',compact('invoices'));
		
	}	public function archived_invoices()
	{
		$invoices = invoices::with('section')->onlyTrashed()->get();
		return view('invoices.archived_invoices',compact('invoices'));
		
	}
	public function invoice_archive(Request $request)
	{
		$id = $request->invoice_id;
		$invoice = invoices::where('id',$id)->first();
		$invoice ->delete();
		return back()->with('archive_invoice','');
	}
	public function invoice_restore(Request $request)
	{
		$id = $request->invoice_id;
		$invoice = invoices::withTrashed()->where('id',$id)->restore();
		return redirect(route('invoices.index'))->with('restored_invoice','');
	}
	
	
	
	public function print_invoice($id)
	{
		$invoices = invoices::with('section')->where('id',$id)->first();
		return view('invoices.print_invoice',compact('invoices'));
	}
}
