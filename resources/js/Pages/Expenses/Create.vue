<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { Modal } from '@inertiaui/modal-vue';
import { ref, computed, onMounted } from 'vue';
import { initFlowbite } from 'flowbite';


const props = defineProps({
    categories: Object,
});

const page = usePage();

const modalRef = ref(null);

const form = useForm({
    category: null,
    amount: null,
    entryDate: null,
});

const submit = () => {
    form.post('/expenses', {
        onFinish: visit => {
            if (Object.keys(form.errors).length === 0) {
                modalRef.value.close();
            }
        },
    });
}

onMounted(() => {
    initFlowbite();
})

</script>

<template>
    <Modal ref="modalRef">
        <div class="px-6 py-4 space-y-5 overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Expenses / Create
            </h2>

            <form @submit.prevent="submit">
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                        <select v-model="form.category" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected disabled>Choose a category</option>
                            <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
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
