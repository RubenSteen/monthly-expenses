<script setup>
import { Link } from '@inertiajs/vue3';
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue';
import {
    XMarkIcon,
    HomeIcon,
    RectangleStackIcon,
    CurrencyEuroIcon,
    ArrowLeftOnRectangleIcon,
} from '@heroicons/vue/24/outline';

const emit = defineEmits(['closeSidebar']);

const props = defineProps({
    sidebarOpen: {
        type: Boolean,
    },
});

const navigation = [
    { name: 'Overzicht', href: route('dashboard'), icon: HomeIcon, current: route().current('dashboard') },
    { name: 'Potjes', href: route('piggy-bank.index'), icon: RectangleStackIcon, current: route().current('piggy-bank.index') },
];

const secondNavigation = [
    { name: 'Inkomen', href: route('income.index'), icon: CurrencyEuroIcon, current: route().current('income.index') },
];

const categoryNavigation = [
    { name: 'Website redesign', href: '#', initial: 'W', current: false },
    { name: 'GraphQL API', href: '#', initial: 'G', current: false },
    { name: 'Customer migration guides', href: '#', initial: 'C', current: false },
    { name: 'Profit sharing program', href: '#', initial: 'P', current: false },
];

const closeSidebar = () => {
    emit('closeSidebar');
};

</script>

<template>
    <TransitionRoot as="template" :show="sidebarOpen">
        <Dialog as="div" class="relative z-50 lg:hidden" @close="closeSidebar">
            <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
                enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-900/80" />
            </TransitionChild>

            <div class="fixed inset-0 flex">
                <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                    enter-from="-translate-x-full" enter-to="translate-x-0"
                    leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                    leave-to="-translate-x-full">
                    <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                        <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                            enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100"
                            leave-to="opacity-0">
                            <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                <button type="button" class="-m-2.5 p-2.5" @click="closeSidebar">
                                    <span class="sr-only">Close sidebar</span>
                                    <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                </button>
                            </div>
                        </TransitionChild>
                        <!-- Sidebar component, swap this element with another sidebar if you like -->
                        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
                            <div class="flex h-16 shrink-0 items-center">
                                <img class="h-8 w-auto"
                                    src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                                    alt="Your Company" />
                            </div>
                            <nav class="flex flex-1 flex-col">
                                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                    <li>
                                        <ul role="list" class="-mx-2 space-y-1">
                                            <li v-for="item in navigation" :key="item.name">
                                                <Link :href="item.href"
                                                    :class="[item.current ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                <component :is="item.icon"
                                                    :class="[item.current ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600', 'h-6 w-6 shrink-0']"
                                                    aria-hidden="true" />
                                                {{ item.name }}
                                                </Link>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul role="list" class="-mx-2 space-y-1">
                                            <li v-for="item in secondNavigation" :key="item.name">
                                                <Link :href="item.href"
                                                    :class="[item.current ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                <component :is="item.icon"
                                                    :class="[item.current ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600', 'h-6 w-6 shrink-0']"
                                                    aria-hidden="true" />
                                                {{ item.name }}
                                                </Link>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <div class="text-xs font-semibold leading-6 text-gray-400">Categorieën</div>
                                        <ul role="list" class="-mx-2 mt-2 space-y-1">
                                            <li v-for="item in categoryNavigation" :key="item.name">
                                                <a :href="item.href"
                                                    :class="[item.current ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-100', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                    <span
                                                        :class="[item.current ? 'text-indigo-600 border-indigo-600' : 'text-gray-400 border-gray-200 group-hover:border-indigo-600 group-hover:text-indigo-600', 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border text-[0.625rem] font-medium bg-white']">{{
                                                            item.initial }}</span>
                                                    <span class="truncate">{{ item.name }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="mt-auto">
                                        <Link :href="route('logout')" method="post" as="button" type="button"
                                            class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-indigo-600 w-full">
                                        <ArrowLeftOnRectangleIcon
                                            class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-indigo-600"
                                            aria-hidden="true" />
                                        Uitloggen
                                        </Link>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>