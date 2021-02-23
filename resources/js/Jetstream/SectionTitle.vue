<template>
    <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
            <h3 class="text-h6">
                <slot name="title"></slot>
            </h3>

            <p class="mt-1 text-subtitle-2">
                <slot name="description"></slot>
            </p>
        </div>
    </div>
</template>
