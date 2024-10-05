<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import VueApexCharts from 'vue3-apexcharts';

const props = defineProps({
    expenseCategories: Array,
    expensesByCategory: Object,
    totalExpensesByCategory: Array,
});

const pieChart = {
    chartOptions: {
        chart: {
            id: "vuechart-example",
        },
        labels: Object.keys(props.expenseCategories).length !== 0 ? props.expenseCategories : ['Test'],
    },
    series: props.totalExpensesByCategory.length !== 0 ? props.totalExpensesByCategory : [999],
};
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">My Expenses</h2>
        </template>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="flex items-center">
                    <apexchart
                    width="500"
                    type="pie"
                    :options="pieChart.chartOptions"
                    :series="pieChart.series"
                    ></apexchart>

                    <div v-if="totalExpensesByCategory.length !== 0" class="grid grid-cols-2 gap-x-8">
                        <div class="text-lg font-semibold">Expense Category</div>
                        <div class="text-lg font-semibold">Total</div>

                        <template v-for="expense in expensesByCategory">
                            <div>{{ expense.expense_category.name }}</div>
                            <div>{{ expense.total_amount }}</div>
                        </template>
                    </div>

                    <div v-else class="grid grid-cols-2 gap-x-8">
                        <div class="text-lg font-semibold">Expense Category</div>
                        <div class="text-lg font-semibold">Total</div>

                        <template v-for="categoryName in expenseCategories">
                            <div>{{ categoryName }}</div>
                            <div>0</div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
