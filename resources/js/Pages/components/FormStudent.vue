<script setup >
import { router, useForm } from '@inertiajs/vue3';

    const data = defineProps(['method', 'student']);
    let method = data.method;
    let form;
    if(method == 'post'){
        let nextId = data.student[0].id_number + 1;
        form = useForm({ 
                    student_type: null,
                    id_number: nextId,
                    name: null,
                    age: null,
                    city: null,
                    gender: null,
                    mobile_number: `63950345${nextId}`,
                    grades: null,
                    email: null 
        });
    }
    if(method == 'put'){
        form = useForm({ 
                    id: data.student.id,
                    student_type: data.student.student_type,
                    id_number: data.student.id_number,
                    name: data.student.name,
                    age: data.student.age,
                    city: data.student.city,
                    gender: data.student.gender,
                    mobile_number: data.student.mobile_number,
                    grades: data.student.grades,
                    email: data.student.email,
        });
    }  
        
     function submitForm(method) {

            let endpoint,
                formMethod = method;

            if(method == 'post'){
                endpoint = '/store';
              sweetAlert(formMethod, endpoint, method, 'Enroll this Student', 'Add', 
                    'Enroll', 'Successfully Enrolled', 'Student has been added', 'success');
            }
            if(method == 'put'){
                endpoint = '/update';
                sweetAlert(formMethod, endpoint, method, 'Update this Student', 'Add', 
                    'Update', 'Successfully Updated', 'Student has been updated', 'info');
            }
            
    }
    function home(){
        router.get('/',{
            data: {
                student_filter:'all'
            }
        });
    }
    function toastify(text,type){
        Toastify({
        text: text,
        duration: 3000,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: type == 'success'? 'green': 'red',
        },
        onClick: function(){} // Callback after click
        }).showToast();
    }
    function sweetAlert(formMethod, endpoint, method, 
                        text, proc, confirmText, btntext, confirmText2, status){
        Swal.fire({
        title: 'Are you sure?',
        text: text, //  "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: proc == 'Add'? 'green': 'red',
        cancelButtonColor: proc == 'Add'? '#d33' : 'yellow',
        confirmButtonText: confirmText, // 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            form.submit(formMethod, endpoint, {
                    preserveStates: true,
                    onSuccess: () => {
                        form.reset();
                        if(method == 'post'){
                            // router.get('/create');
                            Swal.fire(
                            btntext, // 'Deleted!',
                            confirmText2, //  'Your file has been deleted.',
                            status // 'success'
                            )
                            toastify('Student Enrolled', 'success')
                            router.get('/create');
                        }
                        if(method == 'put'){
                            Swal.fire(
                            btntext, // 'Deleted!',
                            confirmText2, //  'Your file has been deleted.',
                            status // 'success'
                            )
                            toastify('Student Updated', 'success')
                            home();
                        }
                    },
                    onError: (errors) => {
                        if(method == 'post'){
                            toastify('Failed to Enrolled', 'error')
                        }
                        if(method == 'put'){
                            toastify('Failed to Updated', 'error')
                        }
                    },
                })
        }

        })   
    }

    console.log(data)
</script>

<style scoped>

