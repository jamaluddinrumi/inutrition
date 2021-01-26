<template>
    <div>
        <transition leave-active-class="transition ease-in duration-1000" leave-class="opacity-100" leave-to-class="opacity-0">
            <div v-show="on" class="text-sm text-green-500 font-bold">
                <v-icon small class="text-green-500">fas fa-check</v-icon>
                <slot />
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: ['on'],
    }
</script>
