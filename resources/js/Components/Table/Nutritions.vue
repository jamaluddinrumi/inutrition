<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="nutritions"
            :items-per-page="itemsPerPage"
            :sort-by="['updatedAt']"
            :sort-desc="[true]"
            class="elevation-1 mb-20"
            :loading="isLoadingNutritionsData"
            :search="search"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>{{
                        $vuetify.lang.t("$vuetify.nutrition.nutritionsDetail")
                    }}</v-toolbar-title>
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
                                class="mb-2 text-button elevation-2"
                                v-bind="attrs"
                                v-on="on"
                                @click="loadingCustomersData"
                            >
                                <v-icon small class="mr-2"
                                    >fas fa-user-plus</v-icon
                                >
                                {{ $vuetify.lang.t("$vuetify.add") }}
                            </v-btn>
                        </template>
                        <v-card
                            :loading="
                                isLoadingCustomersData || isButtonSaveLoading
                            "
                        >
                            <v-card-title>
                                <span class="headline">{{ formTitle }}</span>
                            </v-card-title>

                            <v-card-text>
                                <v-form v-model="isFormValid">
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-autocomplete
                                                    v-model="
                                                        editedItem.customerId
                                                    "
                                                    :items="customers"
                                                    :label="
                                                        $vuetify.lang.t(
                                                            '$vuetify.nutrition.customerFullName'
                                                        )
                                                    "
                                                    :rules="required"
                                                ></v-autocomplete>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    v-model="
                                                        editedItem.calories
                                                    "
                                                    :label="
                                                        $vuetify.lang.t(
                                                            '$vuetify.nutrition.calories'
                                                        )
                                                    "
                                                    :rules="required"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    v-model="editedItem.fat"
                                                    :label="
                                                        $vuetify.lang.t(
                                                            '$vuetify.nutrition.fat'
                                                        )
                                                    "
                                                    :rules="required"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    v-model="editedItem.carbs"
                                                    :label="
                                                        $vuetify.lang.t(
                                                            '$vuetify.nutrition.carbs'
                                                        )
                                                    "
                                                    :rules="required"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    v-model="editedItem.protein"
                                                    :label="
                                                        $vuetify.lang.t(
                                                            '$vuetify.nutrition.protein'
                                                        )
                                                    "
                                                    :rules="required"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-form>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    rounded
                                    color="grey darken-1"
                                    text
                                    @click="close"
                                    class="px-4 elevation-2"
                                >
                                    {{ $vuetify.lang.t("$vuetify.cancel") }}
                                </v-btn>
                                <v-btn
                                    rounded
                                    color="primary"
                                    class="text-button px-4 elevation-2"
                                    @click="save"
                                    :loading="isButtonSaveLoading"
                                    :disabled="isButtonSaveLoading"
                                >
                                    <v-icon small class="mr-2"
                                        >fas fa-save</v-icon
                                    >
                                    {{ $vuetify.lang.t("$vuetify.save") }}
                                </v-btn>
                            </v-card-actions>
                            <v-overlay
                                absolute
                                z-index="6"
                                :value="isButtonSaveLoading"
                                ><v-progress-circular
                                    indeterminate
                                    size="64"
                                ></v-progress-circular
                            ></v-overlay>
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
                                            class="elevation-2"
                                            rounded
                                            text
                                            @click="closeDelete"
                                            >{{
                                                $vuetify.lang.t(
                                                    "$vuetify.cancel"
                                                )
                                            }}</v-btn
                                        >
                                        <v-btn
                                            color="error"
                                            rounded
                                            class="px-4 ml-2 text-button elevation-2"
                                            @click="deleteItemConfirm"
                                            ><v-icon small class="mr-2"
                                                >fas fa-trash</v-icon
                                            >
                                            {{
                                                $vuetify.lang.t(
                                                    "$vuetify.delete"
                                                )
                                            }}</v-btn
                                        >
                                    </v-row>
                                </v-col>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.createdAt="{ item }">
                <span>{{ new Date(item.createdAt).toLocaleString() }}</span>
            </template>
            <template v-slot:item.updatedAt="{ item }">
                <span>{{ new Date(item.updatedAt).toLocaleString() }}</span>
            </template>
            <template v-slot:item.downloadPdfSummary="{ item }">
                <v-btn icon color="primary" class="elevation-1">
                    <v-icon small>fa-file-pdf</v-icon>
                </v-btn>
            </template>
            <template v-slot:item.actions="{ item }" class="justify">
                <div class="d-flex">
                    <v-tooltip left>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                icon
                                color="primary"
                                @click="editItem(item)"
                                class="mr-1 elevation-1"
                                v-bind="attrs"
                                v-on="on"
                            >
                                <v-icon small>fas fa-user-edit</v-icon>
                            </v-btn>
                        </template>
                        <span>{{
                            $vuetify.lang.t("$vuetify.nutrition.editUser")
                        }}</span>
                    </v-tooltip>
                    <v-tooltip bottom color="error">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                icon
                                color="error"
                                @click="deleteItem(item)"
                                class="elevation-1"
                                v-bind="attrs"
                                v-on="on"
                            >
                                <v-icon small>fas fa-user-slash</v-icon>
                            </v-btn>
                        </template>
                        <span>{{
                            $vuetify.lang.t("$vuetify.nutrition.deleteUser")
                        }}</span>
                    </v-tooltip>
                </div>
            </template>
            <template v-slot:no-data>
                <v-btn
                    rounded
                    color="primary"
                    class="text-button"
                    @click="loadingNutritionsData"
                >
                    <v-icon small class="mr-2">fas fa-redo</v-icon>
                    {{ $vuetify.lang.t("$vuetify.reload") }}
                </v-btn>
            </template>
        </v-data-table>
        <v-snackbar
            v-model="snackbar"
            :timeout="3000"
            elevation="24"
            color="green accent-4"
        >
            <v-icon small class="mr-2">fas fa-check-circle</v-icon>
            {{ snackbarMessage }}
        </v-snackbar>
    </div>