</style>
<template>
    <div class="w-full h-full px-[5%] relative">
        <div class="overflow-hidden border-1 border-slate-500 shadow-lg shadow-black-500 px-[5%] py-[50px] rounded-box">
            <h2 v-if="method == 'put'" class="font-bold text-xl my-5">Edit Information</h2>
            <h2 v-else-if="method == 'post'" class="font-bold text-xl my-5">Add Student</h2>
                <form class=" add-stud-form flex flex-col gap-8" @submit.prevent="submitForm(method)" id='student_form'>
                <div class="flex w-full gap-8">
                    <div class="flex flex-col max-w-50%[] w-full gap-5 rel-label">
                        <label for="student_type"><span class="min-w-[150px] text-right flex flex-col">Student Type : </span>
                            <div class="flex flex-col w-full">
                                <select name="student_type" id="student_type"       
                                v-model="form.student_type" class="select select-bordered w-full max-w-xs block">
                                <option value=""></option>
                                <option value="local" >Local</option>
                                <option value="foreign" >Foreign
                                </option>
                            </select>
                                <span v-if="form.errors.student_type" class="text-[13px] m-0 p-0 font-bold text-red-500     ">
                                    {{ form.errors.student_type }}
                                </span>
                            </div>
                        </label>
                        <label for="id_number"><span class="min-w-[150px] text-right flex flex-col">ID Number :  </span>
                            <div class="flex flex-col w-full">
                                <input type="text" name="id_number" id="id_number"
                                v-model="form.id_number" class="input input-bordered w-full max-w-xs block">
                                <span v-if="form.errors.id_number" class="text-[13px] m-0 p-0 font-bold text-red-500     ">
                                    {{ form.errors.id_number }}
                                </span>
                            </div>
                        </label>
                        <label for="name"><span class="min-w-[150px] text-right flex flex-col">Name :  </span>
                            <div class="flex flex-col w-full">
                                <input type="text" name="name" id="name" 
                                v-model="form.name" class="input input-bordered w-full max-w-xs block">
                                <span v-if="form.errors.name" class="text-[13px] m-0 p-0 font-bold text-red-500     ">
                                    {{ form.errors.name }}
                                </span>
                            </div>
                        </label>
                        <label for="age"><span class="min-w-[150px] text-right flex flex-col">Age :  </span>
                            <div class="flex flex-col w-full">
                                <input type="text" name="age" id="age" 
                                v-model="form.age" class="input input-bordered w-full max-w-xs block">
                                <span v-if="form.errors.age" class="text-[13px] m-0 p-0 font-bold text-red-500     ">
                                    {{ form.errors.age }}
                                </span>
                            </div>
                        </label>
                        <label for="gender"><span class="min-w-[150px] text-right flex flex-col">Gender :  </span>
                            <div class="flex flex-col w-full">
                                <select name="gender" id="gender"
                                v-model="form.gender" class="select select-bordered w-full max-w-xs block">
                                <option value=""></option>
                                <option value="male" >Male</option>
                                <option value="female" >Female</option>
                            </select>
                            <span v-if="form.errors.gender" class="text-[13px] m-0 p-0 font-bold text-red-500     ">
                                    {{ form.errors.gender }}
                                </span>
                            </div>
                        </label>
                    </div>
                    <div class="flex flex-col max-w-50%[] w-full gap-5">
                        <label for="city"><span class="min-w-[150px] text-right flex flex-col">City :  </span>
                            <div class="flex flex-col w-full">
                                <input type="text" name="city" id="city" 
                                v-model="form.city" class="input input-bordered w-full max-w-xs block">
                                <span v-if="form.errors.city" class="text-[13px] m-0 p-0 font-bold text-red-500     ">
                                    {{ form.errors.city }}
                                </span>
                            </div>
                        </label>
                        <label for="mobile_number"><span class="min-w-[150px] text-right flex flex-col">Mobile Number :  </span>
                            <div class="flex flex-col w-full">
                                <input type="text" name="mobile_number" id="mobile_number"
                                v-model="form.mobile_number" class="input input-bordered w-full max-w-xs block">
                                <span v-if="form.errors.mobile_number" class="text-[13px] m-0 p-0 font-bold text-red-500      ">
                                    {{ form.errors.mobile_number }}
                                </span>  
                            </div> 
                        </label>
                        <label for="email"><span class=" min-w-[150px] text-right flex flex-col">E-mail :  </span>
                            <div class="flex flex-col w-full">
                                <input type="text" name="email" id="email" 
                                v-model="form.email" class="input input-bordered w-full max-w-xs block">
                                <span v-if="form.errors.email" class="text-[13px] m-0 p-0 font-bold text-red-500     ">
                                    {{ form.errors.email }}
                                </span>
                            </div>
                        </label>
                        <label for="grades"><span class="min-w-[150px] text-right flex flex-col">Grades :  </span>
                            <div class="flex flex-col w-full">
                                <input type="text" name="grades" id="grades" 
                                v-model="form.grades" class="input input-bordered w-full max-w-xs block">
                                <span v-if="form.errors.grades" class="text-[13px] m-0 p-0 font-bold text-red-500     ">
                                    {{ form.errors.grades }}
                                </span>
                            </div>
                        </label>
                    </div>
                </div>
                <button type="submit" :disabled="form.processing" class="btn bg-green-700 hover:bg-green-400 text-white ml-auto">
                    <span v-if="method == 'post'"> Create Student</span>
                    <span v-else-if="method == 'put'">Apply Changes</span>
                </button>
            </form>
        </div>
    </div>
</template>