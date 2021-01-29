<template>
    <layout>
        <v-row>
            <v-col>
                <customers-table :items-per-page="25"></customers-table>
            </v-col>
        </v-row>
    </layout>
</template>
<script>
import Layout from "@/Layouts/Layout";
import CustomersTable from "@/Components/Table/Customers"

export default {
    title() {
        if (this.title) {
            let translationTitle = this.$vuetify.lang.t(
                "$vuetify.title." + this.title
            );
            if (translationTitle) {
                return translationTitle;
            } else {
                return _.capitalize(this.title);
            }
        }
    },

    components: {
        Layout,
        CustomersTable,
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
        title: {
            type: String,
        },
    },

    data() {
        return {};
    },

    computed: {},

    watch: {},

    methods: {},
};
</script>
