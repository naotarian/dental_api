<?php

namespace App\Http\Requests\Manage\Patient;

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
            'patientNumber' => ['required', 'string', 'unique:patients,patient_number'],
            'lastName' => ['required', 'string'],
            'lastNameKana' => ['required', 'string'],
            'firstName' => ['required', 'string'],
            'firstNameKana' => ['required', 'string'],
            'email' => ['nullable', 'email'],
            'birthYear' => ['nullable', 'integer'],
            'birthMonth' => ['nullable',],
            'birthDay' => ['nullable',],
            'remark' => ['nullable'],
            'gender' => ['nullable'],
            'mobileTel' => ['nullable', 'regex:/^(0{1}\d{1,4}-{0,1}\d{1,4}-{0,1}\d{4})$/'],
            'fixedTel' => ['nullable', 'regex:/^(0{1}\d{1,4}-{0,1}\d{1,4}-{0,1}\d{4})$/'],
        ];
    }

    public function attributes()
    {
        return [
            'patientNumber' => '診察券番号',
            'lastName' => '患者姓',
            'lastNameKana' => '患者姓(カナ)',
            'firstName' => '患者名',
            'firstNameKana' => '患者名(カナ)',
            'email' => '連絡先メールアドレス',
            'birthYear' => '生年月日(年)',
            'birthMonth' => '生年月日(月)',
            'birthDay' => '生年月日(日)',
            'remark' => '備考',
            'gender' => '性別',
            'mobileTel' => '携帯電話番号',
            'fixedTel' => '固定電話番号',
        ];
    }

    public function messages()
    {
        return [
            'patientNumber.required' => ':attributeを入力してください。',
            'patientNumber.unique' => 'この:attributeの患者様はすでに登録されています。',
            'lastName.required' => ':attributeを入力してください。',
            'lastName.string' => ':attributeを正しく入力してください。',
            'lastNameKana.required' => ':attributeを入力してください。',
            'lastNameKana.string' => ':attributeを正しく入力してください。',
            'firstName.required' => ':attributeを入力してください。',
            'firstName.string' => ':attributeを正しく入力してください。',
            'firstNameKana.required' => ':attributeを入力してください。',
            'firstNameKana.string' => ':attributeを正しく入力してください。',
            'email.required' => ':attributeを入力してください。',
            'email.email' => '正しい:attributeを入力してください。',
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
