<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { Modal } from '@inertiaui/modal-vue';
import { ref } from 'vue';

const modalRef = ref(null);

const page = usePage();

const form = useForm({
    name: null,
    description: null,
});

const submit = () => {
    form.post('/admin/categories', {
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
                Categories / Create
            </h2>

            <form @submit.prevent="submit">
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                        <input v-model="form.name" type="text" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Provide the category name" required />
                        <div v-if="page.props.errors.name" class="mt-2 text-sm text-red-700">{{ page.props.errors.name }}</div>

                    </div>
                    <div>
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                        <input v-model="form.description" type="text" id="description"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Provide a description" required />
                        <div v-if="page.props.errors.description" class="mt-2 text-sm text-red-700">{{ page.props.errors.description }}
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div></div>

                    <div class="flex items-center gap-x-10">
                        <button @click="modalRef.close" type="button" class="btn-ghost">Cancel</button>
                        <button type="submit" :disabled="form.processing" class="btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </Modal>
</template>
