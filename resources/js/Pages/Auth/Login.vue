<template>
    <layout>
        <jet-authentication-card>
            <template #logo>
                <template v-if="$vuetify.breakpoint.mobile">
                    <jet-authentication-card-logo v-if="!$vuetify.theme.dark" />
                    <jet-authentication-card-logo-dark v-else />
                </template>
            </template>

            <jet-validation-errors class="mb-4" />

            <div v-if="status" class="mb-4 font-medium text-sm">
                {{ status }}
            </div>

            <v-form @submit.prevent="submit">
                <v-card
                    :loading="form.processing"
                    :disabled="form.processing"
                    elevation="3"
                    rounded
                >
                    <v-card-text
                        ><div>
                            <v-text-field
                                :rules="[rules.required, rules.email]"
                                clearable
                                outlined
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
                                :append-icon="
                                    showPassword ? 'mdi-eye' : 'mdi-eye-off'
                                "
                                :rules="[rules.required]"
                                :type="showPassword ? 'text' : 'password'"
                                @click:append="showPassword = !showPassword"
                                clearable
                                outlined
                                id="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                                :label="$vuetify.lang.t('$vuetify.password')"
                                hint="(demo1234)"
                                persistent-hint
                            >
                            </v-text-field></div
                    ></v-card-text>
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
                                class="text-button no-underline text-opacity-60 dark:text-white dark:text-opacity-70"
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
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import JetValidationErrors from "@/Jetstream/ValidationErrors";
import Layout from "@/Pages/Auth/Layout";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo";
import JetAuthenticationCardLogoDark from "@/Jetstream/AuthenticationCardLogoDark";

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
        JetButton,
        JetInput,
        JetLabel,
        JetValidationErrors,
        Layout,
        JetAuthenticationCardLogo,
        JetAuthenticationCardLogoDark
    },

    props: {
        canResetPassword: Boolean,
        status: String
    },

    data() {
        return {
            showPassword: false,
            rules: {
                required: value =>
                    !!value || this.$vuetify.lang.t("$vuetify.fieldIsRequired"),
                min: v => v.length >= 8 || "Min 8 characters",
                counter: value => value.length <= 20 || "Max 20 characters",
                email: value => {
                    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return pattern.test(value) || "Invalid e-mail.";
                }
            },
            snackbar: true,
            passwordType: true,
            passwordRevealed: false,
            remember: false,
            form: this.$inertia.form({
                email: "",
                password: "",
                remember: ""
            }),
            title: "login"
        };
    },

    watch: {
        remember(value) {
            this.form.remember = value ? "on" : "";
        }
    },

    computed: {},

    methods: {
        togglePasswordRevealed() {
            this.passwordRevealed = !this.passwordRevealed;
            this.passwordType = !this.passwordType;
        },
        submit() {
            this.form.post(this.route("login"), {
                onSuccess: () => {
                    this.remember = false;
                }
            });
        }
    }
};
</script>
