<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Transactions from '@/Components/Transactions.vue';

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
