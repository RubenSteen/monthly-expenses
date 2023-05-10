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
        default: "collective-expense",
    },
});

const showModal = ref(false);

const selectedEdit = ref({});

const closeModal = () => {
    showModal.value = false;
    selectedEdit.value = {};
};

const openModal = () => {
    showModal.value = true;
};

const newTransaction = () => {
    openModal();
};

const editTransaction = (index) => {
    selectedEdit.value = props.transactions[index];
    openModal();
};
</script>

<template>
    <AppLayout title="Inkomen">

        <CreateTransactionModal :show="showModal" @close="closeModal" :piggyBanks="piggyBanks" :edit="selectedEdit"
            :routePrefix="routePrefix">
            <template #title>
                Gezamelijke uitgaven registreren
            </template>
        </CreateTransactionModal>

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow mt-4">
                <div class="px-4 py-5 sm:p-6">

                    <Transactions :data="transactions" @pressedButton="newTransaction" @pressedEdit="editTransaction">
                        <template #title>
                            Gezamelijke uitgaven
                        </template>

                        <template #content>
                            Registreer hier je gezamelijke uitgaven
                        </template>
                    </Transactions>

                </div>
            </div>
        </div>
    </AppLayout>
</template>