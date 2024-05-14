<script setup>
import { ref } from "vue"

const email = ref('')
const password = ref('')

const login = async () => {

    await axios.get("/sanctum/csrf-cookie")

    .then( async () => {
        await axios.post('/api/login', {
        email : email.value,
        password : password.value
        })
        .then( res => console.log(res))
        .catch (error => console.log(error))

    })
    .catch (error => console.log(error))

}
</script>

<template>
    <h1>Connexion</h1>
    <form @submit.prevent="login">
        <input v-model="email" />
        <input v-model="password" />
        <button type="submit">valider</button>
    </form>
</template>
