<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\invoices;
	use App\Models\sections;
	use Illuminate\Http\Request;
	
	class CustomersReportController extends Controller
	{
		public function index()
		{
			$sections = sections::all();
			return view('reports.customers_report', compact('sections'));
		}
		
		public function search_customers(Request $request)
		{


// في حالة البحث بدون التاريخ
			
			if ($request->Section && $request->product && $request->start_at == '' && $request->end_at == '') {
				
				
				$invoices = invoices::with('section')->select('*')->where('section_id', '=', $request->Section)->where('product', '=', $request->product)->get();
				$sections = sections::all();
				return view('reports.customers_report', compact('sections'))->withDetails($invoices);
				
				
			} // في حالة البحث بتاريخ
			
			else {
				
				$start_at = date($request->start_at);
				$end_at = date($request->end_at);
				
				if (empty($end_at))
				{
					$end_at =  date('Y-m-d');
				}
				if (empty($start_at))
				{
					
					$start_at = invoices::orderby('invoice_Date','asc')->first();
					$start_at = $start_at->invoice_Date ;
				}
				
				$invoices = invoices::whereBetween('invoice_Date', [$start_at, $end_at])->where('section_id', '=', $request->Section)->where('product', '=', $request->product)->get();
				$sections = sections::all();
				return view('reports.customers_report', compact('sections'))->withDetails($invoices);
				
				
			}
			
			
		}
	}