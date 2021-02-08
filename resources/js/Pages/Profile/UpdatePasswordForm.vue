<template>
    <jet-form-section @submitted="updatePassword">
        <template #title>{{
            $vuetify.lang.t("$vuetify.profile.updatePassword")
        }}</template>

        <template #description>
            {{ $vuetify.lang.t("$vuetify.profile.ensurePassword") }}
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <v-text-field
                    :label="$vuetify.lang.t('$vuetify.profile.currentPassword')"
                    id="current_password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.current_password"
                    ref="current_password"
                    autocomplete="current-password"
                />
                <jet-input-error
                    :message="form.error('current_password')"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <v-text-field
                    :label="$vuetify.lang.t('$vuetify.profile.newPassword')"
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    autocomplete="new-password"
                />
                <jet-input-error
                    :message="form.error('password')"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <v-text-field
                    :label="$vuetify.lang.t('$vuetify.profile.confirmPassword')"
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    autocomplete="new-password"
                />
                <jet-input-error
                    :message="form.error('password_confirmation')"
                    class="mt-2"
                />
            </div>

            <v-overlay absolute :value="isSubmitted" z-index="0">
                <v-progress-circular indeterminate></v-progress-circular>
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
                :disabled="form.processing"
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
        JetLabel,
    },

    data() {
        return {
            form: this.$inertia.form(
                {
                    current_password: "",
                    password: "",
                    password_confirmation: "",
                },
                {
                    bag: "updatePassword",
                }
            ),

            isSubmitted: false,
        };
    },

    methods: {
        updatePassword() {
            this.form
                .put(route("user-password.update"), {
                    preserveScroll: true,
                    onStart: (visit) => {
                        this.isSubmitted = true;
                    },
                    onFinish: () => {
                        this.isSubmitted = false;
                    },
                })
                .then(() => {
                    this.$refs.current_password.focus();
                });
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