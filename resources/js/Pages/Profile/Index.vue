<template>
    <layout>
        <div class="p-4">
            <div v-if="$page.jetstream.canUpdateProfileInformation">
                <update-profile-information-form :user="$page.user" />

                <jet-section-border />
            </div>

            <div v-if="$page.jetstream.canUpdatePassword">
                <update-password-form class="mt-10 sm:mt-0" />

                <!-- <jet-section-border /> -->
            </div>

            <!-- <div v-if="$page.jetstream.canManageTwoFactorAuthentication">
                <two-factor-authentication-form class="mt-10 sm:mt-0" />

                <jet-section-border />
            </div> -->

            <!-- <logout-other-browser-sessions-form
                :sessions="sessions"
                class="mt-10 sm:mt-0"
            />

            <jet-section-border />

            <delete-user-form class="mt-10 sm:mt-0" /> -->
        </div>
    </layout>
</template>

<script>
import Layout from "@/Layouts/Layout";
import DeleteUserForm from "./DeleteUserForm";
import JetSectionBorder from "@/Jetstream/SectionBorder";
import LogoutOtherBrowserSessionsForm from "./LogoutOtherBrowserSessionsForm";
import TwoFactorAuthenticationForm from "./TwoFactorAuthenticationForm";
import UpdatePasswordForm from "./UpdatePasswordForm";
import UpdateProfileInformationForm from "./UpdateProfileInformationForm";

export default {
    title() {
        if (this.title) {
            let translationTitle = this.$vuetify.lang.t(
                "$vuetify.title." + this.title
            );
            if (translationTitle) {
                return translationTitle;
            } else {
                return _.capitalize(this.title);
            }
        }
    },

    props: {
        sessions: {
            type: Array,
        },
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
        customers: {
            type: Array,
        },
        users: {
            type: Array,
        },
        title: {
            type: String,
        },
    },

    components: {
        Layout,
        DeleteUserForm,
        JetSectionBorder,
        LogoutOtherBrowserSessionsForm,
        TwoFactorAuthenticationForm,
        UpdatePasswordForm,
        UpdateProfileInformationForm,
    },
};
</script>
<style scoped>
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
select [role="button"],
[type="button"],
[type="reset"],
[type="submit"],
button {
    @apply ring-1;
    @apply ring-gray-300;
    @apply bg-gray-50;
    @apply bg-opacity-50;
}
</style>