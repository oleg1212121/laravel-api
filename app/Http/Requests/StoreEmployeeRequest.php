<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEmployeeRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|max:255',
            'middle_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'gender' => 'sometimes|required|in:'. implode(', ', array_keys(Employee::GENDER_TYPES)),
            'salary' => 'required|integer',
            'departments' => 'required|array|min:1',
            'departments.*' => 'distinct|exists:departments,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.*' => 'Поле "Имя" обязательно для заполнения, должно быть меньше 255 символов.',
            'middle_name.*' => 'Поле "Отчество" обязательно для заполнения, должно быть меньше 255 символов.',
            'last_name.*' => 'Поле "Фамилия" обязательно для заполнения, должно быть меньше 255 символов.',
            'gender.*' => 'Поле "Пол" обязательно для заполнения.',
            'salary.*' => 'Поле "Зарплата" обязательно для заполнения, должно быть целым числом.',
            'departments.*' => 'Поле "Отделы" обязательно для заполнения.',
            'departments.*.*' => ' "Отделы" должны соответствовать существующим значениям.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
