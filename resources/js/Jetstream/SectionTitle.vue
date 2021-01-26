<template>
    <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
            <div class="text-lg font-medium text-h5">
                <slot name="title"></slot>
            </div>

            <div class="mt-1 text-sm text-subtitle-2">
                <slot name="description"></slot>
            </div>
        </div>
    </div>
</template>
