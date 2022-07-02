<template>
  <div class="wrapper">
    <the-navbar/>
    <main>
      <router-view/>
    </main>
    <footer>
      <b>Администрация</b> Нижнего Новгорода
    </footer>
  </div>
</template>

<script setup>
import TheNavbar from "@/components/TheNavbar";
</script>

