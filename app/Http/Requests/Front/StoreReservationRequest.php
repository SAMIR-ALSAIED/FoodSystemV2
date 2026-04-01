<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
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
        return [
 
            'customer_name' => 'required|string|max:255',
           
                'customer_phone' => [
            'required',
            'regex:/^(010|011|012)[0-9]{8}$/', 
        ],
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'guest_count'=>'required|integer|min:1',
        ];
    }
   
    public function messages()
{
    return [
        'customer_name.required' => 'من فضلك أدخل الاسم',
        'customer_phone.required' => 'من فضلك أدخل رقم الهاتف',
        'customer_phone.regex' => 'رقم الهاتف يجب أن يبدأ بـ 010 أو 011 أو 012 ويكون 11 رقمًا صحيحًا',
        'reservation_date.required' => 'من فضلك اختر تاريخ الحجز',
        'reservation_date.after_or_equal' => 'التاريخ يجب أن يكون اليوم أو بعده',
        'reservation_time.required' => 'من فضلك اختر وقت الحجز',
        'guest_count.required' => 'من فضلك أدخل عدد الضيوف',
        'guest_count.integer' => 'عدد الضيوف يجب أن يكون رقم صحيح',
        'guest_count.min' => 'يجب أن يكون عدد الضيوف على الأقل 1',
    ];
}

}
