<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PiggyBank from '@/Components/PiggyBank.vue';

const clients = [
    {
        id: 1,
        name: 'Mij (Eigen rekening)',
        amount: '€1811,14',
    },
    {
        id: 2,
        name: 'Gezamelijke rekening',
        amount: '€25,57',
    },
    {
        id: 3,
        name: 'Boodschappen',
        amount: '€200,00',
    },
    {
        id: 4,
        name: 'Kleding',
        amount: '€75,00',
    },
    {
        id: 5,
        name: 'Auto',
        amount: '€100,00',
    },
    {
        id: 6,
        name: 'Koophuis',
        amount: '€150,00',
    },
    {
        id: 7,
        name: 'Bezine',
        amount: '€50,00',
    },
]
</script>

<template>
    <AppLayout title="Potjes">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow mt-4">
                <div class="px-4 py-5 sm:p-6">

                    <PiggyBank :clients="clients" />

                </div>
            </div>
        </div>
    </AppLayout>
</template>