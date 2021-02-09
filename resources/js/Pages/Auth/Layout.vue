<template>
    <v-app>
        <v-app-bar app elevate-on-scroll>
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
        },
    },

    data() {
        return {
            title: "",
        };
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
                .then(function () {});

            this.title = route().current();
            if (this.title) {
                let translationTitle = this.$vuetify.lang.t(
                    "$vuetify.title." + this.title
                );
                document.title = translationTitle ?? _.capitalize(this.title);
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