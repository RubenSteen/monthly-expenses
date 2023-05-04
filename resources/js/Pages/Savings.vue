<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Transactions from '@/Components/Transactions.vue';

const transactions = [
    {
        id: 1,
        name: 'Kleding',
        amount: '€75.00',
        period: 'Maandelijks',
        from: 'Mij',
        to: 'Kleding',
    },
]
</script>

<template>
    <AppLayout title="Sparen">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow mt-4">
                <div class="px-4 py-5 sm:p-6">

                    <Transactions :data="transactions" />

                </div>
            </div>
        </div>
    </AppLayout>
</template>