<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { EllipsisHorizontalIcon } from '@heroicons/vue/20/solid'
import { ClipboardDocumentIcon } from '@heroicons/vue/24/outline'
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    clients: {
        type: Array,
        default: false,
    },
});

const emit = defineEmits(['pressedButton', 'pressedEdit']);

const pressedButton = () => {
    emit('pressedButton');
};

const pressedEdit = (id) => {
    emit('pressedEdit', id);
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

        <button v-if="clients.length < 1" type="button"
            class="mt-8 relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <component :is="ClipboardDocumentIcon" class="mx-auto h-12 w-12 text-gray-400" aria-hidden="true" />
            <span class="mt-2 block text-sm font-semibold text-gray-900">Geen potjes gevonden</span>
        </button>

        <ul v-else role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
            <li v-for="client in clients" :key="client.id" class="overflow-hidden rounded-xl border border-gray-200">
                <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                    <div class="text-sm font-medium leading-6 text-gray-900">{{ client.name }}</div>
                    <Menu as="div" class="relative ml-auto">
                        <MenuButton class="-m-2.5 block p-2.5 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Open options</span>
                            <EllipsisHorizontalIcon class="h-5 w-5" aria-hidden="true" />
                        </MenuButton>
                        <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="absolute right-0 z-10 mt-0.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                                <MenuItem v-slot="{ active }">
                                <a href="#"
                                    :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']">View<span
                                        class="sr-only">, {{ client.name }}</span></a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                <a @click="pressedEdit(client.id)"
                                    :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']">Edit<span
                                        class="sr-only">, {{ client.name }}</span></a>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
                <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                    <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">Bedrag</dt>
                        <dd class="flex items-start gap-x-2">
                            <div class="font-medium text-gray-900">{{ client.amount }}</div>
                        </dd>
                    </div>
                    <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500">Transacties</dt>
                        <dd class="flex items-start gap-x-2">
                            <div class="font-medium text-gray-900">{{ client.transactions_count }}</div>
                        </dd>
                    </div>
                </dl>
            </li>
        </ul>
    </div>
</template>
