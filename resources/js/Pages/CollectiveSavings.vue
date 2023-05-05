<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Transactions from '@/Components/Transactions.vue';
import CreateTransactionModal from '@/Components/CreateTransactionModal.vue';

const showModal = ref(false);

const toggleModal = () => {
    showModal.value = !showModal.value;
};

const newTransaction = () => {
    toggleModal();
};

const editTransaction = (id) => {
    console.log(id)
};

const transactions = [
    {
        id: 1,
        name: 'Auto',
        amount: '€100.00',
        period: 'Maandelijks',
        from: 'Mij',
        to: 'Auto',
    },
    {
        id: 2,
        name: 'Koophuis',
        amount: '€150.00',
        period: 'Maandelijks',
        from: 'Mij',
        to: 'Koophuis',
    },
    {
        id: 2,
        name: 'Bezine',
        amount: '€50.00',
        period: 'Maandelijks',
        from: 'Mij',
        to: 'Boot',
    },
]
</script>

<template>
    <AppLayout title="Gezamelijk sparen">

        <CreateTransactionModal :show="showModal" @close="toggleModal()">
            <template #title>
                Gezamelijk spaardoelen registreren
            </template>
        </CreateTransactionModal>

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow mt-4">
                <div class="px-4 py-5 sm:p-6">

                    <Transactions :data="transactions" @pressedButton="newTransaction" @pressedEdit="editTransaction">
                        <template #title>
                            Gezamelijk sparen
                        </template>

                        <template #content>
                            Registreer hier je gezamelijk spaardoelen
                        </template>
                    </Transactions>

                </div>
            </div>
        </div>
    </AppLayout>
</template>