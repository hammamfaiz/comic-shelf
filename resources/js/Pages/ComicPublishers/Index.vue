<script setup>
import { ref, defineComponent, onMounted } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TextInput from "@/Components/TextInput.vue";

const search = ref(null);

defineComponent({
    AppLayout,
    PrimaryButton,
    DangerButton,
});

defineProps({
    comic_publishers: Object,
});

const onSearch = (search) => {
    location.href = `/comics/publishers?search=${search}`;
};

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    const searchQuery = params.get("search");
    search.value = searchQuery;
});
</script>

<template>
    <AppLayout title="Comic Publishers">
        <template #header>
            <h2 class="font-semibold text-xl text-black leading-tight">
                Comic Publisher Management
            </h2>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex">
                    <div class="w-1/2">
                        <Link :href="route('comics.publishers.create')">
                            <PrimaryButton class="bg-amber-300">
                                Add New Comic Publisher
                            </PrimaryButton>
                        </Link>
                        <Link :href="route('comics.publishers.trashed')">
                            <PrimaryButton class="ml-4 bg-amber-300">
                                Trashed Comic Publisher
                            </PrimaryButton>
                        </Link>
                    </div>
                    <div class="w-1/2">
                        <TextInput
                            id="search"
                            type="text"
                            class="block w-full"
                            placeholder="Search Comic Publishers..."
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
                                                    Comic Publisher Name
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
                                                v-if="
                                                    comic_publishers.length > 0
                                                "
                                                v-for="comic_publisher in comic_publishers"
                                                :key="comic_publisher.id"
                                            >
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                                >
                                                    {{ comic_publisher.id }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    {{ comic_publisher.name }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    <Link
                                                        :href="
                                                            route(
                                                                'comics.publishers.edit',
                                                                comic_publisher.id
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
                                                                'comics.publishers.destroy',
                                                                comic_publisher.id
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
                                                    colspan="3"
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
