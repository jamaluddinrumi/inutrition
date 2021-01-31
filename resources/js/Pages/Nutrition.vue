<template>
    <layout>
        <v-row>
            <v-col>
                <nutritions-table :items-per-page="25"></nutritions-table>
            </v-col>
        </v-row>
    </layout>
</template>
<script>
import Layout from "@/Layouts/Layout";
import NutritionsTable from "@/Components/Table/Nutritions"

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
        NutritionsTable,
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
