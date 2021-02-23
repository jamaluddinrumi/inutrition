<template>
    <v-card class="mx-auto text-center">
        <v-card-text>
            <v-sheet
                class="v-sheet--offset mx-auto"
                :color="color"
                elevation="12"
                max-width="calc(100% - 32px)"
            >
                <v-sparkline
                    :labels="labels"
                    :value="data"
                    auto-line-width
                    color="white"
                    height="100"
                    width="500"
                    padding="24"
                    stroke-linecap="round"
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
            <inertia-link href="/nutrition" class="no-underline">
                <v-btn text block class="text-decoration-none" elevation="2">
                    <v-icon small class="mr-2">fas fa-table</v-icon>
                    <span class="text-button">{{
                        $vuetify.lang.t("$vuetify.readMore")
                    }}</span></v-btn
                >
            </inertia-link>
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
        labels: {
            type: Array,
        },
    },
};
</script>

<style>
.v-sheet--offset {
    top: -24px;
    position: relative;
}
</style>