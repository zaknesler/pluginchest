import './bootstrap';

import LogoutComponent from './components/Logout.vue';

Vue.component('logout', LogoutComponent);

const app = new Vue({
    el: '#root',

    data: {
        responsiveNav: false
    }
});
