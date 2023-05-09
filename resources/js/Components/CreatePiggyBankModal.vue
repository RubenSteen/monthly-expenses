<script setup>
import { ref, watch, onUpdated } from 'vue'
import { useForm } from '@inertiajs/vue3';
import Modal from './Modal.vue';

import { ClipboardDocumentListIcon, ExclamationCircleIcon, ChevronUpDownIcon } from '@heroicons/vue/24/outline'

const emit = defineEmits(['close']);

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    edit: {
        type: Object,
        default: {},
    },
});

const editState = () => {
    if (Object.keys(props.edit).length === 0) {
        return false;
    }
    return true;
};

const form = useForm({
    name: '',
    description: '',
});

const submit = () => {
    if (editState()) {
        form.put(route('piggy-bank.update', props.edit), {
            preserveScroll: true,
            onSuccess: () => formSuccess(),
        });
    } else {
        form.post(route('piggy-bank.store'), {
            preserveScroll: true,
            onSuccess: () => formSuccess(),
        });
    }
};

const formSuccess = () => {
    close()
};

const close = () => {
    form.reset()
    emit('close');
};

const deletePiggyBank = () => {

};

onUpdated(() => {
    if (editState()) {
        form.name = props.edit.name
        form.description = props.edit.description
    }
})
</script>

<template>
    <Modal :show="props.show" :max-width="props.maxWidth" :closeable="props.closeable" @close="close">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

            <div class="border-b border-gray-200 pb-5 sm:flex sm:items-center sm:justify-between">
                <div class="flex items-center">
                    <div
                        class="mx-auto shrink-0 items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10 hidden sm:inline-flex">
                        <component :is="ClipboardDocumentListIcon" class="h-6 w-6 text-indigo-600" aria-hidden="true" />
                    </div>
                    <h3 class="text-base font-semibold leading-6 text-gray-90 pl-2">
                        <slot name="title" />
                    </h3>
                </div>
                <div class="mt-3 sm:ml-4 sm:mt-0">
                    <button type="button"
                        class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Delete</button>
                </div>
            </div>

            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <div class="mt-4 text-sm text-gray-600">
                        <form>
                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-3 sm:grid-cols-6">

                                <div class="sm:col-span-4">
                                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Naam</label>
                                    <div class="relative mt-2 rounded-md shadow-sm">
                                        <div class="mt-2">
                                            <input type="text" name="name" id="name" v-model="form.name"
                                                class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"
                                                :class="`${form.errors.name ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 text-gray-900'}`"
                                                placeholder="Boodschappen" />
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-red-600" id="name-error" v-if="form.errors.name">{{
                                        form.errors.name }}</p>
                                </div>

                                <div class="col-span-full">
                                    <label for="description"
                                        class="block text-sm font-medium leading-6 text-gray-900">Beschrijving</label>
                                    <div class="mt-2">
                                        <textarea id="description" name="description" rows="3" v-model="form.description"
                                            class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"
                                            :class="`${form.errors.description ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 text-gray-900'}`" />
                                    </div>
                                    <p class="mt-2 text-sm text-red-600" id="description-error"
                                        v-if="form.errors.description">{{
                                            form.errors.description
                                        }}</p>
                                </div>

                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-end px-6 bg-gray-100 text-right">
            <div class="my-2 flex items-center justify-end gap-x-6">
                <button @click="close" type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                <button type="submit" @click="submit" :disabled="form.processing"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            </div>
        </div>
    </Modal>
</template>