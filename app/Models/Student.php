<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'student';

    protected $guarded = ['id'];

    protected $fillable = ['student_type', 'id_number',
                            'name', 'age', 'gender', 'city',
                            'mobile_number', 'email', 'grades'];

}
