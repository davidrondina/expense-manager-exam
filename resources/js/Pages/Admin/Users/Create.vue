<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { Modal } from '@inertiaui/modal-vue';
import { ref, computed } from 'vue';


const props = defineProps({
    roles: Object,
});

const page = usePage();

const modalRef = ref(null);

const form = useForm({
    name: null,
    email: null,
    role: null,
});

const submit = () => {
    form.post('/admin/users', {
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
                Users / Create
            </h2>

            <form @submit.prevent="submit">
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                        <input v-model="form.name" type="text" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Provide the user name" required />
                        <div v-if="page.props.errors.name" class="mt-2 text-sm text-red-700">{{ page.props.errors.name }}</div>

                    </div>
                    <div>
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input v-model="form.email" type="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Provide an email address" required />
                        <div v-if="page.props.errors.email" class="mt-2 text-sm text-red-700">{{ page.props.errors.email }}
                        </div>
                    </div>
                    <div>
                        <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                        <select v-model="form.role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected disabled>Choose a role</option>
                            <option v-for="role in roles" :value="role.id">{{ role.name }}</option>
                        </select>
                        <div v-if="page.props.errors.role" class="mt-2 text-sm text-red-700">{{ page.props.errors.role }}
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
