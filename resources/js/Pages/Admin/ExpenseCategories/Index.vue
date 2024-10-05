<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ModalLink } from '@inertiaui/modal-vue';
import moment from 'moment';

const props = defineProps({ categories: Object });
</script>

<template>

    <Head title="Expense Categories" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Expense Management / Categories</h2>
            <div>
                <ModalLink :href="route('admin.categories.create')" class="btn-primary">Create category</ModalLink>
            </div>
        </template>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div v-if="categories.length === 0" class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">No records found.
                </div>
            </div>
            <div v-else class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Date Created
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in categories" class="border-b odd:bg-white even:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ category.name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ category.description }}
                            </td>
                            <td class="px-6 py-4">
                                {{ moment(category.created_at).format('ll') }}
                            </td>
                            <td class="px-6 py-4">
                                <ModalLink :href="route('admin.categories.edit', category.id)"
                                    class="font-medium text-blue-600 hover:underline">Edit
                                </ModalLink>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </AuthenticatedLayout>
</template>
