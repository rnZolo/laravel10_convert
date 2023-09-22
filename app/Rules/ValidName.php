<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Student;

class ValidName implements ValidationRule
{
    
    protected $message = ':attribute already exist' ;
    protected $student;

    public function validate($attribute, $value, $fail)
    {
        // check what request method PUT/Update POST/store assign values base from it
        if(request()->method() == 'PUT'){
            $query_values = [$value, request()->old_id_number];
            $this->student = Student::whereRaw('name = ? and not id_number = ?',
                                            $query_values)->get();

        }else if(request()->method() == 'POST'){
            $this->student = Student::where('name', $value)->get();
        }

            if(!preg_match('/^[A-Za-z. ]+$/', $value)){
                $fail(':attribute with invalid characters.');
            }

            // name exist with the same number
            if(($count = $this->student->count()) >= 1){ // same name checking
                $valid = $this->checkNumber($this->student, request('mobile_number'), $count);
                if(!$valid){    
                    $fail(':attribute with same number exist.');
                } 

            }
    }


    protected function checkNumber(Object $obj, $mobile_number, $count){
        $record = $obj->toArray();
        for($c = 0; $c < $count; $c++){
            if($record[$c]['mobile_number'] == $mobile_number){
                $this->message = ':attribute exist with the same Mobile Number';
                return false;
            }
        }
        
        return true;
    }
}
