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
import sweetAlert from "sweetalert2";

const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674',
};
app.use(VueSweetalert2, options);

window.$_toastAlert = function toastAlert(icon, message) {
    const Toast = sweetAlert.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', sweetAlert.stopTimer)
            toast.addEventListener('mouseleave', sweetAlert.resumeTimer)
        }
    });

    Toast.fire({
        icon: icon,
        title: message
    });
}

// ------------------------------------------------------

// mount app
app.mount('#app');
