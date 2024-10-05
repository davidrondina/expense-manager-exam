<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref, useSSRContext } from 'vue';
import { Modal, ModalLink } from '@inertiaui/modal-vue';

const modalRef = ref(null);

const props = defineProps({
    expense: Object,
    categories: Object,
});

const page = usePage();

const form = useForm({
    category: props.expense.expense_category_id,
    amount: props.expense.amount,
    entryDate: props.expense.entry_date,
});

const submit = () => {
    form.put(`/expenses/${props.expense.id}`, {
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
                Expense / Edit
            </h2>

            <form @submit.prevent="submit">
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                        <select v-model="form.category" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected disabled>Choose a category</option>
                            <option v-for="category in categories" :value="category.id" :selected="category.id === expense.expense_category_id">{{ category.name }}</option>
                        </select>
                        <div v-if="page.props.errors.category" class="mt-2 text-sm text-red-700">{{ page.props.errors.category }}
                        </div>
                    </div>
                    <div>
                        <label for="amount"
                            class="block mb-2 text-sm font-medium text-gray-900">Amount</label>
                        <input v-model="form.amount" type="text" id="amount"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Enter the amount" required />
                        <div v-if="page.props.errors.amount" class="mt-2 text-sm text-red-700">{{ page.props.errors.amount }}
                        </div>
                    </div>
                    <div>
                        <label for="entryDate" class="block mb-2 text-sm font-medium text-gray-900">Entry Date</label>
                        <input v-model="form.entryDate" type="date" name="entryDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="entryDate">
                        <div v-if="page.props.errors.entryDate" class="mt-2 text-sm text-red-700">{{ page.props.errors.entryDate }}
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <ModalLink :href="route('expenses.delete', props.expense.id)" @success="modalRef.close" as="button" class="btn-ghost">Delete</ModalLink>
                    </div>

                    <div class="flex items-center gap-x-5">
                        <button @click="modalRef.close" type="button" class="btn-ghost">Cancel</button>
                        <button type="submit" :disabled="form.processing" class="btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </Modal>
</template>
