<template>
    <layout :loading="form.processing">
        <jet-authentication-card>
            <template #logo>
                <jet-authentication-card-logo />
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
                            />
                        </div>

                        <div class="mt-4">
                            <v-text-field
                                id="password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                                :label="$vuetify.lang.t('$vuetify.password')"
                            /></div
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
                                class="underline text-sm"
                            >
                                {{ $vuetify.lang.t("$vuetify.forgotPassword") }}
                            </inertia-link>

                            <v-btn
                                rounded
                                class="ml-4"
                                color="primary font-bold"
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
                    <v-overlay absolute :value="form.processing">
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