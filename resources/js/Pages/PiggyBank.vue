<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ListPiggyBank from '@/Components/ListPiggyBank.vue';
import CreatePiggyBankModal from '@/Components/CreatePiggyBankModal.vue';

defineProps({
    piggyBanks: Array,
});

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

                    <ListPiggyBank :piggyBanks="piggyBanks" @pressedNew="newPiggyBank" @pressedEdit="editPiggyBank">
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