<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { defineComponent, defineProps } from "vue";

defineComponent({
    AppLayout,
    PrimaryButton,
    DangerButton,
});

defineProps({
    users: Object,
});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <PrimaryButton>Add New User</PrimaryButton>
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-8"
                >
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div
                                class="inline-block min-w-full sm:px-6 lg:px-8"
                            >
                                <div class="overflow-hidden">
                                    <table class="min-w-full text-center">
                                        <thead class="border-b bg-gray-50">
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4"
                                                >
                                                    #
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4"
                                                >
                                                    Name
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4"
                                                >
                                                    Email
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4"
                                                >
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                class="bg-white border-b"
                                                v-for="user in users"
                                                :key="user.id"
                                            >
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                                >
                                                    {{ user.id }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    {{ user.name }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    {{ user.email }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    <PrimaryButton>
                                                        Edit
                                                    </PrimaryButton>
                                                    <DangerButton class="ml-4">
                                                        Remove
                                                    </DangerButton>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
