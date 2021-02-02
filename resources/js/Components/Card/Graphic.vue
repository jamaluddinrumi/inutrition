<template>
    <v-card class="mx-auto text-center" :color="color" dark max-width="600">
        <v-card-text>
            <v-sheet color="rgba(0, 0, 0, .12)">
                <v-sparkline
                    :value="data"
                    color="rgba(255, 255, 255, .7)"
                    height="100"
                    padding="24"
                    stroke-linecap="round"
                    smooth
                >
                    <template v-slot:label="item"> {{ item.value }} </template>
                </v-sparkline>
            </v-sheet>
        </v-card-text>

        <v-card-text>
            <div class="display-1 font-weight-thin">{{ title }}</div>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions class="justify-center">
            <v-btn block text>
                <v-icon small class="mr-2">fas fa-table</v-icon>
                {{ $vuetify.lang.t("$vuetify.readMore") }}</v-btn
            >
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    props: {
        data: {
            type: Array,
        },
        color: {
            type: String,
            default: "primary",
        },
        title: {
            type: String,
            default: "",
        },
    },
};
</script>

<style>
</style>