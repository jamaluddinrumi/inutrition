<template>
    <layout>
        <v-row>
            <v-col v-for="graphicData in graphicsData" :key="graphicData.id">
                <graphic-card
                    :data="graphicData.data"
                    :color="graphicData.color"
                    :title="graphicData.title"
                ></graphic-card>
            </v-col>
        </v-row>
        <div class="text-h4 mt-6 mb-4">
            {{ $vuetify.lang.t("$vuetify.customersNutrition") }}
        </div>
        <v-row>
            <v-col>
                <dashboard-customers-nutritions-table
                    :items-per-page="15"
                ></dashboard-customers-nutritions-table>
            </v-col>
        </v-row>
        <div class="text-h4 mt-6 mb-4">
            {{ $vuetify.lang.t("$vuetify.staffs") }}
        </div>
        <v-row>
            <v-col v-for="user_item in users" :key="user_item.id"
                ><contact-card :user="user_item"></contact-card
            ></v-col>
        </v-row>
    </layout>
</template>
<script>
import Layout from "@/Layouts/Layout";
import DashboardCustomersNutritionsTable from "@/Components/Table/DashboardCustomersNutritions";
import ContactCard from "@/Components/Card/Contact";
import GraphicCard from "@/Components/Card/Graphic";

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
        DashboardCustomersNutritionsTable,
        ContactCard,
        GraphicCard,
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
        title: {
            type: String,
        },
    },

    data() {
        return {
            graphicsData: [
                {
                    id: 0,
                    data: [423, 446, 675, 510, 590, 610, 760],
                    color: "green",
                    title: this.$vuetify.lang.t("$vuetify.positiveTrend"),
                },
                {
                    id: 1,
                    data: [760, 610, 590, 510, 675, 446, 423],
                    color: "red",
                    title: this.$vuetify.lang.t("$vuetify.negativeTrend"),
                },
            ],
        };
    },

    computed: {},

    watch: {},

    methods: {},
};
</script>
