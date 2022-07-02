<template>
  <component :is="layout + '-layout'" v-if="layout"/>
</template>

<script>
import AuthLayout from "@/layouts/AuthLayout";
import MainLayout from "@/layouts/MainLayout";

export default {
  components: {
    MainLayout, AuthLayout
  }
}
</script>

<script setup>

import {computed} from "vue";
import {useRoute} from "vue-router";

const route = useRoute();
const layout = computed(() => route.meta.layout);

</script>
