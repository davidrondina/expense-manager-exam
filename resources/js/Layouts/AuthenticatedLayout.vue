<script setup>
import { ref, computed } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import NavGroup from '@/Components/NavGroup.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ModalRoot } from '@inertiaui/modal-vue';

const showingNavigationDropdown = ref(false);

const page = usePage();

const user = computed(() => page.props.auth.user)
const role = computed(() => page.props.auth.role)
</script>

<template>
    <div>
        <div class="flex w-full min-h-screen bg-gray-100">
            <nav class="w-[1000px] max-w-72 bg-indigo-600 border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="px-4 py-5 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="space-y-10">
                        <div><span class="text-white">{{ user.name }}</span></div>

                        <!-- Navigation Links -->
                        <div class="space-y-2">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                Dashboard
                            </NavLink>
                            <div v-if="role.toLowerCase() === 'administrator'" class="space-y-2">
                                <NavGroup :label="`User Management`">
                                    <NavLink :href="route('admin.roles.index')" :active="route().current('admin.roles.index')">
                                        Roles
                                    </NavLink>
                                    <NavLink :href="route('admin.users.index')" :active="route().current('admin.users.index')">
                                        Users
                                    </NavLink>
                                </NavGroup>
                                <NavGroup :label="`Expense Management`">
                                    <NavLink :href="route('admin.categories.index')" :active="route().current('admin.categories.index')">
                                        Expense Categories
                                    </NavLink>
                                    <NavLink :href="route('admin.expenses.index')" :active="route().current('admin.expenses.index')">
                                        Expenses
                                    </NavLink>
                                </NavGroup>
                            </div>
                            <div v-else class="space-y-2">
                                <NavLink :href="route('user.expenses.index')" :active="route().current('user.expenses.index')">
                                    Expenses
                                </NavLink>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>


            <div class="w-full">
                <div class="flex items-center justify-end w-full px-10 py-4 bg-white gap-x-8">
                    <span>Welcome to Expense Manager</span>
                    <Link :href="route('logout')" method="post" as="button">Logout</Link>
                </div>

                <div v-if="$page.props.flash.success"
                    class="p-4 my-4 text-sm font-medium text-green-800 bg-green-100 rounded-lg sm:mx-6 lg:mx-8"
                    role="alert">
                    {{ $page.props.flash.success }}
                </div>


                <!-- Page Heading -->
                <header v-if="$slots.header">
                    <div class="flex justify-between px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main class="text-gray-900">
                    <slot />
                </main>
            </div>
        </div>
    </div>

    <ModalRoot />
</template>
