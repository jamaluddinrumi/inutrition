<template>
    <v-app
        style="background-size: cover; background-position: top center"
        :style="{ 'background-image': backgroundImage }"
    >
        <v-app-bar app>
            <v-app-bar-title>
                <template v-if="!$vuetify.breakpoint.mobile">
                    <jet-authentication-card-logo v-if="!$vuetify.theme.dark" />
                    <jet-authentication-card-logo-dark v-else />
                </template>
            </v-app-bar-title>
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
            <v-progress-linear
                :active="loading"
                :indeterminate="loading"
                absolute
                bottom
                color="primary"
            ></v-progress-linear>
        </v-app-bar>
        <v-main class="">
            <v-container
                class="p-0 min-h-screen flex items-center justify-center m-auto"
            >
                <slot></slot>
            </v-container>
        </v-main>
        <v-footer app padless>
            <v-row
                justify="center"
                class="py-6 text-body-2 opacity-50 hover:opacity-100 transition-opacity"
            >
                <v-icon small class="mr-1">fas fa-copyright</v-icon>
                {{ new Date().getFullYear() }}
                {{ $vuetify.lang.t("$vuetify.company") }}
            </v-row></v-footer
        >
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
        JetAuthenticationCardLogoDark
    },

    props: {
        loading: {
            type: Boolean
        }
    },

    data() {
        return {
            title: ""
        };
    },

    computed: {
        backgroundImage: function() {
            return this.$vuetify.theme.dark
                ? `url('${this.$page.props.appUrl}/img/healthy-food-dark.jpg')`
                : `url('${this.$page.props.appUrl}/img/healthy-food.jpg')`;
        }
    },

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

            // it should use <inertia-link /> to make appropriate validation errors works

            axios
                .post(`/lang/${this.$i18n.locale}`)
                .then(function(response) {
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
                .catch(function(error) {
                    console.error(error);
                })
                .then(function() {});
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
