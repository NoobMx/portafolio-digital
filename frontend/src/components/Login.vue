<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Iniciar Sesión</h4>
                        
                        <form @submit.prevent="login">
                            <div class="mb-3">
                                <label for="user" class="form-label">Usuario:</label>
                                <input 
                                    id="user" 
                                    v-model="userName" 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Ej. admin" 
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input 
                                    id="password" 
                                    v-model="password" 
                                    type="password" 
                                    class="form-control" 
                                    placeholder="Contraseña" 
                                    required
                                >
                            </div>

                            <div 
                                v-if="error" 
                                class="alert alert-danger alert-dismissible fade show mt-3" 
                                role="alert"
                            >
                                {{ msgError }}
                                <button type="button" class="btn-close" @click="error = false" aria-label="Close"></button>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-2">
                                Entrar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'AppLogin',
    data() {
        return {
            userName: '',
            password: '',
            error: false,
            msgError: '',
            // Apuntamos a la raíz de tu servidor PHP
            //basePath: 'http://localhost:9000/'
            basePath: window.location.hostname === 'localhost' 
                ? 'http://localhost:9000/' 
                : 'https://portafolio-digital-production.up.railway.app/'
        };
    },
    methods: {
        async login() {
            try {
                this.error = false;
                const response = await axios.post(this.basePath + 'auth.php', {
                    user: this.userName,
                    password: this.password
                }, {
                    headers: { 'Content-Type': 'application/json' }
                });
                if (response.data.success) {
                    localStorage.setItem('usuario', JSON.stringify(response.data.user));
                    this.$router.push('/admin');
                } else {
                    this.error = true;
                    this.msgError = response.data.message || 'Usuario o contraseña incorrectos';
                }
            } catch (error) {
                this.error = true;
                this.msgError = error.response?.data?.error || 'Error al conectar con el servidor';
                console.error(error);
            }
        }
    }
}
</script>

<style scoped>
.card {
  border-radius: 10px;
  border: none;
}
</style>