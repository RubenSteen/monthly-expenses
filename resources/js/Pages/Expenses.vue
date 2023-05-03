<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Transactions from '@/Components/Transactions.vue';

import {
  WalletIcon,
  HomeModernIcon,
  BanknotesIcon,
  CreditCardIcon,
  CurrencyEuroIcon,
  RectangleStackIcon,
} from '@heroicons/vue/24/outline'

const stats = [
  { id: 1, name: 'Overgehouden budget', stat: '€415,85', },
  { id: 2, name: 'Dagen te gaan', stat: '14', },
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
  <AppLayout title="Uitgaven">
    <div class="px-4 sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow mt-4">
        <div class="px-4 py-5 sm:p-6">

          <Transactions :data="transactions" />

        </div>
      </div>
    </div>
  </AppLayout>
</template>
