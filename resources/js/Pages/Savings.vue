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

        <CreateTransactionModal :show="showModal" @close="toggleModal()">
            <template #title>
                Spaardoelen registreren
            </template>
        </CreateTransactionModal>

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow mt-4">
                <div class="px-4 py-5 sm:p-6">

                    <Transactions :data="transactions" @pressedButton="newTransaction" @pressedEdit="editTransaction">
                        <template #title>
                            Sparen
                        </template>

                        <template #content>
                            Registreer hier je spaardoelen
                        </template>
                    </Transactions>

                </div>
            </div>
        </div>
    </AppLayout>
</template>