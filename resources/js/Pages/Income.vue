<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Transactions from '@/Components/Transactions.vue';
import CreateTransactionModal from '@/Components/CreateTransactionModal.vue';

const props = defineProps({
    transactions: Array,
    piggyBanks: Array,
    routePrefix: {
        type: String,
        default: "income",
    },
});

const showModal = ref(false);

const selectedIncome = ref({});

const closeModal = () => {
    showModal.value = false;
    selectedIncome.value = {};
};

const openModal = () => {
    showModal.value = true;
};

const newTransaction = () => {
    openModal();
};

const editTransaction = (index) => {
    selectedIncome.value = props.transactions[index];
    openModal();
};
</script>

<template>
    <AppLayout title="Inkomen">

        <CreateTransactionModal :show="showModal" @close="closeModal" :piggyBanks="piggyBanks" :edit="selectedIncome"
            :routePrefix="routePrefix">
            <template #title>
                Inkomen registreren
            </template>
        </CreateTransactionModal>

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