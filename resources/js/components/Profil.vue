<template>
  <div v-if="user">
    <div class="text-center mt-5">
      <h1 class="my-3">Profil de {{ user.pseudo }}</h1>
      <div v-if="user.image" class="mb-2">
        <img :src="`/images/${user.image}`" />
      </div>
      <p>
        <i class="fa-solid fa-right-to-bracket fa-2x me-2"></i> inscrit le
        {{ user.created_at.slice(0, 10).split("-").reverse().join("/") }}
      </p>
      <p>
        <i class="fa-solid fa-message fa-2x me-2"></i>
        {{ user.posts.length }} message(s) posté(s)
      </p>
    </div>

    <div class="container mt-5">
      <div v-for="post in user.posts" :key="post.id">
        <Post :post="post" />
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onBeforeMount } from "vue";
import { useRoute } from "vue-router";
import Post from "./Post.vue";

const user = ref(null);
const route = useRoute();

onBeforeMount(() => {
  axios
    .get("/api/users/" + route.params.id)
    .then((response) => (user.value = response.data.user))
    .catch((error) => console.log(error.response));
});
</script>

<style lang="scss">
@import "../../sass/style.scss";

i {
  color: $mainColor;
}
</style>