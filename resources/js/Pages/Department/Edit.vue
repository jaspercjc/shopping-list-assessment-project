<template>
    <app-layout>
        <Head title="Department" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Department
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex justify-end py-4 px-8 space-x-4">
                        <Link
                            :href="route('departments.index')"
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
                        <form @submit.prevent="submit">
                            <div>
                                <JetLabel for="name" value="Department Name" />
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
                                />
                            </div>
                        </form>

                        <section class="mt-16">
                            <Items :items="department.items" />
                        </section>
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
import Items from "@/Pages/Item/Components/Items.vue";

const props = defineProps({
    department: Object,
});

const form = useForm({
    name: props.department.name,
});

const submit = () => {
    if (form.isDirty) form.put(route("departments.update", props.department));
};
</script>

<style scoped></style>
