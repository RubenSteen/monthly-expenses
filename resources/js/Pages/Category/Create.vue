<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from 'laravel-precognition-vue-inertia';

const form = useForm('post', route('category.store'), {
    name: ''
});

const submit = () => form.submit({
    preserveScroll: true,
    onSuccess: () => form.reset(),
});
</script>

<template>
    <AppLayout :title="`Categorie aanmaken`">

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow mt-4">
                <div class="px-4 py-5 sm:p-6">

                    <form @submit.prevent="submit">
                        <div class="space-y-12">
                            <div class="border-b border-gray-900/10 pb-4">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Categorie aanmaken</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Met categorieën breng je beter in zicht
                                    onder welke definitie een transactie valt.</p>

                                <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="username"
                                            class="block text-sm font-medium leading-6 text-gray-900">Naam</label>
                                        <div class="mt-2">
                                            <div class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"
                                                :class="`${form.invalid('name') ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 text-gray-900'}`">
                                                <input type="text" name="name" id="name" v-model="form.name"
                                                    @change="form.validate('name')"
                                                    class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                    placeholder="Uitgaven" />
                                            </div>
                                            <p class="mt-2 text-sm text-red-600" id="name-error"
                                                v-if="form.invalid('name')">{{
                                                    form.errors.name
                                                }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-end gap-x-6">
                            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                            <button type="submit"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </AppLayout>
</template>