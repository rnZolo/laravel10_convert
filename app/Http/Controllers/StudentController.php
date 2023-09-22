<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StudentInformation;
use App\Models\Student;
use Inertia\Inertia;

class StudentController extends Controller{
    protected $status;

    public function index(Request $request){

        if($request->all() == null){
            $filter = 'all';
        }else{
            $request->data['student_filter'] == 'Select Type' ? 
                $filter = 'all':
                $filter = $request->data['student_filter'];
        }
        
        if($filter == 'all' ){
            $student_list = Student::latest()->get()->toArray();
        }
        else{
            $student_list = Student::where('student_type', $filter)->
                                            latest()->get()->toArray();
        }
    
            return Inertia::render('index', [
                    'student_list'=> $student_list, 'filter' => $filter]);
    }

    public function create(){
        $nextId = Student::select('id_number')->orderBy('id_number', 'desc')->limit(1)->get()->toArray();
        return Inertia::render('create',['method' => 'post', 'student' => $nextId
        ], 200);
    }

    public function store(StudentInformation $request){
        $student = new Student($request->all());
        $student->save();
        return redirect('/create');
    }

    public function edit($id){
    
        // fetch user data
        return Inertia::render('Edit',['method' => 'put', 
                                'student' => Student::findOrFail(request()->id)->toArray()], 200);
    }

    public function update(StudentInformation $request){
        Student::findOrFail($request->id)->update($request->all());
    }

    public function destroy(){
        Student::where('id',request()->id)->delete();
    }
    
    public function multiDestroy(Request $request){
        if(count($request->ids) > 1){
            Student::whereIn('id',$request->ids)->delete();
        }
        return back();
    }
}
