<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Transactions from '@/Components/Transactions.vue';

const transactions = [
    {
        id: 1,
        name: 'Salaris Werk',
        amount: '€2215,14',
        period: 'Maandelijks',
        from: 'Extern',
        to: 'Mij',
    },
    {
        id: 2,
        name: 'Huurtoeslag',
        amount: '€196,57',
        period: 'Maandelijks',
        from: 'Extern',
        to: 'Mij',
    },
]
</script>

<template>
    <AppLayout title="Inkomen">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow mt-4">
                <div class="px-4 py-5 sm:p-6">

                    <Transactions :data="transactions" />

                </div>
            </div>
        </div>
    </AppLayout>
</template>