<template>
    <layout>
        <div class="p-4">
            <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                <update-profile-information-form :user="$page.props.user" />

                <jet-section-border />
            </div>

            <div v-if="$page.props.jetstream.canUpdatePassword">
                <update-password-form class="mt-10 sm:mt-0" />

                <!-- <jet-section-border /> -->
            </div>

            <!-- <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                <two-factor-authentication-form class="mt-10 sm:mt-0" />

                <jet-section-border />
            </div> -->

            <!-- <logout-other-browser-sessions-form
                :sessions="sessions"
                class="mt-10 sm:mt-0"
            /> -->

            <jet-section-border />

            <!-- <delete-user-form class="mt-10 sm:mt-0" /> -->
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
    mounted() {},
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
        sessions: {},
        currentRouteName: {
            type: String,
        },
        errorBags: {},
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
select [role="button"],
[type="button"],
[type="reset"],
[type="submit"],
button {
    @apply ring-0;
    @apply bg-transparent;
    @apply bg-opacity-0;
}
</style>