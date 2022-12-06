<script setup>
import { ref, defineComponent, onMounted } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TextInput from "@/Components/TextInput.vue";

const search = ref(null);
const onSearch = (search) => {
    location.href = `/libraries?search=${search}`;
};
// const onSort = (desc) => {
//     location.href = "/libraries?sort=${desc}";
// };

defineComponent({
    AppLayout,
    PrimaryButton,
    DangerButton,
});

defineProps({
    libraries: Object,
});

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    const searchQuery = params.get("search");
    search.value = searchQuery;
});
</script>

<template>
    <AppLayout title="Libraries">
        <template #header>
            <h2 class="font-semibold text-xl text-black leading-tight">
                Library Management
            </h2>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex">
                    <div class="w-1/2">
                        <Link :href="route('libraries.create')">
                            <PrimaryButton class="bg-amber-300">
                                Add New Library
                            </PrimaryButton>
                        </Link>
                        <Link :href="route('libraries.trashed')">
                            <PrimaryButton class="ml-4 bg-amber-300">
                                Trashed Library
                            </PrimaryButton>
                        </Link>
                        <!-- <PrimaryButton
                            class="ml-4 bg-amber-300"
                            @click="onSort(true)"
                        >
                            Sort By Number
                        </PrimaryButton> -->
                    </div>
                    <div class="w-1/2">
                        <TextInput
                            id="search"
                            type="text"
                            class="block w-full"
                            placeholder="Search Libraries..."
                            v-model="search"
                            @keyup.enter="onSearch(search)"
                        />
                    </div>
                </div>
                <div
                    class="bg-stone-400 overflow-hidden shadow-xl sm:rounded-lg mt-8"
                >
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div
                                class="inline-block min-w-full sm:px-6 lg:px-8"
                            >
                                <div class="overflow-hidden">
                                    <table class="min-w-full">
                                        <thead class="bg-stone-400 border-b">
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left"
                                                >
                                                    ID
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left"
                                                >
                                                    Library Name
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left"
                                                >
                                                    Library Stock
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left"
                                                >
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                class="bg-rose-50 border-b transition duration-300 ease-in-out hover:bg-slate-100"
                                                v-if="libraries.length > 0"
                                                v-for="library in libraries"
                                                :key="library.id"
                                            >
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                                >
                                                    {{ library.id }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    {{ library.name }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    {{ library.stock }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    <Link
                                                        :href="
                                                            route(
                                                                'libraries.edit',
                                                                library.id
                                                            )
                                                        "
                                                    >
                                                        <PrimaryButton
                                                            class="bg-amber-300"
                                                        >
                                                            Edit
                                                        </PrimaryButton>
                                                    </Link>
                                                    <Link
                                                        :href="
                                                            route(
                                                                'libraries.destroy',
                                                                library.id
                                                            )
                                                        "
                                                    >
                                                        <DangerButton
                                                            class="ml-4 bg-teal-800 text-white"
                                                        >
                                                            Remove
                                                        </DangerButton>
                                                    </Link>
                                                </td>
                                            </tr>
                                            <tr
                                                class="bg-rose-50 border-b transition duration-300 ease-in-out hover:bg-rose-100"
                                                v-else
                                            >
                                                <td
                                                    colspan="4"
                                                    class="text-sm text-center text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    There is no data available
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
