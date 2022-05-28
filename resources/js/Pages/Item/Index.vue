<template>
    <app-layout>
        <Head title="Items" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Items
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex justify-end py-4 px-8">
                        <Link
                            :href="route('items.create')"
                            class="underline cursor-pointer"
                            >Create Item</Link
                        >
                    </div>

                    <div class="px-8 my-16 h-screen">
                        <template
                            v-for="department in departments"
                            :key="department.id"
                        >
                            <div
                                class="px-8 py-4 items-center border-b-2 border-gray-200"
                            >
                                <span class="font-bold text-2xl">{{
                                    department.name
                                }}</span>
                            </div>
                            <ol
                                class="px-8 space-y-4 divide-y divide-y-gray-50"
                            >
                                <li
                                    v-for="item in department.items"
                                    class="px-8 py-4 flex justify-between items-center"
                                    :key="item.id"
                                >
                                    <Link
                                        class="block"
                                        :href="route('items.edit', item)"
                                        >{{ item.name }}</Link
                                    >
                                    <span
                                        class="underline cursor-pointer text-xs"
                                        @click="destroy(item.id)"
                                        >Delete</span
                                    >
                                </li>
                            </ol>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    departments: Array,
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

<style scoped></style>
