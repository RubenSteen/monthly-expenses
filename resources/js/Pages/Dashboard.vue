<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

import {
  WalletIcon,
  HomeModernIcon,
  BanknotesIcon,
  CreditCardIcon,
  CurrencyEuroIcon,
  RectangleStackIcon,
  ClipboardDocumentIcon,
} from '@heroicons/vue/24/outline'

const props = defineProps({
  dashboardCards: Object,
  totalStats: Object,
});

const stats = [
  { id: 1, name: 'Overgehouden budget', stat: '€415,85', },
  { id: 2, name: 'Dagen te gaan', stat: '14', },
]

const incomeStats = {
  name: 'Inkomen',
  amount: props.totalStats.income,
  icon: CurrencyEuroIcon,
  link: route('income.index'),
}


const monthStats = [
  // {
  //   name: 'Uitgaven',
  //   amount: props.totalStats.expense,
  //   icon: BanknotesIcon,
  //   link: route('expense.index'),
  // },
  // {
  //   name: 'Gezamelijke Uitgaven',
  //   amount: props.totalStats.collectiveExpense,
  //   icon: CreditCardIcon,
  //   link: route('collective-expense.index'),
  // },
  // {
  //   name: 'Sparen',
  //   amount: props.totalStats.saving,
  //   icon: WalletIcon,
  //   link: route('saving.index'),
  // },
  // {
  //   name: 'Gezamelijk Sparen',
  //   amount: props.totalStats.collectiveSaving,
  //   icon: HomeModernIcon,
  //   link: route('collective-saving.index'),
  // },
]
</script>

<template>
  <AppLayout title="Dashboard">
    <div class="px-4 sm:px-6 lg:px-8">

      <div class="overflow-hidden bg-white shadow">
        <div class="px-4 py-5 sm:p-6">

          <div>
            <h3 class="text-base font-semibold leading-6 text-gray-900">Welkom, {{ $page.props.auth.user.name }}</h3>

            <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
              <div v-for="(card, index) in dashboardCards" :key="index"
                class="relative overflow-hidden rounded bg-indigo-50 bg-opacity-75 px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                <dt>
                  <p class="truncate text-sm font-medium text-gray-500">{{ card.name }}</p>
                </dt>
                <dd class="flex items-baseline">
                  <p class="text-2xl font-semibold text-gray-900">{{ card.stat }}</p>
                  <div class="absolute inset-x-0 bottom-0 px-4 py-3 sm:px-6">
                    <!-- <div class="text-sm">
                      <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">View all<span class="sr-only">
                          {{ card.name }} stats</span></a>
                    </div> -->
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
            <div
              class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
              <div class="flex-shrink-0">
                <component :is="incomeStats.icon" class="h-10 w-10 shrink-0" aria-hidden="true" />
              </div>
              <div class="min-w-0 flex-1">
                <Link :href="incomeStats.link" class="focus:outline-none">
                <span class="absolute inset-0" aria-hidden="true" />
                <p class="text-sm font-medium text-gray-900">{{ incomeStats.name }}</p>
                <p class="truncate text-sm text-gray-500">{{ incomeStats.amount }}</p>
                </Link>
              </div>
            </div>
          </div>

          <Link v-if="$page.props.auth.user.categories.length < 1" type="button" :href="route('category.create')"
            class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          <component :is="ClipboardDocumentIcon" class="mx-auto h-12 w-12 text-gray-400" aria-hidden="true" />
          <span class="mt-2 block text-sm font-semibold text-gray-900">Geen categorieën gevonden</span>
          </Link>

          <div v-if="$page.props.auth.user.categories.length > 0" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div v-for="category in $page.props.auth.user.categories" :key="category.name"
              class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
              <!-- <div class="flex-shrink-0">
                <component :is="category.icon" class="h-10 w-10 shrink-0" aria-hidden="true" />
              </div> -->
              <div class="min-w-0 flex-1">
                <Link :href="category.href" class="focus:outline-none">
                <span class="absolute inset-0" aria-hidden="true" />
                <p class="text-sm font-medium text-gray-900">{{ category.name }}</p>
                <p class="truncate text-sm text-gray-500">{{ category.amount.valueDisplay }}</p>
                </Link>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </AppLayout>
</template>
