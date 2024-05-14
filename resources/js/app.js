import './bootstrap';

import { createApp } from 'vue'
import Counter from './components/Counter.vue'
import Login from './components/Login.vue'

const app = createApp()

app.component('counter', Counter)
app.component('login', Login)

app.mount('#app')