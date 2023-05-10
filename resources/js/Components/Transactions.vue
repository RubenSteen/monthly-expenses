<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ClipboardDocumentIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    data: {
        type: Object,
        default: false,
    },
});

const emit = defineEmits(['pressedButton', 'pressedEdit']);

const pressedButton = () => {
    emit('pressedButton');
};

const pressedEdit = (index) => {
    emit('pressedEdit', index);
};
</script>

<template>
    <div>
        <div class="sm:flex sm:items-center mb-8">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">
                    <slot name="title" />
                </h1>
                <p class="mt-2 text-sm text-gray-700">
                    <slot name="content" />
                </p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <PrimaryButton @click="pressedButton">Nieuw</PrimaryButton>
            </div>
        </div>

        <button v-if="data.length < 1" type="button" @click="pressedButton"
            class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <component :is="ClipboardDocumentIcon" class="mx-auto h-12 w-12 text-gray-400" aria-hidden="true" />
            <span class="mt-2 block text-sm font-semibold text-gray-900">Geen regels gevonden</span>
        </button>

        <div v-else class="flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                    Naam
                                </th>
                                <th scope="col"
                                    class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Kosten
                                </th>
                                <!-- <th scope="col"
                                    class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Herhaling
                                </th> -->
                                <th scope="col"
                                    class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Van
                                </th>
                                <th scope="col"
                                    class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Naar
                                </th>
                                <th scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Bewerk</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="(transaction, index) in data" :key="transaction.id">
                                <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
                                    {{ transaction.name }}
                                </td>
                                <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">
                                    {{ transaction.amount }}
                                </td>
                                <!-- <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                                    {{ transaction.period }}
                                </td> -->
                                <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                                    {{ transaction.from.name }}
                                </td>
                                <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                                    {{ transaction.to.name }}
                                </td>
                                <td
                                    class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <button @click="pressedEdit(index)"
                                        class="text-indigo-600 hover:text-indigo-900">Bewerk<span class="sr-only">, {{
                                            transaction.id }}</span></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
