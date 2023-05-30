<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    users: Object,
});
</script>

<template>
    <AppLayout :title="`Admin - Users`">

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow mt-4">
                <div class="px-4 py-5 sm:p-6">

                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>
                                <p class="mt-2 text-sm text-gray-700">A list of all the users in your account including
                                    their name, title, email and role.</p>
                            </div>
                            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                                <button type="button"
                                    class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add
                                    user</button>
                            </div>
                        </div>
                        <div class="mt-8 flow-root">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead>
                                            <tr>
                                                <th scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                                    Name</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Last
                                                    Activity
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role
                                                </th>
                                                <!-- <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                    <span class="sr-only">Edit</span>
                                                </th> -->
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            <tr v-for="user in users" :key="user.id">
                                                <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                                    <div class="flex items-center">
                                                        <div class="h-11 w-11 flex-shrink-0">
                                                            <img class="h-11 w-11 rounded-full"
                                                                :src="user.profile_photo_url" alt="" />
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="font-medium text-gray-900">{{ user.name }}</div>
                                                            <div class="mt-1 text-gray-500">{{ user.email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                    <div class="text-gray-900">{{ user.last_activity }}</div>
                                                    <!-- <div class="mt-1 text-gray-500">Test</div> -->
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                    <span v-if="user.email_verified_at !== null"
                                                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Verified</span>
                                                    <span v-else
                                                        class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Unverified</span>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                    <span
                                                        class="inline-flex items-center rounded-md bg-gray-100 px-1.5 py-0.5 text-xs font-medium text-gray-600">Member</span>
                                                    <span v-if="user.admin"
                                                        class="inline-flex items-center rounded-md bg-green-100 px-1.5 py-0.5 text-xs font-medium text-green-700">Admin</span>
                                                    <span v-if="user.super_admin"
                                                        class="inline-flex items-center rounded-md bg-purple-100 px-1.5 py-0.5 text-xs font-medium text-purple-700">Super
                                                        Admin</span>
                                                </td>
                                                <!-- <td
                                                    class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span
                                                            class="sr-only">, {{ user.name }}</span></a>
                                                </td> -->
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