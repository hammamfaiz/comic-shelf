<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const genreInput = ref(null);
const publisherInput = ref(null);
const libraryInput = ref(null);
const titleInput = ref(null);
const authorInput = ref(null);
const stockInput = ref(null);
const priceInput = ref(null);
const genre = ref(null);
const publisher = ref(null);
const library = ref(null);

const form = useForm({
    genre: null,
    publisher: null,
    library: null,
    title: null,
    author: null,
    stock: null,
    price: null,
});

const storeData = (comic_genres, comic_publishers, libraries) => {
    form.genre = genre.value ? genre.value.id : comic_genres[0].id;
    form.publisher = publisher.value
        ? publisher.value.id
        : comic_publishers[0].id;
    form.library = library.value ? library.value.id : libraries[0].id;
    form.post(route("comics.store"), {
        errorBag: "storeData",
        preserveScroll: true,
        onError: () => {
            if (form.errors.genre) {
                form.reset("genre");
                genreInput.value.focus();
            }
            if (form.errors.publisher) {
                form.reset("publisher");
                publisherInput.value.focus();
            }
            if (form.errors.library) {
                form.reset("library");
                libraryInput.value.focus();
            }
            if (form.errors.title) {
                form.reset("title");
                titleInput.value.focus();
            }
            if (form.errors.author) {
                form.reset("author");
                authorInput.value.focus();
            }
            if (form.errors.stock) {
                form.reset("stock");
                stockInput.value.focus();
            }
            if (form.errors.price) {
                form.reset("price");
                priceInput.value.focus();
            }
        },
    });
};

const chooseGenre = (comic_genre) => {
    genre.value = comic_genre;
};

const choosePublisher = (comic_publisher) => {
    publisher.value = comic_publisher;
};

const chooseLibrary = (comic_library) => {
    library.value = comic_library;
};

defineProps({
    comic_genres: Object,
    comic_publishers: Object,
    libraries: Object,
});
</script>

<template>
    <AppLayout title="Comics">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Comics Management
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection
                @submitted="
                    storeData(comic_genres, comic_publishers, libraries)
                "
            >
                <template #title>Add Comic</template>

                <template #description>
                    Add a new comic data to database.
                </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="genre" value="Comic Genre" />
                        <div class="dropdown relative mt-2 w-full">
                            <button
                                ref="genreInput"
                                class="dropdown-toggle w-full px-6 py-3 bg-teal-800 text-white font-medium text-sm leading-tight capitalize rounded shadow-md hover:bg-teal-400 hover:shadow-lg focus:bg-teal-400 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-teal-800 active:shadow-lg transition duration-150 ease-in-out flex items-center whitespace-nowrap"
                                type="button"
                                id="genre"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                {{ genre ? genre.name : comic_genres[0].name }}
                                <div class="w-full flex justify-end">
                                    <svg
                                        aria-hidden="true"
                                        focusable="false"
                                        data-prefix="fas"
                                        data-icon="caret-down"
                                        class="w-2 ml-2"
                                        role="img"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 320 512"
                                    >
                                        <path
                                            fill="currentColor"
                                            d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"
                                        ></path>
                                    </svg>
                                </div>
                            </button>
                            <ul
                                class="dropdown-menu min-w-max absolute w-full bg-white text-base z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 hidden m-0 bg-clip-padding border-none"
                                aria-labelledby="dropdown_genre"
                            >
                                <li
                                    class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                    v-for="comic_genre in comic_genres"
                                    @click="chooseGenre(comic_genre)"
                                >
                                    {{ comic_genre.name }}
                                </li>
                            </ul>
                        </div>
                        <InputError :message="form.errors.genre" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="publisher" value="Comic Publisher" />
                        <div class="dropdown relative mt-2 w-full">
                            <button
                                ref="publisherInput"
                                class="dropdown-toggle w-full px-6 py-3 bg-teal-800 text-white font-medium text-sm leading-tight capitalize rounded shadow-md hover:bg-teal-400 hover:shadow-lg focus:bg-teal-400 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-teal-800 active:shadow-lg transition duration-150 ease-in-out flex items-center whitespace-nowrap"
                                type="button"
                                id="publisher"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                {{
                                    publisher
                                        ? publisher.name
                                        : comic_publishers[0].name
                                }}
                                <div class="w-full flex justify-end">
                                    <svg
                                        aria-hidden="true"
                                        focusable="false"
                                        data-prefix="fas"
                                        data-icon="caret-down"
                                        class="w-2 ml-2"
                                        role="img"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 320 512"
                                    >
                                        <path
                                            fill="currentColor"
                                            d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"
                                        ></path>
                                    </svg>
                                </div>
                            </button>
                            <ul
                                class="dropdown-menu min-w-max absolute w-full bg-white text-base z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 hidden m-0 bg-clip-padding border-none"
                                aria-labelledby="dropdown_publisher"
                            >
                                <li
                                    class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                    v-for="comic_publisher in comic_publishers"
                                    @click="choosePublisher(comic_publisher)"
                                >
                                    {{ comic_publisher.name }}
                                </li>
                            </ul>
                        </div>
                        <InputError
                            :message="form.errors.publisher"
                            class="mt-2"
                        />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="library" value="Library" />
                        <div class="dropdown relative mt-2 w-full">
                            <button
                                ref="libraryInput"
                                class="dropdown-toggle w-full px-6 py-3 bg-teal-800 text-white font-medium text-sm leading-tight capitalize rounded shadow-md hover:bg-teal-400 hover:shadow-lg focus:bg-teal-400 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-teal-800 active:shadow-lg transition duration-150 ease-in-out flex items-center whitespace-nowrap"
                                type="button"
                                id="library"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                {{ library ? library.name : libraries[0].name }}
                                <div class="w-full flex justify-end">
                                    <svg
                                        aria-hidden="true"
                                        focusable="false"
                                        data-prefix="fas"
                                        data-icon="caret-down"
                                        class="w-2 ml-2"
                                        role="img"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 320 512"
                                    >
                                        <path
                                            fill="currentColor"
                                            d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"
                                        ></path>
                                    </svg>
                                </div>
                            </button>
                            <ul
                                class="dropdown-menu min-w-max absolute w-full bg-white text-base z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 hidden m-0 bg-clip-padding border-none"
                                aria-labelledby="dropdown_publisher"
                            >
                                <li
                                    class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                    v-for="library in libraries"
                                    @click="chooseLibrary(library)"
                                >
                                    {{ library.name }}
                                </li>
                            </ul>
                        </div>
                        <InputError
                            :message="form.errors.library"
                            class="mt-2"
                        />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="title" value="Comic Title" />
                        <TextInput
                            id="title"
                            ref="titleInput"
                            v-model="form.title"
                            type="text"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors.title" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="author" value="Comic Author" />
                        <TextInput
                            id="author"
                            ref="authorInput"
                            v-model="form.author"
                            type="text"
                            class="mt-1 block w-full"
                        />
                        <InputError
                            :message="form.errors.author"
                            class="mt-2"
                        />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="stock" value="Comic Stock" />
                        <TextInput
                            id="stock"
                            ref="stockInput"
                            v-model="form.stock"
                            type="number"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors.stock" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="price" value="Comic Price" />
                        <TextInput
                            id="price"
                            ref="priceInput"
                            v-model="form.price"
                            type="number"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors.price" class="mt-2" />
                    </div>
                </template>

                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                        Saved.
                    </ActionMessage>

                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        class="bg-amber-300"
                    >
                        Save
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>
