<script setup>
import { ref, computed } from 'vue'
import { Head, Link } from '@inertiajs/vue3';
import Notification from '@/Components/Notification.vue';
import TopNavigation from '@/Components/Navigation/TopNavigation.vue';
import MobileNavigation from '@/Components/Navigation/MobileNavigation.vue';
import SideNavigation from '@/Components/Navigation/SideNavigation.vue';
import {
  Dialog,
  DialogPanel,
  Menu,
  MenuItem,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  XMarkIcon,
  Cog6ToothIcon,
  HomeIcon,
  RectangleStackIcon,
  CurrencyEuroIcon,
  ArrowLeftOnRectangleIcon,
} from '@heroicons/vue/24/outline'

defineProps({
  title: String,
});

const navigation = [
  { name: 'Overzicht', href: route('dashboard'), icon: HomeIcon, current: route().current('dashboard') },
  { name: 'Potjes', href: route('piggy-bank.index'), icon: RectangleStackIcon, current: route().current('piggy-bank.index') },
]

const secondNavigation = [
  { name: 'Inkomen', href: route('income.index'), icon: CurrencyEuroIcon, current: route().current('income.index') },
]

const categoryNavigation = [
  { name: 'Website redesign', href: '#', initial: 'W', current: false },
  { name: 'GraphQL API', href: '#', initial: 'G', current: false },
  { name: 'Customer migration guides', href: '#', initial: 'C', current: false },
  { name: 'Profit sharing program', href: '#', initial: 'P', current: false },
]

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