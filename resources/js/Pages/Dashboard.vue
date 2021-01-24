<template>
    <v-app>
        <v-navigation-drawer app v-model="drawer">
            <v-list>
                <v-list-item>
                    <v-list-item-avatar>
                        <v-img :src="user.profile_photo_url"></v-img>
                    </v-list-item-avatar>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-content>
                        <v-list-item-title class="text-left">
                            {{ user.name }}
                        </v-list-item-title>
                        <v-list-item-subtitle class="text-left">
                            {{ user.email }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-action>
                        <v-icon small>fas fa-caret-down</v-icon>
                    </v-list-item-action>
                </v-list-item>
            </v-list>
            <v-list nav>
                <inertia-link
                    v-for="menu_item in menu"
                    :key="menu_item.title"
                    href="/"
                    class="no-underline"
                >
                    <v-list-item link :key="menu_item.title" class="font-bold">
                        <v-icon small color="secondary">{{
                            menu_item.icon
                        }}</v-icon>

                        <v-list-item-content>
                            <v-list-item-title class="text-left ml-2">{{
                                menu_item.title
                            }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </inertia-link>
            </v-list>
            <template v-slot:append>
                <div class="p-2">
                    <form method="POST" @submit.prevent="logout">
                        <v-btn
                            block
                            rounded
                            color="secondary"
                            class="font-bold no-underline"
                            type="submit"
                            :loading="isLogouting"
                        >
                            <v-icon small class="mr-2"
                                >fas fa-sign-out-alt</v-icon
                            >
                            {{ $vuetify.lang.t("$vuetify.logout") }}
                        </v-btn>
                    </form>
                </div>
            </template>
            <v-divider></v-divider>
        </v-navigation-drawer>

        <v-app-bar app elevate-on-scroll color="rgba(249, 250, 251, 1)">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-app-bar-title shrink-on-scroll>{{ title }}</v-app-bar-title>
        </v-app-bar>

        <v-main>
            <v-container fluid class="bg-gray-50">
                <v-data-table
                    :headers="headers"
                    :items="desserts"
                    :items-per-page="10"
                    sort-by="name"
                    class="elevation-1"
                >
                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-toolbar-title>{{
                                $vuetify.lang.t("$vuetify.nutritions")
                            }}</v-toolbar-title>
                            <v-divider class="mx-4" inset vertical></v-divider>
                            <v-spacer></v-spacer>
                            <v-dialog v-model="dialog" max-width="600px">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        color="primary"
                                        rounded
                                        class="mb-2 font-bold"
                                        v-bind="attrs"
                                        v-on="on"
                                    >
                                        <v-icon small class="mr-2"
                                            >fas fa-plus</v-icon
                                        >
                                        {{
                                            $vuetify.lang.t("$vuetify.addItem")
                                        }}
                                    </v-btn>
                                </template>
                                <v-card>
                                    <v-card-title>
                                        <span class="headline">{{
                                            formTitle
                                        }}</span>
                                    </v-card-title>

                                    <v-card-text>
                                        <v-container>
                                            <v-row>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field
                                                        v-model="
                                                            editedItem.name
                                                        "
                                                        label="Dessert name"
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field
                                                        v-model="
                                                            editedItem.calories
                                                        "
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
                                                        v-model="
                                                            editedItem.carbs
                                                        "
                                                        label="Carbs (g)"
                                                    ></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field
                                                        v-model="
                                                            editedItem.protein
                                                        "
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
                                            {{
                                                $vuetify.lang.t(
                                                    "$vuetify.cancel"
                                                )
                                            }}
                                        </v-btn>
                                        <v-btn
                                            rounded
                                            color="primary"
                                            class="font-bold px-4"
                                            @click="save"
                                        >
                                            <v-icon small class="mr-2"
                                                >fas fa-save</v-icon
                                            >
                                            {{
                                                $vuetify.lang.t("$vuetify.save")
                                            }}
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                            <v-dialog v-model="dialogDelete" max-width="600px">
                                <v-card>
                                    <v-card-title class="headline">{{
                                        $vuetify.lang.t("$vuetify.youSure")
                                    }}</v-card-title>
                                    <v-card-text>
                                        {{
                                            $vuetify.lang.t(
                                                "$vuetify.canNotBeUndone"
                                            )
                                        }}
                                    </v-card-text>
                                    <v-card-actions class="justify-end">
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            color="blue darken-1"
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
                                            class="px-4 font-bold"
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
                                        <v-spacer></v-spacer>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-icon
                            small
                            color="primary"
                            class="mr-2"
                            @click="editItem(item)"
                        >
                            fas fa-edit
                        </v-icon>
                        <v-icon small color="error" @click="deleteItem(item)">
                            fas fa-trash
                        </v-icon>
                    </template>
                    <template v-slot:no-data>
                        <v-btn
                            color="primary"
                            class="font-bold"
                            @click="initialize"
                        >
                            <v-icon small class="mr-2">fas fa-redo</v-icon>
                            {{ $vuetify.lang.t("$vuetify.reload") }}
                        </v-btn>
                    </template>
                </v-data-table>
            </v-container>
        </v-main>

        <v-footer app dark padless>
            <v-row
                justify="center"
                class="py-6 font-bold"
            >
                <v-icon small class="mr-1"
                    >fas fa-copyright</v-icon
                >
                {{ new Date().getFullYear() }}
                {{ $vuetify.lang.t("$vuetify.company") }}
            </v-row>
        </v-footer>
    </v-app>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import { mapMutations } from "vuex";

export default {
    components: {
        AppLayout,
        Welcome,
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
        customers: {
            type: Array,
        },
    },
    data() {
        return {
            footer: !this.$vuetify.breakpoint.mobile,
            isLogoutButtonDisabled: false,
            isLogouting: false,
            drawer: !this.$vuetify.breakpoint.mobile,
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
            menu: [
                { title: "Dashboard", href: "/dashboard", icon: "fas fa-home" },
            ],
            headers: [
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
            ],
            desserts: [],
        };
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "Tambah Item" : "Ubah Item";
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
    created() {
        this.initialize();
    },
    methods: {
        ...mapMutations(["INCREMENT"]),
        logout() {
            this.isLogouting = true;
            axios.post(route("logout").url()).then((response) => {
                window.location = "login";
            });
        },
        initialize() {
            this.desserts = [];
            this.customers.forEach((customer) => {
                this.desserts.push({
                    name: customer.first_name + " " + customer.last_name,
                    calories: customer.nutrition.calories,
                    fat: customer.nutrition.fat,
                    carbs: customer.nutrition.carbs,
                    protein: customer.nutrition.protein,
                });
            });
        },

        editItem(item) {
            this.editedIndex = this.desserts.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            this.editedIndex = this.desserts.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },

        deleteItemConfirm() {
            this.desserts.splice(this.editedIndex, 1);
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
                Object.assign(this.desserts[this.editedIndex], this.editedItem);
            } else {
                this.desserts.push(this.editedItem);
            }
            this.close();
        },
    },
};
</script>
<style>
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
}
</style>