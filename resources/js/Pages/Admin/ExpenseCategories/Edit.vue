<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Modal, ModalLink } from '@inertiaui/modal-vue';

const modalRef = ref(null);

const props = defineProps({
    category: Object
});

const page = usePage();

const form = useForm({
    name: props.category.name,
    description: props.category.description,
    categoryId: props.category.id,
});

const submit = () => {
    form.put(`/admin/categories/${props.category.id}`, {
        onFinish: visit => {
            if (Object.keys(form.errors).length === 0) {
                modalRef.value.close();
            }
        },
    });
}
</script>

<template>

    <Modal ref="modalRef">
        <div class="px-6 py-4 space-y-5 overflow-hidden bg-white shadow-sm sm:rounded-lg">

            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Category / Edit
            </h2>

            <form @submit.prevent="submit">
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                        <input v-model="form.name" type="text" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="John" required />
                        <div v-if="form.errors.name" class="text-red-700">{{ form.errors.name }}</div>
                    </div>
                    <div>
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                        <input v-model="form.description" type="text" id="description"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Doe" required />
                        <div v-if="form.errors.description" class="text-red-700">{{ form.errors.description }}
                        </div>
                    </div>
                    <input v-model="form.categoryId" type="hidden" />
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <ModalLink :href="route('admin.categories.delete', props.category.id)" @success="modalRef.close" as="button">Delete</ModalLink>
                    </div>

                    <div class="flex items-center gap-x-10">
                        <button @click="modalRef.close" type="button" class="btn-ghost">Cancel</button>
                        <button type="submit" class="btn-primary">Save changes</button>
                    </div>
                </div>

            </form>
        </div>
    </Modal>
</template>
