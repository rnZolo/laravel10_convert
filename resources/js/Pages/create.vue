<script >
    import FormStudent from './components/FormStudent.vue';
    import Layout from './layout';
    // import { Head } from '@inertiajs/vue3';

    export default{
        components :{FormStudent , Layout},
            props:{
                method : String,
                student: Array
            }
        }

</script>

<template>
     <!-- {{ mess }} -->
     <title>Student | Enroll</title>
   <Layout>
    <!-- <Head title="Enroll Student" /> -->
        <div class="min-w-full min-h-full">
            <FormStudent :method="method" :student="student"/>
        </div>
    </Layout>
</template>