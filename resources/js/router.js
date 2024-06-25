import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'App',
      component: () => import('./App.vue')
    },
    {
      path: '/inscription',
      name: 'inscription',
      component: () => import('./components/Inscription.vue')
    },
    {
      path: '/connexion',
      name: 'connexion',
      component: () => import('./components/Connexion.vue')
    },
    {
      path: '/compte',
      name: 'compte',
      component: () => import('./components/MonCompte.vue')
    },
    {
      path: '/politique',
      name: 'politique',
      component: () => import('./components/Politique.vue')
    },
    {
      path: '/profil/:id',
      name: 'profil',
      component: () => import('./components/Profil.vue')
    },
    {
      path: '/modifierpost/:id',
      name: 'modifierpost',
      component: () => import('./components/ModifierPost.vue')
    },
  ]
})

export default router