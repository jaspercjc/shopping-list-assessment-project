<template>
    <div class="py-4 items-center border-b-2 border-gray-200">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <slot name="header">Items</slot>
        </h2>
    </div>
    <ol class="space-y-4 divide-y divide-y-gray-50">
        <li
            v-for="item in items"
            class="px-8 py-4 flex justify-between items-center"
            :key="item.id"
        >
            <Link class="block" :href="route('items.edit', item)">{{
                item.name
            }}</Link>
            <span
                class="underline cursor-pointer text-xs"
                @click="destroy(item.id)"
                >Delete</span
            >
        </li>
    </ol>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    items: Object,
});

const destroy = (id) => {
    axios
        .delete(route("items.destroy", id), {
            maxRedirects: 0,
        })
        .then(function (response) {
            Inertia.reload();
        });
};
</script>
