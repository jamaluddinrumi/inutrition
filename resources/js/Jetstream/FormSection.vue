<template>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <jet-section-title>
            <template #title><slot name="title"></slot></template>
            <template #description><slot name="description"></slot></template>
        </jet-section-title>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <v-form @submit.prevent="$emit('submitted')">
                <v-card>
                    <v-card-text>
                        <slot name="form"></slot>
                    </v-card-text>
                    <v-card-actions class="flex justify-end">
                        <slot name="actions"></slot>
                    </v-card-actions>
                </v-card>
            </v-form>
        </div>
    </div>
</template>

<script>
    import JetSectionTitle from './SectionTitle'

    export default {
        components: {
            JetSectionTitle,
        },

        computed: {
            hasActions() {
                return !! this.$slots.actions
            }
        }
    }
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