<script setup>
    import { Link, router } from '@inertiajs/vue3'
    const filter = defineProps(['student_list', 'filter']);

    function onChange(event){
        // console.log(event.target.value);
        router.get('/',{
            data: {
                student_filter:event.target.value ?? 'all'
            }
        });
    }
    function edit(id){
        // alert(id);
        router.get(`/edit/${id}`,{
            onSuccess: () => {
                swal('Updated', 'Student Updated', 'success');
            },  
            onError: () => {
                swal('Unable to Update', 'Something happen', 'error');
            },
            preserveScroll: true
        });
    }
    function destroy(id){
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'red',
        cancelButtonColor: 'blue',
        confirmButtonText:'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            router.delete('/destroy',{
            data: {
                id:id
            },
            onSuccess: () => {
                swal('Deleted', 'Student Removed', 'success');
                toastify('Delete Successfull', 'success');
            },
            onError: () => {
                swal('Unable to Delete', 'Something happen', 'error');
                toastify('Unable to Delete', 'error');
            }, 
            preserveState: false,
            preserveScroll: true  
        })
        }
        })   

    }
    function mulDestroy(){
        let ids = mapSelected();
        if(ids.length <= 1){
            swal('Unable to Delete', 'selected must be > 2', 'error');
        }else{
            sweetAlert('Delete all Selected?', 'del', 'Delete All', delSel);   
        } 
    }
    function delSel(){
            let ids = mapSelected()
            router.delete('/multi_destroy',{
            data: {
                ids:ids
            },
            onSuccess: () => {
                swal('Deleted', 'Student Removed', 'success');
                toastify('Delete Successfull', 'success');
            },
            onError: () => {
                swal('Unable to Delete', 'Something happen', 'error');
                toastify('Unable to Delete', 'error');
            },  
            preserveState: false,
            preserveScroll: true
        })
        
    }
    function mapSelected(){
        let checked = document.querySelectorAll('.table-cb > .cb:checked')
        let ids=[];
        checked.forEach((e)=>{
        let tr = e.closest('tr');
        if(!tr.classList.contains('hidden')){
            ids.push(e.id);
        }
        });
        return ids;
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
    function sweetAlert(text, proc, confirmText, callb){
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
            callb();
            allCheckedIs(false);
        }
        })   
    }
    function swal(text, text2, icon){
        Swal.fire(
                text, // 'Deleted!',
               text2, //  'Your file has been deleted.',
                icon // 'success'
                )
    }
    function allCheckedIs(bol){
        if(!bol){
            let checked = document.querySelectorAll('.table-cb > .cb:checked');
            checked.forEach((e) => {
                let tr =e.closest("tr");
                if(!tr.classList.contains('hidden')){
                    e.checked = false;
                }
            })
        }else{
            let checked = document.querySelectorAll('.table-cb > .cb:not(:checked)');
            checked.forEach((e) => {
                let tr =e.closest("tr");
                if(!tr.classList.contains('hidden')){
                    e.checked = true;
                }
            })
        }  
    }
    function refreshPage(){
        let selSearch = document.querySelector('.filter-st');
        router.get('/', {
            data :{
                student_filter:selSearch.value ?? 'all'
            }
        });
    }
    function search(event){ 
        
        let tr = document.querySelectorAll('tbody tr');
            tr.forEach((trID_Number)=>{
            let id_num = trID_Number.childNodes[2].innerText;
            console.log(trID_Number.childNodes[2].innerText);
            let name = trID_Number.childNodes[1].childNodes[0].childNodes[1].innerText;
            let toLook = new RegExp(event.target.value, "i");
            if((!toLook.test(id_num)) & (!toLook.test(name))){
                trID_Number.classList.add('hidden');
            }else{
                trID_Number.classList.remove('hidden');
            }
        });

    }
</script>
<template>
    <div class="overflow-x-auto mx-[5%] z-10s">
        <div class="flex w-full items-center">
            <Link href="/create" as="button" type="button" class="btn bg-green-800 hover:bg-green-600 text-white mr-5">Enroll Student</Link>
            <div class="flex gap-3 justify-start mr-auto items-center">
                <input type="text" placeholder="ID Number | Name" class="search-inp input input-bordered w-full max-w[300px]" @input="search($event)" />
            </div> 
        <button type="button" class="btn btn-sm mx-5 bg-blue-900 hover:bg-blue-500 text-white ml-auto" @click="refreshPage()">Refresh</button>
        <select :value="filter.filter" class="select select-bordered w-full max-w-[200px] filter-st" @change="onChange($event)">
            <option selected disabled>Select Type</option>
            <option value="all">All</option>
            <option value="local">Local</option>
            <option value="foreign">Foreign</option>
        </select>
        </div>
  <table class="table">
        <thead>
        <tr>
            <th>
            <label>
                <!-- <input type="checkbox" class="checkbox" /> -->
                <div class="dropdown dropdown-right">
                    <label tabindex="0" class="btn btn-sm m-1 bg-amber-400 hover:bg-amber-600 ">Selected</label>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52 flex flex-col gap-3">
                        <li @click="allCheckedIs(true)" class="rounded-box bg-green-900 text-white hover:bg-green-500 p-2">Select All</li>
                        <li @click="allCheckedIs(false)" class="rounded-box bg-blue-900 text-white hover:bg-blue-500 p-2">UnSelect</li>
                        <li @click="mulDestroy()" class="rounded-box bg-red-900 text-white hover:bg-red-500 p-2">Delete Selected</li>
                    </ul>
                </div>
            </label>
            </th>
            <th>Name</th>
            <th>ID number</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Contacts</th>
            <th>Address</th>
            <th>Grades</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody >
        <!-- row 1 -->
        <tr v-for="student in student_list">
            <th class=''>
                <label class="table-cb w-full h-full flex justify-center">
                    <input type="checkbox" class="checkbox cb " :id="student.id"/>
                </label>
            </th>
            <td>
            <div class="flex items-center space-x-3 relative">
                    <span class="badge badge-ghost badge-sm absolute -top-5">{{ student.student_type }}</span>
                    <div class="font-bold">{{ student.name }}</div>
            </div>
            </td>
            <td>
                {{ student.id_number }}
            </td>
            <td>
                {{ student.age }}
            </td>
            <td>{{ student.gender }}</td>
            <td>
                {{ student.mobile_number }}
                <br>
                <span class="badge badge-ghost badge-sm">{{ student.email }}</span>
            </td>
            <td>
                <div class="text-sm opacity-50">{{ student.city }}</div>
            </td>
            <td>{{ student.grades }}</td>
            <th class="flex gap-3 justify-center">
            <button class="btn bg-blue-800 hover:bg-blue-700 text-white" @click="edit(student.id)">Edit</button>
            <button   class="btn bg-red-800 hover:bg-blue-700 text-white " @click="destroy(student.id)">Delete</button>
            </th>
        </tr>
        </tbody>
        <!-- foot -->
        <tfoot v-if="student_list > 1">
            <tr>
                <th></th>
                <th>Name</th>
                <th>ID number</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Contacts</th>
                <th>Address</th>
                <th>Grades</th>
                <th></th>
            </tr>
            </tfoot>
    </table>
    <div class="grid place-content-center text-center w-full h-[200px] relative" v-if="student_list < 1">
    <span class="text-2xl font-bold">NO RECORD</span>
    </div>
</div>
</template>