</template>
<script>
export default {
    mounted() {
        this.loadingNutritionsData();
    },
    props: {
        itemsPerPage: {
            type: Number,
            default: "10",
        },
    },
    data() {
        return {
            isButtonDeleteLoading: false,
            isButtonSaveLoading: false,
            isFormValid: false,
            isLoadingCustomersData: false,
            customers: [],
            snackbar: false,
            snackbarMessage: "",
            required: [
                (v) => !!v || this.$vuetify.lang.t("$vuetify.fieldIsRequired"),
            ],
            search: "",
            isLoadingNutritionsData: false,
            dialog: false,
            dialogDelete: false,
            editedIndex: -1,
            editedItem: {
                customer_id: "",
                calories: "",
                fat: "",
                carbs: "",
                protein: "",
            },
            defaultItem: {
                customer_id: "",
                calories: "",
                fat: "",
                carbs: "",
                protein: "",
            },
            nutritions: [],
        };
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1
                ? this.$vuetify.lang.t("$vuetify.nutrition.addNutrition")
                : this.$vuetify.lang.t("$vuetify.nutrition.editNutrition");
        },
        headers() {
            return [
                {
                    text: this.$vuetify.lang.t(
                        "$vuetify.nutrition.customerFullName"
                    ),
                    align: "start",
                    // sortable: false,
                    value: "customer.fullName",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.nutrition.calories"),
                    // sortable: false,
                    value: "calories",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.nutrition.fat"),
                    // sortable: false,
                    value: "fat",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.nutrition.carbs"),
                    // sortable: false,
                    value: "carbs",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.nutrition.protein"),
                    // sortable: false,
                    value: "protein",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.nutrition.createdAt"),
                    // sortable: false,
                    value: "createdAt",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.nutrition.updatedAt"),
                    // sortable: false,
                    value: "updatedAt",
                },
                // {
                //     text: this.$vuetify.lang.t(
                //         "$vuetify.nutrition.downloadPdfSummary"
                //     ),
                //     // sortable: false,
                //     value: "downloadPdfSummary",
                // },
                {
                    text: this.$vuetify.lang.t("$vuetify.actions"),
                    // sortable: false,
                    value: "actions",
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
        loadingCustomersData() {
            let self = this;
            self.customers = [];
            self.isLoadingCustomersData = true;

            axios
                .get(route("customer.index"))
                .then(function (response) {
                    // console.log(response);

                    response.data.forEach((customer) => {
                        self.customers.push({
                            text:
                                _.capitalize(customer.first_name) +
                                " " +
                                _.capitalize(customer.last_name),
                            value: customer.id,
                            // id: customer.id,
                            // firstName: customer.first_name,
                            // lastName: customer.last_name,
                            // title: customer.title,
                            // city: customer.city,
                            // postcode: customer.postcode,
                            // streetAddress: customer.street_address,
                            // phoneNumber: customer.phone_number,
                            // email: customer.email,
                        });
                    });
                })
                .catch(function (response) {
                    console.error(response);
                })
                .then(function () {
                    self.isLoadingCustomersData = false;
                });
        },
        loadingNutritionsData() {
            let self = this;
            self.nutritions = [];
            self.isLoadingNutritionsData = true;

            axios
                .get(route("nutrition.index"))
                .then(function (response) {
                    // console.log(response);

                    response.data.forEach((nutrition) => {
                        self.nutritions.push({
                            id: nutrition.id,
                            calories: nutrition.calories,
                            fat: nutrition.fat,
                            carbs: nutrition.carbs,
                            protein: nutrition.protein,
                            customerId: nutrition.customer_id,
                            createdAt: nutrition.created_at,
                            updatedAt: nutrition.updated_at,
                            customer: {
                                id: nutrition.customer.id,
                                firstName: nutrition.customer.first_name,
                                lastName: nutrition.customer.last_name,
                                fullName:
                                    _.capitalize(
                                        nutrition.customer.first_name
                                    ) +
                                    " " +
                                    _.capitalize(nutrition.customer.last_name),
                            },
                        });
                    });
                })
                .catch(function (response) {
                    console.error(response);
                })
                .then(function () {
                    self.isLoadingNutritionsData = false;
                });
        },

        editItem(item) {
            // console.log(item);
            this.loadingCustomersData();
            this.editedIndex = item.id;
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            // console.log(item);
            this.editedIndex = item.id;
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },

        deleteItemConfirm() {
            // this.nutritions.splice(this.editedIndex, 1);
            let self = this;
            self.nutritions = [];

            axios
                .delete(route("nutrition.destroy", self.editedIndex))
                .then(function (response) {
                    // console.log(response);

                    self.loadingNutritionsData();
                    self.snackbarMessage = self.$vuetify.lang.t(
                        "$vuetify.nutrition.successfullyDeleted",
                        [
                            _.capitalize(response.data.customer.first_name) +
                                " " +
                                _.capitalize(response.data.customer.last_name),
                        ]
                    );
                    self.snackbar = true;
                })
                .catch(function (response) {
                    console.error(response);
                })
                .then(function () {
                    self.closeDelete();
                });
        },

        close() {
            this.dialog = false;
            this.editedIndex = -1;
            this.editedItem = Object.assign({}, this.defaultItem);
            this.$nextTick(() => {
                // this.editedItem = Object.assign({}, this.defaultItem);
                // this.editedIndex = -1;
            });
        },

        closeDelete() {
            this.dialogDelete = false;
            this.editedIndex = -1;
            this.editedItem = Object.assign({}, this.defaultItem);
            this.$nextTick(() => {
                // this.editedItem = Object.assign({}, this.defaultItem);
                // this.editedIndex = -1;
            });
        },

        save() {
            let self = this;
            self.isButtonSaveLoading = true;

            if (this.editedIndex > -1) {
                axios
                    .put(`/api/nutrition/${this.editedIndex}`, self.editedItem)
                    .then(function (response) {
                        // console.log(response);

                        self.snackbarMessage = self.$vuetify.lang.t(
                            "$vuetify.nutrition.successfullyEdited",
                            [
                                _.capitalize(
                                    response.data.customer.first_name
                                ) +
                                    " " +
                                    _.capitalize(
                                        response.data.customer.last_name
                                    ),
                            ]
                        );

                        self.closeDelete();
                        self.close();
                        self.loadingNutritionsData();

                        self.snackbar = true;
                    })
                    .catch(function (response) {
                        console.error(response);
                    })
                    .then(function () {
                        self.isButtonSaveLoading = false;
                    });
            } else {
                // this.nutritions.push(this.editedItem);

                axios
                    .post(route("nutrition.store"), self.editedItem)
                    .then(function (response) {
                        // console.log(response);

                        self.snackbarMessage = self.$vuetify.lang.t(
                            "$vuetify.nutrition.successfullyAdded",
                            [
                                _.capitalize(
                                    response.data.customer.first_name
                                ) +
                                    " " +
                                    _.capitalize(
                                        response.data.customer.last_name
                                    ),
                            ]
                        );

                        self.closeDelete();
                        self.close();
                        self.loadingNutritionsData();

                        self.snackbar = true;
                    })
                    .catch(function (response) {
                        console.error(response);
                    })
                    .then(function () {
                        self.isButtonSaveLoading = false;
                    });
            }
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
select,
[type="text"]:focus,
[type="email"]:focus,
[type="url"]:focus,
[type="password"]:focus,
[type="number"]:focus,
[type="date"]:focus,
[type="datetime-local"]:focus,
[type="month"]:focus,
[type="search"]:focus,
[type="tel"]:focus,
[type="time"]:focus,
[type="week"]:focus,
[multiple]:focus,
textarea:focus,
select:focus {
    @apply ring-0;
    @apply bg-transparent;
}

.v-data-table-header th.sortable {
    white-space: nowrap;
}
</style>