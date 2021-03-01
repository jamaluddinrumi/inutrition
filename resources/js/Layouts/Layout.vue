<template>
    <v-app>
        <v-system-bar color="primary"> </v-system-bar>
        <v-navigation-drawer app v-model="drawer">
            <div class="flex justify-center my-4">
                <jet-authentication-card-logo v-if="!$vuetify.theme.dark" />
                <jet-authentication-card-logo-dark v-else />
            </div>
            <v-divider></v-divider>
            <v-subheader>{{
                $vuetify.lang.t("$vuetify.mainMenu")
            }}</v-subheader>
            <v-list rounded>
                <v-list-item-group>
                    <inertia-link
                        v-for="menu_item in menu"
                        :key="menu_item.id"
                        :href="menu_item.href"
                        class="no-underline"
                    >
                        <v-list-item
                            :key="menu_item.id"
                            class="text-button px-4"
                        >
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
                    class="py-6 text-body-2 opacity-50 hover:opacity-100 transition-opacity"
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
            <v-menu offset-y transition="slide-y-transition">
                <template v-slot:activator="{ on, attrs }">
                    <v-badge
                        overlap
                        color="red"
                        offset-x="24"
                        offset-y="24"
                        content="1"
                    >
                        <v-btn icon v-bind="attrs" v-on="on">
                            <v-icon small>fas fa-bell</v-icon>
                        </v-btn>
                    </v-badge>
                </template>
                <v-list dense flat>
                    <template v-for="item in notifMenu">
                        <v-divider
                            v-if="item.id > 0"
                            :key="item.id"
                        ></v-divider>
                        <v-list-item :key="item.id" link>
                            <v-list-item-content>
                                <v-list-item-title>{{
                                    item.title
                                }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </template>
                </v-list>
            </v-menu>

            <v-menu transition="slide-y-transition">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on" class="mr-2">
                        <v-avatar size="24">
                            <img
                                :src="$page.props.user.profile_photo_url"
                                :alt="$page.props.user.name"
                            />
                        </v-avatar>
                    </v-btn>
                </template>
                <v-list rounded>
                    <v-list>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-img
                                    :src="$page.props.user.profile_photo_url"
                                    :alt="$page.props.user.name"
                                ></v-img>
                            </v-list-item-avatar>
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
                    <v-list-item-group>
                        <inertia-link
                            v-for="(menu_item, index) in userMenu"
                            :key="index"
                            :href="
                                menu_item.href !== '/logout'
                                    ? menu_item.href
                                    : 'javascript:void(0)'
                            "
                            class="no-underline"
                        >
                            <v-list-item class="text-button dark:text-white">
                                <!-- <template v-slot:default="{ active }"> -->
                                <v-list-item-icon>
                                    <v-icon small>{{ menu_item.icon }}</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-if="menu_item.href !== '/logout'"
                                    >
                                        <span>
                                            {{ menu_item.title }}
                                        </span>
                                    </v-list-item-title>
                                    <v-list-item-title
                                        v-else-if="menu_item.href === '/logout'"
                                    >
                                        <span @click="logout">
                                            {{ menu_item.title }}
                                        </span>
                                    </v-list-item-title>
                                </v-list-item-content>
                                <!-- </template> -->
                            </v-list-item>
                        </inertia-link>
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
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo";
import JetAuthenticationCardLogoDark from "@/Jetstream/AuthenticationCardLogoDark";

export default {
    components: {
        CountryFlag,
        JetAuthenticationCardLogo,
        JetAuthenticationCardLogoDark,
    },
    mounted() {},
    data() {
        return {
            loading: false,
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
        notifMenu: function () {
            return [
                {
                    id: 0,
                    title:
                        "Maecenas sed diam eget risus varius blandit sit amet non magna.",
                },
                {
                    id: 1,
                    title: "Vestibulum id ligula porta felis euismod semper.",
                },
                {
                    id: 2,
                    title:
                        "Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.",
                },
            ];
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
        userMenu: function () {
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
            let self = this;

            axios.defaults.headers.common[
                "Accept-Language"
            ] = this.$i18n.locale;

            axios
                .post(`/lang/${this.$i18n.locale}`)
                .then(function (response) {
                    console.log(response);

                    self.title = route().current();
                    if (self.title) {
                        let translationTitle = self.$vuetify.lang.t(
                            "$vuetify.title." + self.title
                        );
                        document.title =
                            translationTitle ?? _.capitalize(self.title);
                    }
                })
                .catch(function (error) {
                    console.error(error);
                })
                .then(function (response) {
                    console.log(response);
                });
        },
        onScroll(e) {
            if (typeof window === "undefined") return;
            const top = window.pageYOffset || e.target.scrollTop || 0;
            this.fab = top > 20;
        },
        logout() {
            this.loading = true;
            this.isLogouting = true;
            axios.post(route("logout")).then((response) => {
                window.location = "login";
            });
        },
    },
};
</script>
<style>
</style>