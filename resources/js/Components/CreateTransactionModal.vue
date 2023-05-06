<script setup>
import { ref } from 'vue';
import Modal from './Modal.vue';

import { ClipboardDocumentListIcon, ExclamationCircleIcon, ChevronUpDownIcon } from '@heroicons/vue/24/outline'

const emit = defineEmits(['close']);

defineProps({
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
    errors: {
        type: Object,
        default: () => ({})
    },
});

const selectPeriodValue = ref(1);

const selectFromValue = ref(1);

const selectToValue = ref(1);

const close = () => {
    emit('close');
};

const periods = [
    {
        id: 1,
        name: 'Maandelijks',
    },
    {
        id: 2,
        name: 'Jaarlijks',
    },
]

const piggyBanks = [
    {
        id: 1,
        name: 'Mij (Eigen rekening)',
    },
    {
        id: 2,
        name: 'Gezamelijke rekening',
    },
    {
        id: 3,
        name: 'Boodschappen',
    },
    {
        id: 4,
        name: 'Kleding',
    },
    {
        id: 5,
        name: 'Auto',
    },
    {
        id: 6,
        name: 'Koophuis',
    },
    {
        id: 7,
        name: 'Bezine',
    },
]
</script>

<template>
    <Modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div
                    class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                    <component :is="ClipboardDocumentListIcon" class="h-6 w-6 text-indigo-600" aria-hidden="true" />
                </div>

                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg font-medium text-gray-900">
                        <slot name="title" />
                    </h3>

                    <div class="mt-4 text-sm text-gray-600">
                        <form>
                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-3 sm:grid-cols-6">

                                <div class="sm:col-span-4">
                                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Naam</label>
                                    <div class="relative mt-2 rounded-md shadow-sm">
                                        <div class="mt-2">
                                            <input type="text" name="name" id="name"
                                                class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"
                                                :class="`${errors.name ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 text-gray-900'}`"
                                                placeholder="Boodschappen" />
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-red-600" id="name-error" v-if="errors.name">{{
                                        errors.name
                                    }}</p>
                                </div>

                                <div class="sm:col-span-4">
                                    <label for="amount"
                                        class="block text-sm font-medium leading-6 text-gray-900">Kosten</label>
                                    <div class="relative mt-2 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">€</span>
                                        </div>
                                        <input type="text" name="amount" id="amount"
                                            class="block w-full rounded-md border-0 py-1.5 pl-7 pr-12 ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"
                                            :class="`${errors.name ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 text-gray-900'}`"
                                            placeholder="0,00" aria-describedby="amount-currency" />
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-500 sm:text-sm" id="amount-currency">EUR</span>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-red-600" id="amount-error" v-if="errors.amount">{{
                                        errors.amount
                                    }}</p>
                                </div>

                                <div class="sm:col-span-4">
                                    <div class="relative mt-2 rounded-md shadow-sm">
                                        <label for="period"
                                            class="block text-sm font-medium leading-6 text-gray-900">Herhaling</label>
                                        <select id="period" name="period" v-model="selectPeriodValue"
                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 ring-1 ring-inset focus:ring-2 sm:text-sm sm:leading-6"
                                            :class="`${errors.name ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 text-gray-900'}`">
                                            <option v-for="option in periods" v-bind:value="option.id" :key="option.id"
                                                required>
                                                {{ option.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <p class="mt-2 text-sm text-red-600" id="period-error" v-if="errors.period">{{
                                        errors.period
                                    }}</p>
                                </div>

                                <div class="sm:col-span-4">
                                    <div class="relative mt-2 rounded-md shadow-sm">
                                        <label for="from"
                                            class="block text-sm font-medium leading-6 text-gray-900">Van</label>
                                        <select id="from" name="from" v-model="selectFromValue"
                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 ring-1 ring-inset focus:ring-2 sm:text-sm sm:leading-6"
                                            :class="`${errors.name ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 text-gray-900'}`">
                                            <option v-for="option in piggyBanks" v-bind:value="option.id" :key="option.id"
                                                required>
                                                {{ option.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <p class="mt-2 text-sm text-red-600" id="from-error" v-if="errors.from">{{
                                        errors.from
                                    }}</p>
                                </div>

                                <div class="sm:col-span-4">
                                    <div class="relative mt-2 rounded-md shadow-sm">
                                        <label for="to"
                                            class="block text-sm font-medium leading-6 text-gray-900">Naar</label>
                                        <select id="to" name="to" v-model="selectToValue"
                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 ring-1 ring-inset focus:ring-2 sm:text-sm sm:leading-6"
                                            :class="`${errors.name ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 text-gray-900'}`">
                                            <option v-for="option in piggyBanks" v-bind:value="option.id" :key="option.id"
                                                required>
                                                {{ option.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <p class="mt-2 text-sm text-red-600" id="to-error" v-if="errors.to">{{
                                        errors.to
                                    }}</p>
                                </div>

                                <div class="col-span-full">
                                    <label for="description"
                                        class="block text-sm font-medium leading-6 text-gray-900">Beschrijving</label>
                                    <div class="mt-2">
                                        <textarea id="description" name="description" rows="3"
                                            class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"
                                            :class="`${errors.name ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 text-gray-900'}`" />
                                    </div>
                                    <p class="mt-2 text-sm text-red-600" id="description-error" v-if="errors.description">{{
                                        errors.description
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
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            </div>
        </div>
    </Modal>
</template>