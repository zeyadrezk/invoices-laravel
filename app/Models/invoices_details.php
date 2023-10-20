<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{
	protected $fillable = [
		'id_Invoice',
		'invoice_number',
		'product',
		'section_id',
		'Status',
		'Value_Status',
		'note',
		'user',
		'Payment_Date',
	];
	
    use HasFactory;
}
