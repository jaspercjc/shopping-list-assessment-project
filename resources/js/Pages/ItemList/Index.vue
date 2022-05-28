<template>
    <app-layout>
        <Head title="My Shopping List" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Shopping List
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-screen"
                >
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <Create :departments="departments" @created="reload" />

                        <div class="my-8">
                            <template
                                v-for="department in itemLists"
                                :key="department.id"
                            >
                                <h2
                                    class="font-bold text-2xl border-b-2 border-gray-200 mt-8 py-4"
                                >
                                    {{ department.name }}
                                </h2>

                                <ol class="space-y-4 divide-y divide-y-gray-50">
                                    <li
                                        v-for="list in department.item_list"
                                        class="px-8 py-4 flex items-center"
                                        :key="list.id"
                                        :class="list.purchased && 'opacity-25'"
                                    >
                                        <div
                                            class="grid grid-cols-12 items-center"
                                        >
                                            <div
                                                class="col-span-4 flex gap-4 items-center"
                                            >
                                                <JetCheckbox
                                                    :id="list.id"
                                                    v-model="list.purchased"
                                                    @change="update(list)"
                                                    :checked="
                                                        list.purchased
                                                            ? true
                                                            : false
                                                    "
                                                />
                                                <label :for="list.id">{{
                                                    list.item.name
                                                }}</label>
                                            </div>
                                            <div class="col-span-2">
                                                <JetInput
                                                    v-model="list.quantity"
                                                    type="number"
                                                    class="mt-1 block w-full"
                                                    required
                                                    :min="1"
                                                    :disabled="list.purchased"
                                                    @change="update(list)"
                                                />
                                            </div>
                                            <div class="col-span-6 text-right">
                                                <span
                                                    class="underline cursor-pointer text-xs"
                                                    @click="destroy(list.id)"
                                                    >Delete</span
                                                >
                                            </div>
                                        </div>
                                    </li>
                                </ol>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import Create from "@/Pages/ItemList/Components/Create.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import axios from "axios";

defineProps({
    departments: Array,
    itemLists: Array,
});

const destroy = (id) => {
    axios
        .delete(route("lists.destroy", id), {
            maxRedirects: 0,
        })
        .then(function () {
            reload();
        });
};

const update = (list) => {
    axios.put(route("lists.update", list.id), list).then(() => {
        reload();
    });
};

const reload = () => {
    Inertia.reload({ only: ["itemLists"] });
};
</script>

<style scoped></style>
