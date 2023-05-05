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
    name: 'Zorgverzekering',
    amount: '€130.00',
    period: 'Maandelijks',
    from: 'Mij',
    to: 'Mij',
  },
  {
    id: 2,
    name: 'Creditcard',
    amount: '€3.40',
    period: 'Maandelijks',
    from: 'Mij',
    to: 'Mij',
  },
]
</script>

<template>
  <AppLayout title="Uitgaven">

    <CreateTransactionModal :show="showModal" @close="toggleModal()">
      <template #title>
        Uitgaven registreren
      </template>
    </CreateTransactionModal>

    <div class="px-4 sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow mt-4">
        <div class="px-4 py-5 sm:p-6">

          <Transactions :data="transactions" @pressedButton="newTransaction" @pressedEdit="editTransaction">
            <template #title>
              Uitgaven
            </template>

            <template #content>
              Registreer hier je uitgaven
            </template>
          </Transactions>

        </div>
      </div>
    </div>
  </AppLayout>
</template>