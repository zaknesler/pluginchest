import Vue from 'vue';
import axios from 'axios';

window.Vue = Vue;
window.axios = axios;


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('Cannot load CSRF token.');
}

Vue.prototype.$http = window.axios;
