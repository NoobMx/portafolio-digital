import { createApp } from 'vue'
import App from './App.vue'
import router from './router' // <-- Importamos el router

import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css'; // <-- ¡Agrega esta línea!

const app = createApp(App)

app.use(router) // <-- Le decimos a Vue que lo use
app.mount('#app')