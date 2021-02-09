<template>
    <layout :loading="form.processing">
        <jet-authentication-card>
            <template #logo>
                <jet-authentication-card-logo v-if="!$vuetify.theme.dark" />
                <jet-authentication-card-logo-dark v-else />
            </template>

            <jet-validation-errors class="mb-4" />

            <form @submit.prevent="submit">
                <v-card>
                    <v-card-text>
                        <div>
                            <v-text-field
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                                :label="$vuetify.lang.t('$vuetify.name')"
                            />
                        </div>

                        <div class="mt-4">
                            <v-text-field
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
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
                                autocomplete="new-password"
                                :label="$vuetify.lang.t('$vuetify.password')"
                            />
                        </div>

                        <div class="mt-4">
                            <v-text-field
                                id="password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                                :label="
                                    $vuetify.lang.t(
                                        '$vuetify.profile.confirmPassword'
                                    )
                                "
                            />
                        </div>
                    </v-card-text>
                    <v-card-actions class="p-4 flex flex-wrap">
                        <div
                            v-if="
                                $page.props.jetstream
                                    .hasTermsAndPrivacyPolicyFeature
                            "
                        >
                            <v-checkbox
                                class="form-checkbox h-4 w-4 mr-2 transition duration-150 ease-in-out w-full"
                                type="checkbox"
                                name="terms"
                                id="terms"
                                v-model="form.terms"
                            >
                                <div slot="label">
                                    {{
                                        $vuetify.lang.t("$vuetify.iAgreeToThe")
                                    }}
                                    <inertia-link
                                        target="_blank"
                                        :href="route('terms.show')"
                                        class="underline text-sm"
                                        >Terms of Service</inertia-link
                                    >
                                    {{ $vuetify.lang.t("$vuetify.and") }}
                                    <inertia-link
                                        target="_blank"
                                        :href="route('policy.show')"
                                        class="underline text-sm"
                                        >Privacy Policy</inertia-link
                                    >
                                </div>
                            </v-checkbox>
                        </div>

                        <div class="flex items-center justify-end mt-12">
                            <inertia-link
                                :href="route('login')"
                                class="text-button text-decoration-underline"
                            >
                                {{
                                    $vuetify.lang.t(
                                        "$vuetify.alreadyRegistered"
                                    )
                                }}
                            </inertia-link>

                            <v-btn
                                rounded
                                class="ml-4"
                                color="primary text-button"
                                :disabled="form.processing"
                                :loading="form.processing"
                                type="submit"
                            >
                                <v-icon small class="mr-2"
                                    >fas fa-user-plus</v-icon
                                >
                                {{ $vuetify.lang.t("$vuetify.register") }}
                            </v-btn>
                        </div>
                    </v-card-actions class="p-4">
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

    data() {
        return {
            form: this.$inertia.form({
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
                terms: null,
            }),
            title: "register",
        };
    },

    methods: {
        submit() {
            this.form.post(this.route("register"), {
                onSuccess: () => {
                    this.form.password = "";
                    this.form.password_confirmation = "";
                },
            });
        },
    },
};
</script>
