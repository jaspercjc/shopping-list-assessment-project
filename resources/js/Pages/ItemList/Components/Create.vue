<template>
    <div
        class="bg-gray-50 my-16 mx-8 rounded-xl p-4 border-2 border-gray-200 mb-2"
    >
        <h2 class="text-lg font-bold p-2">Add Item To Shopping List</h2>
        <hr class="py-2" />
        <form @submit.prevent="submit" class="gap-4 grid grid-cols-8">
            <div class="col-span-4">
                <JetSelect
                    id="item"
                    v-model="form.item_id"
                    class="mt-1 block w-full"
                    required
                    :options="options"
                    :class="form.errors.item_id && 'bg-red-200'"
                />
            </div>
            <div class="col-span-1">
                <JetInput
                    id="quantity"
                    v-model="form.quantity"
                    type="number"
                    class="mt-1 block w-full"
                    required
                    :min="1"
                    :class="form.errors.quantity && 'bg-red-200'"
                />
            </div>
            <div class="flex items-center justify-center col-span-3">
                <span
                    @click="submit"
                    class="underline"
                    :class="{
                        'text-gray-black cursor-pointer': form.isDirty,
                        'cursor-not-allowed text-gray-400': !form.isDirty,
                    }"
                    >Save</span
                >
            </div>
        </form>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetSelect from "@/Jetstream/Select.vue";
import { computed } from "vue";
import axios from "axios";
const form = useForm({
    quantity: 1,
    item_id: "",
});

const props = defineProps({
    departments: Array,
});

const emit = defineEmits(["created"]);

const options = computed(() => {
    let options = [{ value: "", label: "Please select" }];
    Object.values(props.departments).forEach((department) => {
        if (department.items?.length) {
            options = [
                ...options,
                {
                    value: department.id,
                    label: department.name,
                    disabled: true,
                },
            ];
            options = [
                ...options,
                ...department.items.map((item) => ({
                    value: item.id,
                    label: item.name,
                })),
            ];
        }
    });
    return options;
});

const submit = () => {
    if (form.isDirty)
        axios
            .post(route("lists.store"), form)
            .then(() => {
                form.quantity = 1;
                form.item_id = "";
                form.errors = { item_id: null, quantity: null };
                emit("created");
            })
            .catch((err) => {
                form.errors = err.response.data.errors;
            });
};
</script>

<style scoped></style>
