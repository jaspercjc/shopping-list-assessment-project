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
                            <Items :items="department.items">
                                <template #header>
                                    {{ department.name }}
                                </template>
                            </Items>
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
import Items from "@/Pages/Item/Components/Items.vue";

defineProps({
    departments: Array,
});
</script>

<style scoped></style>
