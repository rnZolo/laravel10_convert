<script >
import { router } from '@inertiajs/vue3';

    export default{
        props:{

        },
        methods:{
            create(){
                router.get('/admin/create');                                                                                                                                            
            },
            store(){
                router.get('/admin/store');    
            }
        },
        // setup: ()=>{

        // }
    }
</script>

<style lang="scss" scoped>

</style>

<template>
    <div>
        <button class="btn" @click="create()">create</button>
        <button class="btn" @click="store()">Store</button>
    </div>
</template>