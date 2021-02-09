<template>
    <v-app>
        <v-system-bar color="primary"> </v-system-bar>
        <v-navigation-drawer app v-model="drawer">
            <v-list>
                <v-list-item>
                    <v-list-item-avatar>
                        <v-img
                            :src="$page.props.user.profile_photo_url"
                            :alt="$page.props.user.name"
                        ></v-img>
                    </v-list-item-avatar>
                </v-list-item>
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="text-left">
                            <!-- <v-skeleton-loader class="mx-auto" type="text"></v-skeleton-loader> -->
                            <span>{{ userName }}</span>
                        </v-list-item-title>
                        <v-list-item-subtitle class="text-left">
                            <!-- <v-skeleton-loader class="mx-auto" type="text"></v-skeleton-loader> -->
                            <span>{{ $page.props.user.email }}</span>
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <v-divider></v-divider>
            <v-list rounded>
                <v-list-item-group>
                    <inertia-link
                        v-for="menu_item in menu"
                        :key="menu_item.id"
                        :href="menu_item.href"
                        class="no-underline"
                    >
                        <v-list-item :key="menu_item.id" class="font-bold px-4">
                            <v-list-item-icon
                                ><v-icon small>{{
                                    menu_item.icon
                                }}</v-icon></v-list-item-icon
                            >

                            <v-list-item-content>
                                <v-list-item-title class="text-left ml-2">{{
                                    menu_item.title
                                }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </inertia-link>
                </v-list-item-group>
            </v-list>
            <v-divider></v-divider>
            <template v-slot:append>
                <v-row
                    justify="center"
                    class="py-6 font-bold text-sm opacity-50 hover:opacity-100 transition-opacity"
                >
                    <v-icon small class="mr-1">fas fa-copyright</v-icon>
                    {{ new Date().getFullYear() }}
                    {{ $vuetify.lang.t("$vuetify.company") }}
                </v-row>
            </template>
        </v-navigation-drawer>

        <v-app-bar app elevate-on-scroll>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-app-bar-title shrink-on-scroll>{{
                $vuetify.lang.t("$vuetify.title." + $page.props.title)
            }}</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-switch
                dense
                hide-details
                inset
                v-model="$i18n.locale"
                class="mr-4"
                true-value="en"
                false-value="id"
                @change="onLocaleChange"
            >
                <template v-slot:label>
                    <div class="-ml-2" v-if="$i18n.locale === 'id'">
                        <country-flag
                            country="id"
                            size="small"
                            rounded
                        ></country-flag>
                    </div>
                    <div class="-ml-2" v-else>
                        <country-flag
                            country="gb"
                            size="small"
                            rounded
                        ></country-flag>
                    </div>
                </template>
            </v-switch>
            <v-switch
                dense
                hide-details
                inset
                v-model="$vuetify.theme.dark"
                class="mx-4"
                @click="onDarkModeChange"
            >
                <template v-slot:label>
                    <v-icon v-if="$vuetify.theme.dark" small class="-ml-2"
                        >fas fa-moon</v-icon
                    >
                    <v-icon v-else small class="-ml-2">fas fa-sun</v-icon>
                </template>
            </v-switch>
            <v-btn icon>
                <v-icon small>fas fa-bell</v-icon>
            </v-btn>
            <!-- <inertia-link href="/profile">
                <v-btn icon>
                    <v-icon small>fas fa-user</v-icon>
                </v-btn>
            </inertia-link> -->
            <v-menu offset-y transition="slide-y-transition">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon small>fas fa-user</v-icon>
                    </v-btn>
                </template>
                <v-list rounded>
                    <v-list-item-group>
                        <v-list-item
                            v-for="(menu_item, index) in user_menu"
                            :key="index"
                        >
                            <template v-slot:default="{ active }">
                                <v-list-item-content
                                    v-if="menu_item.href !== '/logout'"
                                >
                                    <v-list-item-title>
                                        <inertia-link
                                            :href="menu_item.href"
                                            class="no-underline font-bold"
                                        >
                                            <v-icon small class="mr-2">{{
                                                menu_item.icon
                                            }}</v-icon>
                                            {{ menu_item.title }}
                                        </inertia-link>
                                    </v-list-item-title>
                                </v-list-item-content>

                                <v-list-item-content
                                    v-else-if="menu_item.href === '/logout'"
                                >
                                    <form
                                        method="POST"
                                        @submit.prevent="logout"
                                    >
                                        <div class="font-bold" @click="logout">
                                            <v-icon small class="mr-2">{{
                                                menu_item.icon
                                            }}</v-icon>
                                            {{ menu_item.title }}
                                        </div>
                                    </form>
                                </v-list-item-content>
                            </template>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-menu>
        </v-app-bar>

        <v-main>
            <v-container fluid>
                <slot></slot>
            </v-container>
        </v-main>

        <v-footer app dark padless> </v-footer>
        <v-fab-transition>
            <v-btn
                v-scroll="onScroll"
                v-show="fab"
                fab
                color="primary"
                fixed
                right
                bottom
                @click="$vuetify.goTo(0)"
            >
                <v-icon small>fas fa-arrow-up</v-icon>
            </v-btn>
        </v-fab-transition>
        <v-overlay :value="loading" z-index="9999">
            <v-progress-circular indeterminate></v-progress-circular>
        </v-overlay>
    </v-app>
</template>
<script>
import CountryFlag from "vue-country-flag";

export default {
    components: {
        CountryFlag,
    },
    props: {
        loading: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            fab: false,
            footer: !this.$vuetify.breakpoint.mobile,
            isLogoutButtonDisabled: false,
            isLogouting: false,
            drawer: !this.$vuetify.breakpoint.mobile,
            group: 0,
        };
    },
    watch: {},
    computed: {
        userName: function () {
            return _.startCase(this.$page.props.user.name);
        },
        menu: function () {
            return [
                {
                    id: 0,
                    title: this.$vuetify.lang.t("$vuetify.title.dashboard"),
                    href: "/dashboard",
                    icon: "fas fa-home",
                },
                {
                    id: 1,
                    title: this.$vuetify.lang.t("$vuetify.title.nutrition"),
                    href: "/nutrition",
                    icon: "fas fa-utensils",
                },
                {
                    id: 2,
                    title: this.$vuetify.lang.t("$vuetify.title.customer"),
                    href: "/customer",
                    icon: "fas fa-user",
                },
            ];
        },
        user_menu: function () {
            return [
                {
                    id: 0,
                    title: this.$vuetify.lang.t("$vuetify.profile.profile"),
                    href: "/profile",
                    icon: "fas fa-cog",
                },
                {
                    id: 1,
                    title: this.$vuetify.lang.t("$vuetify.logout"),
                    href: "/logout",
                    icon: "fas fa-sign-out-alt",
                },
            ];
        },
    },
    created() {},
    methods: {
        onDarkModeChange() {
            localStorage.theme = this.$vuetify.theme.dark ? "dark" : "light";
            if (localStorage.theme === "dark") {
                document.documentElement.classList.add("dark");
            } else {
                document.documentElement.classList.remove("dark");
            }
        },
        onLocaleChange() {
            axios.defaults.headers.common[
                "Accept-Language"
            ] = this.$i18n.locale;

            axios
                .post(`/lang/${this.$i18n.locale}`)
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.error(error);
                })
                .then(function (response) {
                    console.log(response);
                });

            this.title = route().current();
            if (this.title) {
                let translationTitle = this.$vuetify.lang.t(
                    "$vuetify.title." + this.title
                );
                document.title = translationTitle ?? _.capitalize(this.title);
            }
        },
        onScroll(e) {
            if (typeof window === "undefined") return;
            const top = window.pageYOffset || e.target.scrollTop || 0;
            this.fab = top > 20;
        },
        logout() {
            this.loading = true;
            this.isLogouting = true;
            axios.post(this.route("logout")).then((response) => {
                window.location = "login";
            });
        },
    },
};
</script>
<style>
</style>