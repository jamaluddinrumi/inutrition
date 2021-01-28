<template>
    <v-data-table
        :headers="headers"
        :items="nutritions"
        :items-per-page="10"
        sort-by="name"
        class="elevation-1"
        :loading="isLoading"
        :search="search"
    >
        <template v-slot:top>
            <v-toolbar flat>
                <v-toolbar-title>{{
                    $vuetify.lang.t("$vuetify.nutritions")
                }}</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    :label="$vuetify.lang.t('$vuetify.search')"
                    single-line
                    hide-details
                    class="mr-4"
                >
                    <template v-slot:append>
                        <v-icon small>fas fa-search</v-icon>
                    </template>
                </v-text-field>
                <v-dialog v-model="dialog" max-width="600px">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            color="primary"
                            rounded
                            class="mb-2 font-bold"
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon small class="mr-2">fas fa-plus</v-icon>
                            {{ $vuetify.lang.t("$vuetify.addItem") }}
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            v-model="editedItem.name"
                                            label="Customer Name"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            v-model="editedItem.calories"
                                            label="Calories"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            v-model="editedItem.fat"
                                            label="Fat (g)"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            v-model="editedItem.carbs"
                                            label="Carbs (g)"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            v-model="editedItem.protein"
                                            label="Protein (g)"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                rounded
                                color="grey darken-1"
                                text
                                @click="close"
                                class="px-4"
                            >
                                {{ $vuetify.lang.t("$vuetify.cancel") }}
                            </v-btn>
                            <v-btn
                                rounded
                                color="primary"
                                class="font-bold px-4"
                                @click="save"
                            >
                                <v-icon small class="mr-2">fas fa-save</v-icon>
                                {{ $vuetify.lang.t("$vuetify.save") }}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-dialog v-model="dialogDelete" max-width="500px">
                    <v-card>
                        <v-card-title class="headline">{{
                            $vuetify.lang.t("$vuetify.youSure")
                        }}</v-card-title>
                        <v-card-text>
                            {{ $vuetify.lang.t("$vuetify.canNotBeUndone") }}
                        </v-card-text>
                        <v-card-actions>
                            <v-col>
                                <v-row justify="end">
                                    <v-btn
                                        color="blue darken-1"
                                        rounded
                                        text
                                        @click="closeDelete"
                                        >{{
                                            $vuetify.lang.t("$vuetify.cancel")
                                        }}</v-btn
                                    >
                                    <v-btn
                                        color="error"
                                        rounded
                                        class="px-4 ml-2 font-bold"
                                        @click="deleteItemConfirm"
                                        ><v-icon small class="mr-2"
                                            >fas fa-trash</v-icon
                                        >
                                        {{
                                            $vuetify.lang.t("$vuetify.delete")
                                        }}</v-btn
                                    >
                                </v-row>
                            </v-col>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-toolbar>
        </template>
        <template v-slot:item.actions="{ item }">
            <v-icon small color="primary" class="mr-2" @click="editItem(item)">
                fas fa-edit
            </v-icon>
            <v-icon small color="error" @click="deleteItem(item)">
                fas fa-trash
            </v-icon>
        </template>
        <template v-slot:no-data>
            <v-btn color="primary" class="font-bold" @click="loadingData">
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
    props: {},
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
                protein: 0,
            },
            defaultItem: {
                name: "",
                calories: 0,
                fat: 0,
                carbs: 0,
                protein: 0,
            },
            nutritions: [],
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
                    // sortable: false,
                    value: "name",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.calories") + " (cal)",
                    value: "calories",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.fat") + " (g)",
                    value: "fat",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.carbs") + " (g)",
                    value: "carbs",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.protein") + " (g)",
                    value: "protein",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.actions"),
                    value: "actions",
                    sortable: false,
                },
            ];
        },
    },
    watch: {
        dialog(val) {
            val || this.close();
        },
        dialogDelete(val) {
            val || this.closeDelete();
        },
    },
    methods: {
        loadingData() {
            let self = this;
            self.nutritions = [];
            self.isLoading = true;

            axios
                .get("/api/customer")
                .then(function (response) {
                    console.log(response);

                    response.data.forEach((customer) => {
                        self.nutritions.push({
                            name:
                                customer.first_name + " " + customer.last_name,
                            calories: customer.nutrition.calories,
                            fat: customer.nutrition.fat,
                            carbs: customer.nutrition.carbs,
                            protein: customer.nutrition.protein,
                        });
                    });
                })
                .catch(function (response) {
                    console.error(response);
                })
                .then(function () {
                    self.isLoading = false;
                });
        },

        editItem(item) {
            this.editedIndex = this.nutritions.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            this.editedIndex = this.nutritions.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },

        deleteItemConfirm() {
            this.nutritions.splice(this.editedIndex, 1);
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
                    this.nutritions[this.editedIndex],
                    this.editedItem
                );
            } else {
                this.nutritions.push(this.editedItem);
            }
            this.close();
        },
    },
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
</style>