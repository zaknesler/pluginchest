import './bootstrap'

import ExampleComponent from './components/ExampleComponent.vue'

const app = new Vue({
    el: '#app',

    data: {
        displayNavigation: false
    },

    methods: {
        logout() {
            this.$refs.logoutForm.submit()
        }
    },

    components: {
        ExampleComponent,
    }
})
