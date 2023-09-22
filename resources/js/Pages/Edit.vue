<script >
        import FormStudent from './components/FormStudent.vue';
        import Layout from './layout';
        // import { Head } from '@inertiajs/vue3';

        export default{
            components :{FormStudent , Layout },
            props:{
                method : String,
                student : Object
            }
        }
</script>

<template>
     <!-- <Head title="Edit Student" /> -->
     <title>Student | Edit</title>
    <Layout>
        <div class="min-w-full min-h-full">
            <FormStudent :method="method" :student="student"/>
        </div>
    </Layout>
</template>


<style lang="scss" scoped>

</style>