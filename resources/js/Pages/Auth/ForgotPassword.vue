<template>
    <layout :loading="form.processing">
        <jet-authentication-card>
            <template #logo>
                <jet-authentication-card-logo v-if="!$vuetify.theme.dark" />
                <jet-authentication-card-logo-dark v-else />
            </template>

            <div class="mb-4 text-body-1">
                {{ $vuetify.lang.t("$vuetify.laravel.forgotYourPassword") }}
            </div>

            <div v-if="status" class="mb-4 font-medium text-sm">
                {{ status }}
            </div>

            <jet-validation-errors class="mb-4" />

            <form @submit.prevent="submit">
                <v-card>
                    <v-card-text>
                        <div>
                            <v-text-field
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autofocus
                                :label="$vuetify.lang.t('$vuetify.email')"
                            />
                        </div>
                    </v-card-text>
                    <v-card-actions class="p-4">
                        <div class="flex items-center justify-end mt-4">
                            <v-btn
                                rounded
                                class="ml-4"
                                color="primary text-button"
                                :disabled="form.processing"
                                type="submit"
                            >
                                <v-icon small class="mr-2">fas fa-key</v-icon>
                                {{
                                    $vuetify.lang.t(
                                        "$vuetify.laravel.emailPasswordResetLink"
                                    )
                                }}
                            </v-btn>
                        </div>
                    </v-card-actions>
                    <v-overlay absolute :value="form.processing">
                        <v-progress-circular
                            indeterminate
                        ></v-progress-circular>
                    </v-overlay>
                </v-card>
            </form>
        </jet-authentication-card>
    </layout>
</template>

<script>
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo";
import JetAuthenticationCardLogoDark from "@/Jetstream/AuthenticationCardLogoDark";
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import JetValidationErrors from "@/Jetstream/ValidationErrors";
import Layout from "@/Pages/Auth/Layout";

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

    components: {
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetAuthenticationCardLogoDark,
        JetButton,
        JetInput,
        JetLabel,
        JetValidationErrors,
        Layout,
    },

    props: {
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: "",
            }),
            title: "resetPassword",
        };
    },

    methods: {
        submit() {
            this.form.post(this.route("password.email"));
        },
    },
};
</script>
