<template>
    <v-data-table
        :headers="headers"
        :items="customersNutritions"
        :items-per-page="itemsPerPage"
        sort-by="name"
        class="elevation-1"
        :loading="isLoading"
        :search="search"
    >
        <template v-slot:item.downloadSummary="{ item }">
            <v-btn
                icon
                color="primary"
                class="elevation-1"
                :href="route('dashboard.generate', item.id)"
            >
                <v-icon small>fa-file-word</v-icon>
            </v-btn>
        </template>
        <template v-slot:no-data>
            <v-btn
                rounded
                color="primary"
                class="text-button"
                @click="loadingData"
            >
                <v-icon small class="mr-2">fas fa-redo</v-icon>
                {{ $vuetify.lang.t("$vuetify.reload") }}
            </v-btn>
        </template>
    </v-data-table>
</template>
<script>
export default {
    mounted() {
        this.loadingData();
    },
    props: {
        itemsPerPage: {
            type: Number,
            default: "10"
        }
    },
    data() {
        return {
            search: "",
            isLoading: false,
            dialog: false,
            dialogDelete: false,
            editedIndex: -1,
            editedItem: {
                name: "",
                calories: 0,
                fat: 0,
                carbs: 0,
                protein: 0
            },
            defaultItem: {
                name: "",
                calories: 0,
                fat: 0,
                carbs: 0,
                protein: 0
            },
            customersNutritions: []
        };
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "Tambah Item" : "Ubah Item";
        },
        headers() {
            return [
                {
                    text: this.$vuetify.lang.t("$vuetify.name"),
                    align: "start",
                    value: "name"
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.calories") + " (cal)",
                    value: "calories"
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.fat") + " (g)",
                    value: "fat"
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.carbs") + " (g)",
                    value: "carbs"
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.protein") + " (g)",
                    value: "protein"
                },
                {
                    text: this.$vuetify.lang.t(
                        "$vuetify.nutrition.downloadSummary"
                    ),
                    // sortable: false,
                    value: "downloadSummary"
                }
            ];
        }
    },
    watch: {
        dialog(val) {
            val || this.close();
        },
        dialogDelete(val) {
            val || this.closeDelete();
        }
    },
    methods: {
        loadingData() {
            let self = this;
            self.customersNutritions = [];
            self.isLoading = true;

            axios
                .get(route("customer.index"))
                .then(function(response) {
                    // console.log(response);

                    response.data.forEach(customer => {
                        if (customer.nutrition) {
                            self.customersNutritions.push({
                                id: customer.nutrition
                                    ? customer.nutrition.id
                                    : null,
                                name:
                                    customer.first_name +
                                    " " +
                                    customer.last_name,
                                calories: customer.nutrition
                                    ? customer.nutrition.calories
                                    : null,
                                fat: customer.nutrition
                                    ? customer.nutrition.fat
                                    : null,
                                carbs: customer.nutrition
                                    ? customer.nutrition.carbs
                                    : null,
                                protein: customer.nutrition
                                    ? customer.nutrition.protein
                                    : null
                            });
                        }
                    });
                })
                .catch(function(response) {
                    console.error(response);
                })
                .then(function() {
                    self.isLoading = false;
                });
        },

        editItem(item) {
            this.editedIndex = this.customersNutritions.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            this.editedIndex = this.customersNutritions.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },

        deleteItemConfirm() {
            this.customersNutritions.splice(this.editedIndex, 1);
            this.closeDelete();
        },

        close() {
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        closeDelete() {
            this.dialogDelete = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        save() {
            if (this.editedIndex > -1) {
                Object.assign(
                    this.customersNutritions[this.editedIndex],
                    this.editedItem
                );
            } else {
                this.customersNutritions.push(this.editedItem);
            }
            this.close();
        }
    }
};
</script>
<style>
[type="text"],
[type="email"],
[type="url"],
[type="password"],
[type="number"],
[type="date"],
[type="datetime-local"],
[type="month"],
[type="search"],
[type="tel"],
[type="time"],
[type="week"],
[multiple],
textarea,
select {
    @apply ring-0;
    @apply bg-transparent;
}
.v-data-table-header th.sortable {
    white-space: nowrap;
}
</style>
