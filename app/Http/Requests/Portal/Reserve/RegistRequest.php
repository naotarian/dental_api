<?php

namespace App\Http\Requests\Portal\Reserve;

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
            'examination' => ['required', 'string'],
            'medicalHopeId' => ['required'],
            'sex' => ['required'],
            'year' => ['required'],
            'month' => ['required'],
            'day' => ['required'],
            'lastName' => ['required'],
            'lastNameKana' => ['required', 'regex:/[ァ-ヴー]+/u'],
            'firstName' => ['required'],
            'firstNameKana' => ['required', 'regex:/[ァ-ヴー]+/u'],
            'email' => ['required', 'email'],
            'reserveDay' => ['required'],
            'reserveTime' => ['required'],
            'remark' => ['max:3000'],
            'mobile' => ['required_without:fixed', 'nullable', 'regex:/^(0{1}\d{1,4}-{0,1}\d{1,4}-{0,1}\d{4})$/'],
            'fixed' => ['nullable', 'regex:/^(0{1}\d{1,4}-{0,1}\d{1,4}-{0,1}\d{4})$/'],
        ];
    }

    public function attributes()
    {
        return [
            'examination' => '当院での受診',
            'medicalHopeId' => '診療希望内容',
            'sex' => '性別',
            'year' => '生年月日(年)',
            'month' => '生年月日(月)',
            'day' => '生年月日(日)',
            'lastName' => '姓',
            'lastNameKana' => '姓(フリガナ)',
            'firstName' => '名',
            'firstNameKana' => '名(フリガナ)',
            'email' => 'メールアドレス',
            'reserveDay' => '予約日',
            'reserveTime' => '予約時間',
            'remark' => '備考',
            'mobile' => '携帯電話番号',
            'fixed' => '固定電話番号',
        ];
    }

    public function messages()
    {
        return [
            'examination.required' => ':attributeを選択してください。',
            'medicalHopeId.required' => ':attributeを選択してください。',
            'sex.required' => ':attributeを選択してください。',
            'year.required' => ':attributeを選択してください。',
            'month.required' => ':attributeを選択してください。',
            'day.required' => ':attributeを選択してください。',
            'lastName.required' => ':attributeを入力してください。',
            'lastNameKana.required' => ':attributeを入力してください。',
            'lastNameKana.regex' => ':attributeはカタカナで入力してください。',
            'firstName.required' => ':attributeを入力してください。',
            'firstNameKana.required' => ':attributeを入力してください。',
            'firstNameKana.regex' => ':attributeはカタカナで入力してください。',
            'email.required' => ':attributeを入力してください。',
            'email.email' => '正しい:attributeを入力してください。',
            'reserveDay.required' => ':attributeを選択してください。',
            'reserveTime.required' => ':attributeを選択してください。',
            'remark.max' => ':attributeは3000文字以内で入力してください。',
            'mobile.required_without' => ':attributeと固定電話番号のどちらかを入力してください。',
            'mobile.regex' => '正しい:attributeを入力してください。',
            'fixed.regex' => '正しい:attributeを入力してください。',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response['errors']  = $validator->errors()->all();
        throw new HttpResponseException(response()->json($response, 422));
    }
}
