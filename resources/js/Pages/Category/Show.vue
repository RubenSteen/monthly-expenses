<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateAndUpdateModal from '@/Pages/Category/Partials/CreateAndUpdateModal.vue';
import List from '@/Pages/Category/Partials/List.vue';

const props = defineProps({
    category: Object,
    piggyBanks: Object,
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
    selectedEdit.value = props.category.transaction[index];
    openModal();
};
</script>

<template>
    <AppLayout :title="`Categorie: ${category.name}`">
        <CreateAndUpdateModal :show="showModal" @close="closeModal" :category="category" :piggyBanks="piggyBanks"
            :edit="selectedEdit">
        </CreateAndUpdateModal>

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow mt-4">
                <div class="px-4 py-5 sm:p-6">

                    <List :data="category.transaction" @pressedButton="newTransaction" @pressedEdit="editTransaction">
                        <template #title>
                            Categorie: {{ category.name }}
                        </template>
                    </List>

                </div>
            </div>
        </div>

    </AppLayout>
</template>