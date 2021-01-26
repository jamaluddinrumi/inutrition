<template>
    <v-app>
        <v-navigation-drawer app v-model="drawer">
            <v-list>
                <v-list-item>
                    <v-list-item-avatar>
                        <v-img
                            :src="$page.user.profile_photo_url"
                            :alt="$page.user.name"
                        ></v-img>
                    </v-list-item-avatar>
                </v-list-item>
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="text-left">
                            <!-- <v-skeleton-loader class="mx-auto" type="text"></v-skeleton-loader> -->
                            <span>{{ $page.user.name }}</span>
                        </v-list-item-title>
                        <v-list-item-subtitle class="text-left">
                            <!-- <v-skeleton-loader class="mx-auto" type="text"></v-skeleton-loader> -->
                            <span>{{ $page.user.email }}</span>
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
            <template v-slot:append>
                <div class="p-2">
                    <form method="POST" @submit.prevent="logout">
                        <v-btn
                            block
                            rounded
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

        <v-app-bar app elevate-on-scroll>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-app-bar-title shrink-on-scroll>{{
                $vuetify.lang.t("$vuetify.title." + $page.title)
            }}</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-btn icon>
                <v-icon small>fas fa-bell</v-icon>
            </v-btn>
            <v-switch
                dense
                hide-details
                inset
                v-model="$vuetify.theme.dark"
                class="ml-4"
            >
            <template v-slot:label>
                <v-icon v-if="$vuetify.theme.dark" small class="-ml-2">fas fa-moon</v-icon>
                <v-icon v-else small class="-ml-2">fas fa-sun</v-icon>
            </template>
            </v-switch>
        </v-app-bar>

        <v-main>
            <v-container fluid>
                <slot></slot>
            </v-container>
        </v-main>

        <v-footer app dark padless>
            <v-row justify="center" class="py-6 font-bold text-sm">
                <v-icon small class="mr-1">fas fa-copyright</v-icon>
                {{ new Date().getFullYear() }}
                {{ $vuetify.lang.t("$vuetify.company") }}
            </v-row>
        </v-footer>
    </v-app>
</template>
<script>
export default {
    components: {},
    props: {},
    data() {
        return {
            footer: !this.$vuetify.breakpoint.mobile,
            isLogoutButtonDisabled: false,
            isLogouting: false,
            drawer: !this.$vuetify.breakpoint.mobile,
            menu: [
                {
                    id: 0,
                    title: this.$vuetify.lang.t("$vuetify.title.dashboard"),
                    href: "/dashboard",
                    icon: "fas fa-home",
                },
                {
                    id: 1,
                    title: this.$vuetify.lang.t("$vuetify.title.profile"),
                    href: "/profile",
                    icon: "fas fa-user",
                },
            ],
            group: 0,
        };
    },
    computed: {},
    watch: {},
    created() {},
    methods: {
        logout() {
            this.isLogouting = true;
            axios.post(route("logout").url()).then((response) => {
                window.location = "login";
            });
        },
    },
};
</script>
<style>
</style>