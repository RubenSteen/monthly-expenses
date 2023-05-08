<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

import { ref } from 'vue'
import { Dialog, DialogPanel } from '@headlessui/vue'
import {
    ArrowPathIcon,
    Bars3Icon,
    CloudArrowUpIcon,
    FingerPrintIcon,
    LockClosedIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'
import { CheckIcon } from '@heroicons/vue/20/solid'

const mobileMenuOpen = ref(false)
</script>

<template>
    <Head title="Welcome" />

    <div class="bg-white">
        <!-- Header -->
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                            alt="" />
                    </a>
                </div>
                <div class="flex lg:flex-1 lg:justify-end">
                    <Link :href="route('login')" class="text-sm font-semibold leading-6 text-gray-900">Inloggen <span
                        aria-hidden="true">&rarr;</span></Link>
                </div>
            </nav>
            <Dialog as="div" class="lg:hidden" @close="mobileMenuOpen = false" :open="mobileMenuOpen">
                <div class="fixed inset-0 z-50" />
                <DialogPanel
                    class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                    <div class="flex items-center justify-between">
                        <a href="#" class="-m-1.5 p-1.5">
                            <span class="sr-only">Your Company</span>
                            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                                alt="" />
                        </a>
                        <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="mobileMenuOpen = false">
                            <span class="sr-only">Close menu</span>
                            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-500/10">
                            <div class="space-y-2 py-6">
                            </div>
                            <div class="py-6">
                                <a href="#"
                                    class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Log
                                    in</a>
                            </div>
                        </div>
                    </div>
                </DialogPanel>
            </Dialog>
        </header>

        <main class="isolate">
            <!-- Hero section -->
            <div class="relative pt-14">
                <div class="py-24 sm:py-32">
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <div class="mx-auto max-w-2xl text-center">
                            <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Houd overzicht in je
                                inkomsten en uitgaven</h1>
                            <p class="mt-6 text-lg leading-8 text-gray-600">Deze tool helpt je om je spaardoelen te
                                registreren samen met je inkomsten en uitgaven.</p>
                            <div class="mt-10 flex items-center justify-center gap-x-6">
                                <Link :href="route('dashboard')"
                                    class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Begin</Link>
                            </div>
                        </div>
                        <div class="mt-16 flow-root sm:mt-24">
                            <div
                                class="-m-2 rounded-xl bg-gray-900/5 p-2 ring-1 ring-inset ring-gray-900/10 lg:-m-4 lg:rounded-2xl lg:p-4">
                                <!-- <img src="https://tailwindui.com/img/component-images/project-app-screenshot.png"
                                    alt="App screenshot" width="2432" height="1442"
                                    class="rounded-md shadow-2xl ring-1 ring-gray-900/10" /> -->
                                <img src="/storage/project-app-screenshot.png" alt="App screenshot" width="2432"
                                    height="1442" class="rounded-md shadow-2xl ring-1 ring-gray-900/10" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
