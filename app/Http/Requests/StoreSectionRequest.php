<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return
	        [
		        'section_name' => 'required|unique:sections|min:4|max:25',
		        'description' =>'required|min:10',
	        
		       
	        
	        ];
	    
	    
    }
	public function messages()
	{
		
		return[
			'section_name.required'=>'يرجي ادخال اسم القسم',
			'section_name.min'=>'اسم القسم يجب ان يكون 4 احرف علي الاقل',
			'section_name.max'=>'اسم القسم يجب ان يكون25 حرف علي الاكثر',
			'section_name.unique'=>'خطأ القسم مسجل مسبقا',
			'description.required' =>'يرجي ادخال الوصف',
			'description.min' =>'يجب ان يحتوي الوصف علي 10 حرف علي الاقل',
		];
	}
}
