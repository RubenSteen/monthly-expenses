<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ListPiggyBank from '@/Components/ListPiggyBank.vue';
import CreatePiggyBankModal from '@/Components/CreatePiggyBankModal.vue';

const showModal = ref(false);

const toggleModal = () => {
    showModal.value = !showModal.value;
};

const newPiggyBank = () => {
    toggleModal();
};

const editPiggyBank = (id) => {
    console.log(id)
};

const clients = [
    {
        id: 1,
        name: 'Mij (Eigen rekening)',
        amount: '€1811,14',
        transactions_count: 3,
    },
    {
        id: 2,
        name: 'Gezamelijke rekening',
        amount: '€25,57',
        transactions_count: 2,
    },
    {
        id: 3,
        name: 'Boodschappen',
        amount: '€200,00',
        transactions_count: 3,
    },
    {
        id: 4,
        name: 'Kleding',
        amount: '€75,00',
        transactions_count: 3,
    },
    {
        id: 5,
        name: 'Auto',
        amount: '€100,00',
        transactions_count: 1,
    },
    {
        id: 6,
        name: 'Koophuis',
        amount: '€150,00',
        transactions_count: 3,
    },
    {
        id: 7,
        name: 'Bezine',
        amount: '€50,00',
        transactions_count: 6,
    },
]
</script>

<template>
    <AppLayout title="Potjes">
        <CreatePiggyBankModal :show="showModal" @close="toggleModal()">
            <template #title>
                Potjes registreren
            </template>
        </CreatePiggyBankModal>

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow mt-4">
                <div class="px-4 py-5 sm:p-6">

                    <ListPiggyBank :clients="clients" @pressedButton="newPiggyBank" @pressedEdit="editPiggyBank">
                        <template #title>
                            Potjes
                        </template>

                        <template #content>
                            Maak hier je potjes aan, dit kunnen natuurlijk ook andere rekeningen zijn.
                        </template>
                    </ListPiggyBank>

                </div>
            </div>
        </div>
    </AppLayout>
</template>