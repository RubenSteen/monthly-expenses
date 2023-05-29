<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3';
import Notification from '@/Components/Notification.vue';
import TopNavigation from '@/Components/Navigation/Top.vue';
import MobileNavigation from '@/Components/Navigation/Mobile.vue';
import SideNavigation from '@/Components/Navigation/Side.vue';

defineProps({
  title: String,
});

const sidebarOpen = ref(false)

</script>

<template>
  <Head :title="title" />

  <Notification />

  <TopNavigation :sidebarOpen="sidebarOpen" @openSidebar="sidebarOpen = true" />

  <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 mt-12">
    <MobileNavigation :sidebarOpen="sidebarOpen" @closeSidebar="sidebarOpen = false" />

    <SideNavigation />

    <div class="lg:pl-72">
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>