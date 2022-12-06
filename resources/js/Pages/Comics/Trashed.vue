<script setup>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

defineComponent({
    AppLayout,
    PrimaryButton,
    DangerButton,
});

defineProps({
    trashed_comics: Object,
});
</script>

<template>
    <AppLayout title="Comics">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trashed Comics
            </h2>
        </template>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                                    Comic Genre
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left"
                                                >
                                                    Comic Publisher
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left"
                                                >
                                                    Library
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left"
                                                >
                                                    Comic Title
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left"
                                                >
                                                    Comic Author
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left"
                                                >
                                                    Comic Stock
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left"
                                                >
                                                    Comic Price
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
                                                v-if="trashed_comics.length > 0"
                                                v-for="trashed_comic in trashed_comics"
                                                :key="trashed_comic.id"
                                            >
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                                >
                                                    {{ trashed_comic.id }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    {{
                                                        trashed_comic.comic_genre_name
                                                    }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    {{
                                                        trashed_comic.comic_publisher_name
                                                    }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    {{
                                                        trashed_comic.library_name
                                                    }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    {{ trashed_comic.title }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    {{ trashed_comic.author }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    {{ trashed_comic.stock }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    {{ trashed_comic.price }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    <Link
                                                        :href="
                                                            route(
                                                                'comics.restore',
                                                                trashed_comic.id
                                                            )
                                                        "
                                                    >
                                                        <PrimaryButton
                                                            class="bg-amber-300"
                                                        >
                                                            Restore
                                                        </PrimaryButton>
                                                    </Link>
                                                    <Link
                                                        :href="
                                                            route(
                                                                'comics.destroy_permanent',
                                                                trashed_comic.id
                                                            )
                                                        "
                                                    >
                                                        <DangerButton
                                                            class="ml-4 bg-teal-800 text-white"
                                                        >
                                                            Permanently Remove
                                                        </DangerButton>
                                                    </Link>
                                                </td>
                                            </tr>
                                            <tr
                                                class="bg-rose-50 border-b transition duration-300 ease-in-out hover:bg-rose-100"
                                                v-else
                                            >
                                                <td
                                                    colspan="9"
                                                    class="text-sm text-center text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    There is no trashed data
                                                    available
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
