<template>
    <layout :loading="form.processing">
        <jet-authentication-card>
            <template #logo>
                <jet-authentication-card-logo v-if="!$vuetify.theme.dark" />
                <jet-authentication-card-logo-dark v-else />
            </template>

            <jet-validation-errors class="mb-4" />

            <div v-if="status" class="mb-4 font-medium text-sm">
                {{ status }}
            </div>

            <v-form @submit.prevent="submit">
                <v-card>
                    <v-card-text
                        ><div>
                            <v-text-field
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autofocus
                                :label="$vuetify.lang.t('$vuetify.email')"
                                hint="(demo@demo.com)"
                                persistent-hint
                            />
                        </div>

                        <div class="mt-4">
                            <v-text-field
                                id="password"
                                :type="passwordType ? 'password' : 'text'"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                                :label="$vuetify.lang.t('$vuetify.password')"
                                hint="(demo1234)"
                                persistent-hint
                            >
                                <template v-slot:append>
                                    <v-btn icon @click="togglePasswordRevealed">
                                        <v-icon v-if="passwordRevealed" small
                                            >fas fa-eye-slash</v-icon
                                        >
                                        <v-icon v-else small>fas fa-eye</v-icon>
                                    </v-btn>
                                </template>
                            </v-text-field>
                        </div></v-card-text
                    >
                    <v-card-actions class="p-4 flex flex-wrap">
                        <div>
                            <v-checkbox
                                class="form-checkbox"
                                name="remember"
                                v-model="remember"
                                :label="$vuetify.lang.t('$vuetify.rememberMe')"
                            />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <inertia-link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-button text-decoration-underline text-opacity-60 dark:text-white dark:text-opacity-70"
                            >
                                {{ $vuetify.lang.t("$vuetify.forgotPassword") }}
                            </inertia-link>

                            <v-btn
                                rounded
                                class="ml-4"
                                color="primary text-button"
                                :disabled="form.processing"
                                type="submit"
                            >
                                <v-icon small class="mr-2"
                                    >fas fa-sign-in-alt</v-icon
                                >
                                {{ $vuetify.lang.t("$vuetify.login") }}
                            </v-btn>
                        </div>
                    </v-card-actions>
                    <v-overlay absolute :value="form.processing" z-index="0">
                        <v-progress-circular
                            indeterminate
                        ></v-progress-circular>
                    </v-overlay>
                </v-card>
            </v-form>
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
        canResetPassword: Boolean,
        status: String,
    },

    data() {
        return {
            snackbar: true,
            passwordType: true,
            passwordRevealed: false,
            remember: false,
            form: this.$inertia.form({
                email: "",
                password: "",
                remember: "",
            }),
            title: "login",
        };
    },

    watch: {
        remember(value) {
            this.form.remember = value ? "on" : "";
        },
    },

    methods: {
        togglePasswordRevealed() {
            this.passwordRevealed = !this.passwordRevealed;
            this.passwordType = !this.passwordType;
        },
        submit() {
            this.form.post(this.route("login"), {
                onSuccess: () => {
                    this.remember = false;
                },
            });
        },
    },
};
</script>
