<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Illuminate\Validation\Rule;
use App\Rules\ValidName;
use App\Rules\ValidNumber;

class StudentInformation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       
        $method = request()->method();
        // dd($method);
        // dd(request());
        return [
                'student_type' => [
                    'bail', 'required',
                    Rule::in(['local', 'foreign']),
                    ],
                'id_number' => $method == 'POST' ? 
                        'bail|required|integer|digits_between:1,5|min:0|
                        unique:App\Models\Student,id_number' :
                        [
                            'required', 'numeric', 'digits_between:1,5', 'min:0',
                            Rule::unique(Student::class)->ignore(request()->id, 'id'),
                    ],
                'name' => ['bail', 'required', 'string', 'max:30', 'min:2', 
                            $method == 'POST' ? 
                            Rule::unique('student', 'name')
                            ->where('mobile_number', request()->mobile_number):                             
                            Rule::unique('student', 'name')
                            ->where('mobile_number', request()->mobile_number)
                            ->ignore(request()->name, 'name'),
                    ],
                'age' => ['bail','required','numeric','min:7', 'max:150'],
                'city' => 'bail|required|string|max:150',
                'mobile_number' => ['bail', 'required','regex:/^63[9]\d{9}$/',
                            $method == 'POST' ?
                            Rule::unique('student', 'mobile_number')
                            ->where('name', request()->name):
                            Rule::unique('student', 'mobile_number')
                            ->where('name', request()->name)
                            ->ignore(request()->mobile_number, 'mobile_number'),
                    ],
                'email' => 'bail|required|email:dns',
                'grades' => "nullable|bail|numeric|between:75,99.99|regex:/^[0-9]*(\.[0-9]{0,2})?$/",
                ];
    }

    public function messages(){
        return [
            'name.unique' => 'Name exist with the same number.',
            'id_number.unique' => 'Id number has been used.',
            'mobile_number.unique' => 'Mobile number registered with the same name.',
            'id_number.integer' => "ID number shouldn't start with 0",
            'id_number.digits_between' => 'ID number is 1 - 5 digits only',
            'mobile_number.regex'=> 'Mobile number must start with 63 and 12 digits',
            'grades.regex'=> 'Max decimal is 2',
            
        ];
    }
}
