<script setup>
defineProps({
    modelValue: String | Number,
    options: Object,
});

defineEmits(["update:modelValue"]);
</script>

<template>
    <select
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
    >
        <option
            v-for="option in options"
            :key="option.value"
            :value="option.value"
            class="p-4"
            :disabled="option.disabled"
        >
            {{ option.label }}
        </option>
    </select>
</template>
