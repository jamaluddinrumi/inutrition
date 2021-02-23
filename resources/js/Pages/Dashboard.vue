<template>
    <layout>
        <v-row>
            <v-col>
                <graphic-card
                    :data="latestCalorieTestedData.data"
                    :labels="latestCalorieTestedData.labels"
                    :color="latestCalorieTestedData.color"
                    :title="latestCalorieTestedData.title"
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

    mounted() {
        axios
            .get(route("nutrition.latestCalorieCheckedTrend"))
            .then(function (response) {
                // console.log(this);
                // this.latestCalorieTestedData.data = response.data;
            })
            .catch(function (error) {
                console.error(error);
            })
            .then();
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
        latestCalories: {
            type: Object,
        }
    },

    data() {
        return {
            latestCalorieTestedData: {
                id: 0,
                data: this.latestCalories.value,
                labels: this.latestCalories.labels,
                color: "green",
                title: this.$vuetify.lang.t(
                    "$vuetify.latestCalorieTestedTrend"
                ),
            },
        };
    },

    computed: {},

    watch: {},

    methods: {},
};
</script>
