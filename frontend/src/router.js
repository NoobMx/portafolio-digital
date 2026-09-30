import { createRouter, createWebHistory } from 'vue-router'
import Portafolio from './components/Portafolio.vue'
import Login from './components/Login.vue'
import Home from './components/Home.vue'

const routes = [
    {
        path: '/',
        name: 'Portafolio',
        component: Portafolio // Raíz pública
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/admin',
        name: 'Admin',
        component: Home,
        meta: { requiresAuth: true } 
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from) => {
  const isAuthenticated = localStorage.getItem('usuario');
  
  if (to.meta.requiresAuth && !isAuthenticated) {
    return '/'; // Retornas la ruta a la que quieres redirigir
  }
  return true; // Retornas true para dejar pasar
});

export default router