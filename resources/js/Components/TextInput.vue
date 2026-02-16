<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="rounded-xl border-2 border-gray-300 shadow-sm px-4 py-3 transition-all duration-300 focus:border-green-500 focus:ring-4 focus:ring-green-100 focus:outline-none"
        v-model="model"
        ref="input"
    />
</template>
