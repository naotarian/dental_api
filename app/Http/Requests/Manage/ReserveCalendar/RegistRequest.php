<?php

namespace App\Http\Requests\Manage\ReserveCalendar;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'reserveDay' => ['required', 'string'],
            'category' => ['required'],
            'lastName' => ['nullable', 'string'],
            'lastNameKana' => ['required', 'string'],
            'firstName' => ['nullable', 'string'],
            'firstNameKana' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'birth' => ['nullable'],
            'examination' => ['nullable'],
            'remark' => ['nullable'],
            'gender' => ['nullable'],
            'startTime' => ['nullable'],
            'endTime' => ['nullable'],
            'reserveStart' => ['required'],
            'reserveEnd' => ['required'],
            'mobileTel' => ['nullable', 'regex:/^(0{1}\d{1,4}-{0,1}\d{1,4}-{0,1}\d{4})$/'],
            'fixedTel' => ['nullable', 'regex:/^(0{1}\d{1,4}-{0,1}\d{1,4}-{0,1}\d{4})$/'],
        ];
    }

    public function attributes()
    {
        return [
            'reserveDay' => '予約日',
            'category' => '診療内容',
            'lastName' => '患者姓',
            'lastNameKana' => '患者姓(カナ)',
            'firstName' => '患者名',
            'firstNameKana' => '患者名(カナ)',
            'email' => '連絡先メールアドレス',
            'birth' => '生年月日',
            'examination' => '当院での受診',
            'remark' => '備考',
            'gender' => '患者性別',
            'reserveStart' => '予約開始時間',
            'reserveEnd' => '予約終了時間',
            'mobileTel' => '携帯電話番号',
            'fixedTel' => '固定電話番号',
        ];
    }

    public function messages()
    {
        return [
            'examination.required' => ':attributeを選択してください。',
            'reserveDay.required' => ':attributeを入力してください。',
            'category.required' => ':attributeを選択してください。',
            'reserveStart.required' => ':attributeを選択してください。',
            'reserveEnd.required' => ':attributeを選択してください。',
            'lastName.string' => ':attributeを正しく入力してください。',
            'lastNameKana.required' => ':attributeを入力してください。',
            'lastNameKana.string' => ':attributeを正しく入力してください。',
            'firstName.string' => ':attributeを正しく入力してください。',
            'firstNameKana.string' => ':attributeを正しく入力してください。',
            'email.required' => ':attributeを入力してください。',
            'email.email' => '正しい:attributeを入力してください。',
            'mobile.required_without' => ':attributeと固定電話番号のどちらかを入力してください。',
            'mobileTel.regex' => '正しい:attributeを入力してください。',
            'fixedTel.regex' => '正しい:attributeを入力してください。',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response['errors']  = $validator->errors()->all();
        throw new HttpResponseException(response()->json($response, 422));
    }
}
