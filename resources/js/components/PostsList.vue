<template>
    <div class="container mt-5">
        <div v-for="post in postStore.posts" :key="post.id">
            <Post :post="post" />
        </div>
    </div>
</template>

<script setup>
import Post from './Post.vue'
import { usePostStore } from '../stores/postStore'
import { onBeforeMount } from 'vue';

const postStore = usePostStore()

onBeforeMount(async () => {
    await axios.get("/api/posts")
        .then(response => {
        console.log(response)
        postStore.storePosts(response.data.posts)})
        .catch(error => console.log(error))
})
</script>