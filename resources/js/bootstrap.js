// resources/js/bootstrap.js - VERSIÓN MÍNIMA
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


console.log('Bootstrap loaded without Echo');
