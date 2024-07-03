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