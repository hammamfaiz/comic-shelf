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
    trashed_comic_genres: Object,
});
</script>

<template>
    <AppLayout title="Comic Genres">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trashed Comic Genres
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
                                                    Comic Genre Name
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
                                                    trashed_comic_genres.length >
                                                    0
                                                "
                                                v-for="trashed_comic_genre in trashed_comic_genres"
                                                :key="trashed_comic_genre.id"
                                            >
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                                >
                                                    {{ trashed_comic_genre.id }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    {{
                                                        trashed_comic_genre.name
                                                    }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                                >
                                                    <Link
                                                        :href="
                                                            route(
                                                                'comics.genres.restore',
                                                                trashed_comic_genre.id
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
                                                                'comics.genres.destroy_permanent',
                                                                trashed_comic_genre.id
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
                                                    colspan="4"
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
