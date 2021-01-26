<template>
    <layout>
        <div class="text-h4 mt-6 mb-4">Customers</div>
        <calories-table :customers="customers"></calories-table>
        <div class="text-h4 mt-6 mb-4">Staffs</div>
        <v-row>
            <v-col v-for="user_item in users" :key="user_item.id"
                ><contact-card :user="user_item"></contact-card
            ></v-col>
        </v-row>
    </layout>
</template>
<script>
import Layout from "@/Layouts/Layout";
import CaloriesTable from "@/Components/Table/Calories";
import ContactCard from "@/Components/Card/Contact";

export default {
    components: {
        Layout,
        CaloriesTable,
        ContactCard,
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
        users: {
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
