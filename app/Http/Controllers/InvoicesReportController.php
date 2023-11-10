<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\invoices;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;
	use function PHPUnit\Framework\isEmpty;
	
	class InvoicesReportController extends Controller
	{
		
		public function index()
		{
			return view('reports.invoices_report');
		}
		
		
		public function search_invoice(Request $request)
		{
			
			$rdio = $request->rdio;
			
			
			// في حالة البحث بنوع الفاتورة
			
			if ($rdio == 1) {
				
				
				// في حالة عدم تحديد تاريخ
				if ($request->type && $request->start_at == '' && $request->end_at == '') {
					
					$type = $request->type;
					
					$type == 'الكل' ?  $invoices = invoices::all()  : $invoices = invoices::select('*')->where('Status', '=', $type)->get();
					
					return view('reports.invoices_report', compact('type'))->withDetails($invoices);
				} // في حالة تحديد تاريخ استحقاق
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
					$type = $request->type;
						$type == 'الكل' ?  $invoices = invoices::with('section')->select('*')->wherebetween('invoice_Date', [$start_at, $end_at])->get()  : $invoices = invoices::with('section')->wherebetween('invoice_Date', [$start_at, $end_at])->where('Status', '=', $request->type)->get();
					
//					$invoices = DB::table('invoices')->where(('invoice_Date'), [$start_at, $end_at])->where('Status', '=', $request->type)->get();
//					$invoices = invoices::select('*')->where('invoice_Date', [$start_at, $end_at])->where('Status', '=', $request->type)->get();
//					$invoices = invoices::whereDate('invoice_Date', '>=',$start_at)->whereDate('invoice_Date', '<=', $end_at)->where('Status', '=', $request->type)->get();
//					$invoices = invoices::where('Status', '=', $request->type)->get();
					return view('reports.invoices_report', compact('type', 'start_at', 'end_at'))->withDetails($invoices);
					
				}
				
				
			}
			
			//====================================================================
			
			// في البحث برقم الفاتورة
			else {
				
				$invoices = invoices::select('*')->where('invoice_number', '=', $request->invoice_number)->get();
				return view('reports.invoices_report')->withDetails($invoices);
				
			}
			
			
		}
		
		public function customers_report()
		{
		
		}
		
		
		
		
	}
