<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import {
  WalletIcon,
  HomeModernIcon,
  BanknotesIcon,
  CreditCardIcon,
  CurrencyEuroIcon,
  RectangleStackIcon,
} from '@heroicons/vue/24/outline'

const stats = [
  { id: 1, name: 'Overgehouden budget', stat: '€415,85',},
  { id: 2, name: 'Dagen te gaan', stat: '14',},
]

const monthStats = [
  {
    name: 'Uitgaven',
    amount: '€249.27',
    icon: BanknotesIcon,
  },
  {
    name: 'Gezamelijke Uitgaven',
    amount: '€1,334.37',
    icon: CreditCardIcon,
  },
  {
    name: 'Sparen',
    amount: '€130.00',
    icon: WalletIcon,
  },
  {
    name: 'Gezamelijk Sparen',
    amount: '€375.00',
    icon: HomeModernIcon,
  },
]

const transactions = [
  {
    id: 1,
    name: 'Boodschappen',
    amount: '€200.00',
    period: 'Maandelijks',
    from: 'Mij',
    to: 'Boodchappen',
  },
  {
    id: 2,
    name: 'Internet en Televisie',
    amount: '€25,57',
    period: 'Maandelijks',
    from: 'Mij',
    to: 'Gezamelijke rekening',
  },
]
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="px-4 sm:px-6 lg:px-8">

            <div class="overflow-hidden bg-white shadow">
            <div class="px-4 py-5 sm:p-6">
                
                <div>
                <h3 class="text-base font-semibold leading-6 text-gray-900">Maart 2023</h3>

                <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <div v-for="item in stats" :key="item.id" class="relative overflow-hidden rounded bg-indigo-50 bg-opacity-75 px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                    <dt>
                        <p class="truncate text-sm font-medium text-gray-500">{{ item.name }}</p>
                    </dt>
                    <dd class="flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-900">{{ item.stat }}</p>
                        <div class="absolute inset-x-0 bottom-0 px-4 py-3 sm:px-6">
                        <div class="text-sm">
                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500"
                            >View all<span class="sr-only"> {{ item.name }} stats</span></a
                            >
                        </div>
                        </div>
                    </dd>
                    </div>
                </dl>
                </div>

            </div>
            </div>

            <div class="overflow-hidden bg-white shadow mt-4">
            <div class="px-4 py-5 sm:p-6">

                <div class="grid grid-cols-1 gap-4 pb-4 lg:w-2/4 mx-auto">
                <div class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                    <div class="flex-shrink-0">
                    <component :is="CurrencyEuroIcon" class="h-10 w-10 shrink-0" aria-hidden="true" />
                    </div>
                    <div class="min-w-0 flex-1">
                    <a href="#" class="focus:outline-none">
                        <span class="absolute inset-0" aria-hidden="true" />
                        <p class="text-sm font-medium text-gray-900">Inkomen</p>
                        <p class="truncate text-sm text-gray-500">€3857,45</p>
                    </a>
                    </div>
                </div>
                </div>
                
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div v-for="stat in monthStats" :key="stat.name" class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                    <div class="flex-shrink-0">
                    <component :is="stat.icon" class="h-10 w-10 shrink-0" aria-hidden="true" />
                    </div>
                    <div class="min-w-0 flex-1">
                    <a href="#" class="focus:outline-none">
                        <span class="absolute inset-0" aria-hidden="true" />
                        <p class="text-sm font-medium text-gray-900">{{ stat.name }}</p>
                        <p class="truncate text-sm text-gray-500">{{ stat.amount }}</p>
                    </a>
                    </div>
                </div>
                </div>

            </div>
            </div>

            <div class="overflow-hidden bg-white shadow mt-4">
            <div class="px-4 py-5 sm:p-6">

                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Transactions</h1>
                    <p class="mt-2 text-sm text-gray-700">A table of placeholder stock market data that does not make any sense.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Export</button>
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Naam</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Kosten gemiddeld</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Herhaling</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Van</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Naar</th>
                            <th scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Edit</span>
                            </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="transaction in transactions" :key="transaction.id">
                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">{{ transaction.name }}</td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">{{ transaction.amount }}</td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">{{ transaction.period }}</td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{ transaction.from }}</td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{ transaction.to }}</td>
                            <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900"
                                >Edit<span class="sr-only">, {{ transaction.id }}</span></a
                                >
                            </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>

            </div>
            </div>



            </div>
    </AppLayout>
</template>
