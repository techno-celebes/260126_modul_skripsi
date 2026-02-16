<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center rounded-xl border-2 border-gray-300 bg-white px-5 py-3 text-sm font-semibold uppercase tracking-wide text-gray-700 shadow-sm transition-all duration-300 ease-in-out hover:bg-gray-50 hover:border-gray-400 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-gray-200 focus:ring-offset-2 disabled:opacity-50"
    >
        <slot />
    </button>
</template>
