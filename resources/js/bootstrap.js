import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers['Accept'] = 'application/json'

window.axios.defaults.withCredentials = true
window.axios.defaults.withXSRFToken = true

// afficher chaque requête en console
// window.axios.interceptors.request.use(request => {
//   console.log('Starting Request', JSON.stringify(request, null, 2))
//   return request
// })

import { useUserStore } from './stores/userStore'
import { useRouter } from 'vue-router';
import { useRoute } from 'vue-router'

// intercepter les erreurs 401 et déconnecter l'utilisateur si c'est le cas (hors route connexion)
// window.axios.interceptors.response.use(function (response) {
//     return response;
// }, function (error) {
//     const route = useRoute()
// console.log(route);
//     if (401 === error.response.status && route.name != "connexion") {

//         alert('Votre session a expiré. Vous allez être déconnecté(e). Merci de vous reconnecter.')

//         // on remet le store à 0 
//         const userStore = useUserStore()
//         userStore.$reset()

//         // on redirige vers l'accueil
//         const router = useRouter()
//         router.push('/')

//     } else {
//         return Promise.reject(error);
//     }
// });