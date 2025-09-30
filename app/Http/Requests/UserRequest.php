<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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

    // $user = $this->route('user') ?? $this->route('user2');


        $userId =
             $this->route('teacher')
          ?? $this->route('employee')
          ?? $this->route('user')
          ?? $this->route('user2')
          ?? 0;


//    dd($user);

        return [
            'name_ar' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'location_id' => ['required', 'exists:locations,id'],
            'married' => ['required', 'in:0,1'],
            'phone' => ['nullable', 'string', 'max:20' , 'unique:users,phone,' . $userId],
            'country_id' => ['required', 'exists:countries,id'],
            'iqama' => ['nullable', 'string', 'max:50'],
            'iqama_expiry' => ['nullable', 'date'],
            'passport' => ['nullable', 'string', 'max:50'],
            'passport_expiry' => ['nullable', 'date'],
            'birthdate' => ['nullable', 'date'],
            'hiring_date' => ['nullable', 'date'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'paymant_method' => ['required', 'in:0,1'],


            'bank_name' => ['nullable', 'string', 'max:255'],
            'iban' => ['nullable', 'string', 'max:50'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            // لو عندك إيميل أو يوزر نيم وعاوز unique
            'email' => ['nullable', 'email', 'unique:users,email,' . $userId],
        ];
    }

    public function messages(): array
    {
        return [
            'name_ar.required' => 'الاسم بالعربية مطلوب',
            'name_en.required' => 'الاسم بالإنجليزية مطلوب',
            'location_id.required' => 'يجب اختيار الموقع',
            'location_id.exists' => 'الموقع غير صحيح',
            'country_id.required' => 'يجب اختيار الدولة',
            'country_id.exists' => 'الدولة غير صحيحة',
            'paymant_method.required' => 'يجب اختيار طريقة الدفع',
            'paymant_method.in' => 'طريقة الدفع يجب أن تكون كاش أو تحويل بنكي',
            'photo.image' => 'الصورة يجب أن تكون ملف صورة',
            'photo.mimes' => 'الصورة يجب أن تكون بصيغة JPG أو PNG',
            'photo.max' => 'الصورة لا يجب أن تتعدى 2 ميجا',
        ];





}
}
