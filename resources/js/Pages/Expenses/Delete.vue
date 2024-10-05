<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Modal, ModalLink } from '@inertiaui/modal-vue';

const modalRef = ref(null);

const props = defineProps({
    expense: Object
});

const form = useForm({});

const submit = () => {
    form.delete(`/expenses/${props.expense.id}`, {
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
                Delete Expense?
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
</template>
