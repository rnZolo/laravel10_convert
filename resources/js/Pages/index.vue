<script setup>
    import Layout from './layout';
    import Table from './components/Table';

    defineProps(['student_list', 'filter']);

</script>
<template>
      <title>Student | List</title>
    <Layout >
            <Table :student_list="student_list" :filter="filter"/>
    </Layout>
</template>