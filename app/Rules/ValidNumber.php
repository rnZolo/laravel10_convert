<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Student;

class ValidNumber implements ValidationRule
{
    protected $message = 'Mobile Number has been used twice';
    protected $student;

    /**
     * Create a new rule instance.
     *
     * @return void
     */

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(request()->method() == 'PUT'){
            // exclude tha record to be updated then get the result
            $query_values = [$value, request()->old_id_number];

            $this->number_local = Student::whereRaw('mobile_number = ? and not id_number = ?',
                                        $query_values)->get();

        }else if(request()->method() == 'POST'){
            $this->student = Student::where('mobile_number', $value)->get();
        }

        // if number exist once check if same name
        if($this->student->count() == 1){
            $valid = $this->checkName($this->number_local, request('name'));
            if(!$valid){
                $fail(':attribute with same name exist.');
            } 

        }

    }



    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    protected function checkName(Object $obj, $name){
        $valid = true;
        $record = $obj->toArray(); // [0 => values]
        $record = Arr::collapse($record); // [values]

        if(strtolower($record['name']) == strtolower($name)){  // offset error
            $this->message = 'Mobile Number exist with the same Name';
            $valid = false;
        }

        return $valid;
    }
}
