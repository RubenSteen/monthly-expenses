<script setup>
import Modal from './Modal.vue';
import { ref, toRefs, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { ClipboardDocumentListIcon } from '@heroicons/vue/24/outline'

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
    piggyBanks: {
        type: Object,
        default: {},
    },
    routePrefix: {
        type: String,
    },
});

const watchProps = toRefs(props);

watch(watchProps.show, () => {
    form.defaults({
        name: props.edit.name ? props.edit.name : '',
        amount: props.edit.amount ? props.edit.amount.valueSeperatedCents : '',
        from_id: props.edit.from ? props.edit.from.id : 1,
        to_id: props.edit.to ? props.edit.to.id : 1,
    }).reset()
})

const editState = () => {
    if (Object.keys(props.edit).length === 0) {
        return false;
    }
    return true;
};

const form = useForm({
    name: '',
    amount: '',
    from_id: null,
    to_id: null,
});

const submit = () => {
    if (editState()) {
        form.put(route(props.routePrefix + '.update', props.edit), {
            preserveScroll: true,
            onSuccess: () => close(),
        });
    } else {
        form.post(route(props.routePrefix + '.store'), {
            preserveScroll: true,
            onSuccess: () => close(),
        });
    }
};

const close = () => {
    emit('close');
};

const deletePiggyBank = () => {
    form.delete(route(props.routePrefix + '.delete', props.edit), {
        preserveScroll: true,
        onSuccess: () => close(),
    });
};
</script>

<template>
    <Modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
        <form @submit.prevent="submit">
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
                        <button type="button" v-if="editState()" @click="deletePiggyBank"
                            class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Delete</button>
                    </div>
                </div>

                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <div class="mt-4 text-sm text-gray-600">
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
                                        form.errors.name
                                    }}</p>
                                </div>

                                <div class="sm:col-span-4">
                                    <label for="amount"
                                        class="block text-sm font-medium leading-6 text-gray-900">Kosten</label>
                                    <div class="relative mt-2 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">€</span>
                                        </div>
                                        <input type="text" name="amount" id="amount" v-model="form.amount"
                                            class="block w-full rounded-md border-0 py-1.5 pl-7 pr-12 ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"
                                            :class="`${form.errors.name ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 text-gray-900'}`"
                                            placeholder="0,00" aria-describedby="amount-currency" />
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-500 sm:text-sm" id="amount-currency">EUR</span>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-red-600" id="amount-error" v-if="form.errors.amount">{{
                                        form.errors.amount
                                    }}</p>
                                </div>

                                <!-- <div class="sm:col-span-4">
                                    <div class="relative mt-2 rounded-md shadow-sm">
                                        <label for="period"
                                            class="block text-sm font-medium leading-6 text-gray-900">Herhaling</label>
                                        <select id="period" name="period" v-model="selectPeriodValue"
                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 ring-1 ring-inset focus:ring-2 sm:text-sm sm:leading-6"
                                            :class="`${form.errors.name ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 text-gray-900'}`">
                                            <option v-for="option in periods" v-bind:value="option.id" :key="option.id"
                                                required>
                                                {{ option.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <p class="mt-2 text-sm text-red-600" id="period-error" v-if="form.errors.period">{{
                                        form.errors.period
                                    }}</p>
                                </div> -->

                                <div class="sm:col-span-4">
                                    <div class="relative mt-2 rounded-md shadow-sm">
                                        <label for="from"
                                            class="block text-sm font-medium leading-6 text-gray-900">Van</label>
                                        <select id="from" name="from" v-model="form.from_id"
                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 ring-1 ring-inset focus:ring-2 sm:text-sm sm:leading-6"
                                            :class="`${form.errors.from_id ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 text-gray-900'}`">
                                            <option v-for="option in piggyBanks" v-bind:value="option.id" :key="option.id"
                                                required>
                                                {{ option.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <p class="mt-2 text-sm text-red-600" id="from-error" v-if="form.errors.from_id">{{
                                        form.errors.from_id
                                    }}</p>
                                </div>

                                <div class="sm:col-span-4">
                                    <div class="relative mt-2 rounded-md shadow-sm">
                                        <label for="to"
                                            class="block text-sm font-medium leading-6 text-gray-900">Naar</label>
                                        <select id="to" name="to" v-model="form.to_id"
                                            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 ring-1 ring-inset focus:ring-2 sm:text-sm sm:leading-6"
                                            :class="`${form.errors.to_id ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 text-gray-900'}`">
                                            <option v-for="option in piggyBanks" v-bind:value="option.id" :key="option.id"
                                                required>
                                                {{ option.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <p class="mt-2 text-sm text-red-600" id="to-error" v-if="form.errors.to_id">{{
                                        form.errors.to_id
                                    }}</p>
                                </div>

                                <!-- <div class="col-span-full">
                                    <label for="description"
                                        class="block text-sm font-medium leading-6 text-gray-900">Beschrijving</label>
                                    <div class="mt-2">
                                        <textarea id="description" name="description" rows="3"
                                            class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"
                                            :class="`${form.errors.description ? 'text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600 text-gray-900'}`" />
                                    </div>
                                    <p class="mt-2 text-sm text-red-600" id="description-error"
                                        v-if="form.errors.description">{{
                                            form.errors.description
                                        }}</p>
                                </div> -->

                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-row justify-end px-6 bg-gray-100 text-right">
                <div class="my-2 flex items-center justify-end gap-x-6">
                    <button @click="close" type="button"
                        class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                    <button type="submit"
                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
            </div>
        </form>
    </Modal>
</template>