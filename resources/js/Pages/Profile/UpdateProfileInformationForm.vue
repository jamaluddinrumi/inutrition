<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>{{
            $vuetify.lang.t("$vuetify.profile.profileInformation")
        }}</template>

        <template #description>
            {{ $vuetify.lang.t("$vuetify.profile.updateProfileInfo") }}
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div
                class="col-span-6 sm:col-span-4"
                v-if="$page.props.jetstream.managesProfilePhotos"
            >
                <!-- Profile Photo File Input -->
                <input
                    type="file"
                    class="hidden"
                    ref="photo"
                    @change="updatePhotoPreview"
                />

                <h4>{{ $vuetify.lang.t("$vuetify.profile.photo") }}</h4>

                <!-- Current Profile Photo -->
                <div class="mt-2" v-show="!photoPreview">
                    <v-img
                        :src="$page.props.user.profile_photo_url"
                        :alt="$page.props.user.name"
                        class="rounded-full h-20 w-20 object-cover"
                    />
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                    <span
                        class="block rounded-full w-20 h-20"
                        :style="
                            'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' +
                            photoPreview +
                            '\');'
                        "
                    >
                    </span>
                </div>

                <v-btn
                    small
                    fab
                    color="primary"
                    class="mt-2 mr-2 mb-2"
                    @click="selectNewPhoto"
                >
                    <v-icon small>fas fa-camera</v-icon>
                </v-btn>

                <v-btn
                    small
                    fab
                    color="error"
                    class="mt-2 mb-2"
                    @click.native.prevent="deletePhoto"
                    v-if="$page.props.user.profile_photo_path"
                >
                    <v-icon small>fas fa-trash</v-icon>
                </v-btn>

                <jet-input-error :message="form.error('photo')" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4 mt-6">
                <v-text-field
                    outlined
                    :label="$vuetify.lang.t('$vuetify.name')"
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    autocomplete="name"
                />
                <jet-input-error :message="form.error('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <v-text-field
                    outlined
                    :label="$vuetify.lang.t('$vuetify.email')"
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                />
                <jet-input-error :message="form.error('email')" class="mt-2" />
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
                rounded
                type="submit"
                color="primary"
                class="elevation-2 text-button px-4"
                :disabled="form.processing"
            >
                <v-icon small dark class="mr-2">fas fa-save</v-icon>
                {{ $vuetify.lang.t("$vuetify.save") }}
            </v-btn>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
    },

    props: ["user"],

    data() {
        return {
            form: this.$inertia.form(
                {
                    _method: "PUT",
                    name: this.user.name,
                    email: this.user.email,
                    photo: null,
                },
                {
                    bag: "updateProfileInformation",
                    resetOnSuccess: false,
                }
            ),

            photoPreview: null,
            isSubmitted: false,
        };
    },

    methods: {
        updateProfileInformation() {
            // this.isSubmitted = true;

            if (this.$refs.photo) {
                this.form.photo = this.$refs.photo.files[0];
            }

            this.form.post(route("user-profile-information.update"), {
                preserveScroll: true,
                onStart: (visit) => {
                    this.isSubmitted = true;
                },
                onFinish: () => {
                    this.isSubmitted = false;
                },
            });
        },

        selectNewPhoto() {
            this.$refs.photo.click();
        },

        updatePhotoPreview() {
            const reader = new FileReader();

            reader.onload = (e) => {
                this.photoPreview = e.target.result;
            };

            reader.readAsDataURL(this.$refs.photo.files[0]);
        },

        deletePhoto() {
            this.$inertia
                .delete(route("current-user-photo.destroy"), {
                    preserveScroll: true,
                })
                .then(() => {
                    this.photoPreview = null;
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