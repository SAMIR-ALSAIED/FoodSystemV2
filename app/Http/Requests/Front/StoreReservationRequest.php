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
                  'table_id' => 'required|exists:tables,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
        ];
    }
          public function messages()
    {
        return [
            'table_id.required' => 'من فضلك اختر الطاولة',
            'table_id.exists' => 'الطاولة غير موجودة',
            'customer_name.required' => 'من فضلك أدخل الاسم',
            'customer_phone.required' => 'من فضلك أدخل رقم الهاتف',
            'reservation_date.required' => 'من فضلك اختر تاريخ الحجز',
            'reservation_date.after_or_equal' => 'التاريخ يجب أن يكون اليوم أو بعده',
            'reservation_time.required' => 'من فضلك اختر وقت الحجز',
        ];
    }

}
