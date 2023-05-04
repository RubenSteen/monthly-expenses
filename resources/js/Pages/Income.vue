<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Transactions from '@/Components/Transactions.vue';
import Modal from '@/Components/Modal.vue';

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
];
</script>

<template>
    <AppLayout title="Inkomen">

        <Modal :show="showModal" @close="toggleModal()">
            Hello
        </Modal>

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow mt-4">
                <div class="px-4 py-5 sm:p-6">

                    <Transactions :data="transactions" @pressedButton="newTransaction" @pressedEdit="editTransaction">
                        <template #title>
                            Inkomen
                        </template>

                        <template #content>
                            Registreer hier je inkomen
                        </template>
                    </Transactions>

                </div>
            </div>
        </div>
    </AppLayout>
</template>