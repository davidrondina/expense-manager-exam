<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Modal, ModalLink } from '@inertiaui/modal-vue';

const modalRef = ref(null);

const props = defineProps({
    role: Object
});

const form = useForm({
    name: props.role.name,
    description: props.role.description,
});

const submit = () => {
    form.delete(`/admin/roles/${props.role.id}`, {
        onFinish: visit => {
            modalRef.value.emit('success');
            modalRef.value.close();
        },
    });
}
</script>

<template>

    <Modal ref="modalRef">
        <div class="px-6 py-4 space-y-5 overflow-hidden bg-white shadow-sm sm:rounded-lg">

            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Delete Role?
            </h2>

            <p>This action cannot be undone.</p>

            <form @submit.prevent="submit">
                <div class="flex items-center justify-end">
                    <div class="flex items-center gap-x-10">
                        <button @click="modalRef.close" type="button" class="btn-ghost">Cancel</button>
                        <button type="submit" :disabled="form.processing" class="btn-primary">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </Modal>
    <!-- <Head title="Roles - Create" /> -->

    <!-- <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                <Link :href="route('admin.roles.index')" class="hover:underline">Roles</Link> / Create
            </h2>
        </template>

<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="px-6 py-4 overflow-hidden bg-white shadow-sm sm:rounded-lg">

            <form @submit.prevent="form.post(route('admin.roles.store'))">
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Role name</label>
                        <input v-model="form.name" type="text" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="John" required />
                        <div v-if="form.errors.name" class="text-red-700">{{ form.errors.name }}</div>

                    </div>
                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Describe
                            the
                            role</label>
                        <input v-model="form.description" type="text" id="description"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Doe" required />
                        <div v-if="form.errors.description" class="text-red-700">{{ form.errors.description }}
                        </div>
                    </div>
                </div>

                <button type="submit" :disabled="form.processing">Save</button>

            </form>
        </div>
    </div>
</div>
</AuthenticatedLayout> -->
</template>
