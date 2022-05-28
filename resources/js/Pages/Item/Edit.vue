<template>
    <app-layout>
        <Head title="Edit Item" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Item
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex justify-end py-4 px-8 space-x-4">
                        <Link
                            :href="route('items.index')"
                            class="underline cursor-pointer"
                            >Cancel</Link
                        >
                        <span
                            @click="submit"
                            class="underline"
                            :class="{
                                'text-gray-black cursor-pointer': form.isDirty,
                                'cursor-not-allowed text-gray-400':
                                    !form.isDirty,
                            }"
                            >Update</span
                        >
                    </div>

                    <div class="px-8 my-16 h-screen">
                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <JetLabel for="name" value="Item Name" />
                                <span
                                    v-if="form.errors.name"
                                    class="text-red-500 text-xs"
                                    >{{ form.errors.name }}</span
                                >
                                <JetInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    :class="form.errors.name && 'bg-red-200'"
                                />
                            </div>
                            <div>
                                <JetLabel
                                    for="department"
                                    value="Item Department"
                                />
                                <span
                                    v-if="form.errors.department_id"
                                    class="text-red-500 text-xs"
                                    >{{ form.errors.department_id }}</span
                                >
                                <JetSelect
                                    id="department"
                                    v-model="form.department_id"
                                    class="mt-1 block w-full"
                                    required
                                    :options="options"
                                    :class="
                                        form.errors.department_id &&
                                        'bg-red-200'
                                    "
                                />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetSelect from "@/Jetstream/Select.vue";
import { computed } from "vue";

const form = useForm({
    name: props.item.name,
    department_id: props.item.department_id,
});

const props = defineProps({
    item: Object,
    departments: Array,
});

const options = computed(() => {
    return [
        { value: "", label: "Please select" },
        ...props.departments.map((department) => ({
            value: department.id,
            label: department.name,
        })),
    ];
});

const submit = () => {
    if (form.isDirty) form.put(route("items.update", props.item));
};
</script>

<style scoped></style>
