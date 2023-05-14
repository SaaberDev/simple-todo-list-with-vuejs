import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// init vue
import { createApp } from 'vue';
import App from './vue/App.vue';

const app = createApp(App);
app.component('App', App);

// ------------------------------------------------------

// sweetalert2
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674',
};
app.use(VueSweetalert2, options);

// ------------------------------------------------------

// mount app
app.mount('#app');
