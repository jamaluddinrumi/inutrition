<template>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <jet-section-title>
            <template #title><slot name="title"></slot></template>
            <template #description><slot name="description"></slot></template>
        </jet-section-title>

        <v-card class="mt-5 md:mt-0 md:col-span-2">
            <form @submit.prevent="$emit('submitted')">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <slot name="form"></slot>
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-end px-4 py-3 text-right sm:px-6"
                        v-if="hasActions"
                    >
                        <slot name="actions"></slot>
                    </div>
                </div>
            </form>
        </v-card>
    </div>
</template>

<script>
import JetSectionTitle from "./SectionTitle";

export default {
    components: {
        JetSectionTitle,
    },

    computed: {
        hasActions() {
            return !!this.$slots.actions;
        },
    },
};
</script>
<style scope>
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
select {
    @apply ring-0;
    @apply bg-transparent;
}
</style>