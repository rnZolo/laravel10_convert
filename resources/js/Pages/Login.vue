<script setup>
import { useForm } from '@inertiajs/vue3';
import Layout from './layout';
    const errorMess = defineProps(['errors']);
    let form = useForm({
        email: null,
        password: null
    });
    function login(){
        form.submit('post', '/login_auth', {
            onError:()=>{
                if(errorMess.errors.mess){
                    toastify(errorMess.errors.mess,'error')
                }
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
</script>
<template>
    <Layout>
        <div class="w-full h-full px-[5%] relative grid place-content-center">
        <div class="max-w-full min-w-[500px] overflow-hidden border-1 shadow-lg shadow-black-500 p-[50px] pt-[30px]">
            <h2 class="font-bold text-xl my-1">Login</h2>
                <form class=" add-stud-form flex flex-col gap-8" @submit.prevent="login()" id='login_form'>
                <div class="flex w-full gap-8">
                    <div class="flex flex-col w-full gap-5 rel-label">
                        <label for="email"><span class=" min-w-[150px] text-right flex flex-col">E-mail :  </span>
                            <div class="flex flex-col w-full">
                                <input type="text" name="email" id="email" 
                                v-model="form.email" class="input input-bordered w-full max-w-xs block min-w-[200px]">
                                <span v-if="form.errors.email" class="text-[13px] m-0 p-0 font-bold text-red-500     ">
                                    {{ form.errors.email }}
                                </span>
                            </div>
                        </label>
                        <label for="password"><span class="min-w-[150px] text-right flex flex-col">password :  </span>
                            <div class="flex flex-col w-full">
                                <input type="text" name="password" id="password" 
                                v-model="form.password" class="input input-bordered w-full max-w-xs block min-w-[200px]">
                                <span v-if="form.errors.password" class="text-[13px] m-0 p-0 font-bold text-red-500     ">
                                    {{ form.errors.password }}
                                </span>
                            </div>
                        </label>
                    </div>
                </div>
                <button type="submit" :disabled="form.processing" class="btn bg-green-700 hover:bg-green-400 text-white ml-auto">
                    <span>Login</span>
                </button>
            </form>
        </div>
    </div>
    </Layout>
</template>