<template>
    <v-data-table
        :headers="headers"
        :items="customers"
        :items-per-page="itemsPerPage"
        sort-by="name"
        class="elevation-1"
        :loading="isLoading"
        :search="search"
    >
        <template v-slot:top>
            <v-toolbar flat>
                <v-toolbar-title>{{
                    $vuetify.lang.t("$vuetify.customer.customersDetail")
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
                            <v-icon small class="mr-2">fas fa-user-plus</v-icon>
                            {{ $vuetify.lang.t("$vuetify.addCustomer") }}
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
                                            v-model="editedItem.firstName"
                                            :label="
                                                $vuetify.lang.t(
                                                    '$vuetify.customer.firstName'
                                                )
                                            "
                                            :rules="required"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            v-model="editedItem.lastName"
                                            :label="
                                                $vuetify.lang.t(
                                                    '$vuetify.customer.lastName'
                                                )
                                            "
                                            :rules="required"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            v-model="editedItem.title"
                                            :label="
                                                $vuetify.lang.t(
                                                    '$vuetify.customer.title'
                                                )
                                            "
                                            :rules="required"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            v-model="editedItem.city"
                                            :label="
                                                $vuetify.lang.t(
                                                    '$vuetify.customer.city'
                                                )
                                            "
                                            :rules="required"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            v-model="editedItem.postcode"
                                            :label="
                                                $vuetify.lang.t(
                                                    '$vuetify.customer.postcode'
                                                )
                                            "
                                            :rules="required"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            v-model="editedItem.streetAddress"
                                            :label="
                                                $vuetify.lang.t(
                                                    '$vuetify.customer.streetAddress'
                                                )
                                            "
                                            :rules="required"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            v-model="editedItem.phoneNumber"
                                            :label="
                                                $vuetify.lang.t(
                                                    '$vuetify.customer.phoneNumber'
                                                )
                                            "
                                            :rules="required"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            v-model="editedItem.email"
                                            :label="
                                                $vuetify.lang.t(
                                                    '$vuetify.customer.email'
                                                )
                                            "
                                            :rules="required"
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
        <template v-slot:item.actions="{ item }" class="justify">
            <div class="d-flex">
                <v-tooltip left>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            icon
                            color="primary"
                            @click="editItem(item)"
                            class="mr-1"
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon small>fas fa-user-edit</v-icon>
                        </v-btn>
                    </template>
                    <span>{{
                        $vuetify.lang.t("$vuetify.customer.editUser")
                    }}</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            icon
                            color="error"
                            @click="deleteItem(item)"
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon small>fas fa-user-slash</v-icon>
                        </v-btn>
                    </template>
                    <span>{{
                        $vuetify.lang.t("$vuetify.customer.deleteUser")
                    }}</span>
                </v-tooltip>
            </div>
        </template>
        <template v-slot:no-data>
            <v-btn rounded color="primary" class="font-bold" @click="loadingData">
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
            default: "10",
        },
    },
    data() {
        return {
            required: [
                (v) => !!v || this.$vuetify.lang.t("$vuetify.fieldIsRequired"),
            ],
            search: "",
            isLoading: false,
            dialog: false,
            dialogDelete: false,
            editedIndex: -1,
            editedItem: {
                firstName: "",
                lastName: "",
                title: "",
                city: "",
                postcode: "",
                streetAddress: "",
                phoneNumber: "",
                email: "",
            },
            defaultItem: {
                firstName: "",
                lastName: "",
                title: "",
                city: "",
                postcode: "",
                streetAddress: "",
                phoneNumber: "",
                email: "",
            },
            customers: [],
        };
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "Tambah Item" : "Ubah Item";
        },
        headers() {
            return [
                {
                    text: this.$vuetify.lang.t("$vuetify.customer.firstName"),
                    align: "start",
                    // sortable: false,
                    value: "firstName",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.customer.lastName"),
                    // sortable: false,
                    value: "lastName",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.customer.title"),
                    // sortable: false,
                    value: "title",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.customer.city"),
                    // sortable: false,
                    value: "city",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.customer.postcode"),
                    // sortable: false,
                    value: "postcode",
                },
                {
                    text: this.$vuetify.lang.t(
                        "$vuetify.customer.streetAddress"
                    ),
                    // sortable: false,
                    value: "streetAddress",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.customer.phoneNumber"),
                    // sortable: false,
                    value: "phoneNumber",
                },
                {
                    text: this.$vuetify.lang.t("$vuetify.customer.email"),
                    // sortable: false,
                    value: "email",
                },
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
        loadingData() {
            let self = this;
            self.customers = [];
            self.isLoading = true;

            axios
                .get("/api/customer")
                .then(function (response) {
                    console.log(response);

                    response.data.forEach((customer) => {
                        self.customers.push({
                            id: customer.id,
                            firstName: customer.first_name,
                            lastName: customer.last_name,
                            title: customer.title,
                            city: customer.city,
                            postcode: customer.postcode,
                            streetAddress: customer.street_address,
                            phoneNumber: customer.phone_number,
                            email: customer.email,
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
            // console.log(item);
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
            // this.customers.splice(this.editedIndex, 1);
            let self = this;
            self.customers = [];

            axios
                .delete(`/api/customer/${this.editedIndex}`)
                .then(function (response) {
                    console.log(response);

                    self.loadingData();
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

            if (this.editedIndex > -1) {
                axios
                    .put(`/api/customer/${this.editedIndex}`, self.editedItem)
                    .then(function (response) {
                        console.log(response);

                        self.closeDelete();
                        self.close();
                        self.loadingData();
                    })
                    .catch(function (response) {
                        console.error(response);
                    })
                    .then(function () {});
            } else {
                // this.customers.push(this.editedItem);

                axios
                    .post("/api/customer", self.editedItem)
                    .then(function (response) {
                        console.log(response);

                        self.closeDelete();
                        self.close();
                        self.loadingData();
                    })
                    .catch(function (response) {
                        console.error(response);
                    })
                    .then(function () {});
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
select {
    @apply ring-0;
    @apply bg-transparent;
}

.v-data-table-header th.sortable {
    white-space: nowrap;
}
</style>