<template>
    <div class="container mt-5">
        <p class="fs-4 text-center">{{ comments.length }} commentaire<span v-if="comments.length > 1">s</span> pour ce message</p>
        <div v-for="comment in comments" :key="comment.id">
            <Comment :comment="comment" :postAuthorID="postAuthorID"/>
        </div>
    </div>
</template>

<script setup>
import Comment from './Comment.vue'
defineProps(['comments', 'postAuthorID'])
</script>