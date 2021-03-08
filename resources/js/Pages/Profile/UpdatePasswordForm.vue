<template>
    <jet-form-section @submitted="updatePassword">
        <template #title>{{
            $vuetify.lang.t("$vuetify.profile.updatePassword")
        }}</template>

        <template #description>
            {{ $vuetify.lang.t("$vuetify.profile.ensurePassword") }}
        </template>

        <template #form>
            <h4 class="mb-4">
                {{ $vuetify.lang.t("$vuetify.profile.password") }}
            </h4>
            <div class="col-span-6 sm:col-span-4">
                <jet-input-error
                    :message="form.error('current_password')"
                    class=""
                />
                <v-text-field
                    :append-icon="
                        showCurrentPassword ? 'mdi-eye' : 'mdi-eye-off'
                    "
                    :type="showCurrentPassword ? 'text' : 'password'"
                    @click:append="showCurrentPassword = !showCurrentPassword"
                    clearable
                    outlined
                    :label="$vuetify.lang.t('$vuetify.profile.currentPassword')"
                    id="current_password"
                    class="mt-1 block w-full"
                    v-model="form.current_password"
                    ref="current_password"
                    autocomplete="current-password"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-input-error :message="form.error('password')" class="" />
                <v-text-field
                    :append-icon="showNewPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="showNewPassword ? 'text' : 'password'"
                    @click:append="showNewPassword = !showNewPassword"
                    counter
                    clearable
                    outlined
                    :label="$vuetify.lang.t('$vuetify.profile.newPassword')"
                    id="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    autocomplete="new-password"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-input-error
                    :message="form.error('password_confirmation')"
                    class=""
                />
                <v-text-field
                    :append-icon="
                        showConfirmPassword ? 'mdi-eye' : 'mdi-eye-off'
                    "
                    :type="showConfirmPassword ? 'text' : 'password'"
                    @click:append="showConfirmPassword = !showConfirmPassword"
                    counter
                    clearable
                    outlined
                    :label="$vuetify.lang.t('$vuetify.profile.confirmPassword')"
                    id="password_confirmation"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                />
            </div>

            <v-overlay absolute :value="isSubmitted" z-index="0">
                <v-progress-circular
                    v-show="loadingIndicator"
                    indeterminate
                ></v-progress-circular>
                <v-icon
                    v-show="isSuccessChanged"
                    color="white"
                    size="120"
                    z-index="1"
                    >fas fa-check-circle</v-icon
                >
            </v-overlay>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                {{ $vuetify.lang.t("$vuetify.profile.saved") }}
            </jet-action-message>

            <v-btn
                type="submit"
                rounded
                color="primary"
                class="text-button elevation-2 px-4"
                :disabled="loadingIndicator || isSuccessChanged"
            >
                <v-icon small class="mr-2">fa fa-save</v-icon>
                {{ $vuetify.lang.t("$vuetify.save") }}
            </v-btn>
        </template>
    </jet-form-section>
</template>

<script>
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel
    },

    data() {
        return {
            isSuccessChanged: false,
            loadingIndicator: false,
            showConfirmPassword: false,
            showNewPassword: false,
            showCurrentPassword: false,
            form: this.$inertia.form(
                {
                    current_password: "",
                    password: "",
                    password_confirmation: ""
                },
                {
                    bag: "updatePassword"
                }
            ),

            isSubmitted: false
        };
    },

    methods: {
        updatePassword() {
            this.form
                .put(route("user-password.update"), {
                    preserveScroll: true,
                    onStart: () => {
                        this.loadingIndicator = true;
                        this.isSubmitted = true;
                    },
                    onSuccess: () => {
                        this.loadingIndicator = false;
                        if (Object.keys(this.$page.props.errors).length <= 0)
                            this.isSuccessChanged = true;
                    },
                    onFinish: () => {
                        if (Object.keys(this.$page.props.errors).length <= 0) {
                            setTimeout(() => {
                                this.isSubmitted = false;
                                this.isSuccessChanged = false;
                            }, 1000);
                        } else {
                            this.isSubmitted = false;
                        }
                    }
                })
                .then(() => {
                    this.$refs.current_password.focus();
                });
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
