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