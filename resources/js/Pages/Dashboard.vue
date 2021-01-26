<template>
    <layout>
        <calories-table :customers="customers"></calories-table>
    </layout>
</template>
<script>
import Layout from "@/Layouts/Layout";
import CaloriesTable from "@/Components/Table/Calories";

export default {
    components: {
        Layout,
        CaloriesTable,
    },
    props: {
        currentRouteName: {
            type: String,
        },
        errorBags: {
            type: Array,
        },
        errors: {
            type: Object,
        },
        jetstream: {
            type: Object,
        },
        user: {
            type: Object,
        },
        customers: {
            type: Array,
        },
    },
    data() {
        return {};
    },
    computed: {},
    watch: {},
    created() {},
    methods: {},
};
</script>
