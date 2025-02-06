import { createApp } from "vue/dist/vue.esm-bundler";
import TextBlock from "./components/TextBlock.vue";
import ContactForm from "./components/ContactForm.vue";

import.meta.glob(["../../images/**"]);

import * as bootstrap from "bootstrap";
window.bootstrap = bootstrap;

// Import SweetAlert
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const app = createApp({
    components: {
        ContactForm
    }
});

// Add SweetAlert to global properties
app.config.globalProperties.$swal = Swal;

app.mount("#app-container");