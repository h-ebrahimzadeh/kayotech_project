<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "../stores/auth";

const authStore = useAuthStore();

onMounted(async () => {
  await authStore.getUser();
  // console.log(authStore.role,'hello',authStore.authToken);

});
</script>
<template>
  <div class="max-w-7xl mx-auto">
    <div v-if="authStore.user">
      <h1>name: {{ authStore.user.name }}</h1>
      <p>email: {{ authStore.user.email }}</p>
      <p>role: {{ authStore.role[0] }}</p>

    </div>
    <div v-else>
      <h1>Go and login</h1>
    </div>
  </div>
</template>