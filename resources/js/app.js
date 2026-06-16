import './bootstrap';
import axios from 'axios';
import Alpine from 'alpinejs';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Alpine = Alpine;
Alpine.start();

const token = localStorage.getItem('auth_token');
if (token) {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}
