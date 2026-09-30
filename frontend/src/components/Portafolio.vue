<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#">Mi Portafolio Profesional</a>

                <div class="navbar-nav ms-auto">
                    <router-link to="/login" class="btn btn-outline-light btn-sm">Admin</router-link>
                </div>
            </div>
        </nav>

        <div class="bg-light py-5 border-bottom mb-5">
            <div class="container py-5">
                <div class="row align-items-center">
                    <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                        <p class="text-primary fw-bold mb-1">¡Hola Mundo! Mi nombre es:</p>
                        <h1 class="display-4 fw-bold mb-3">ROBERTO ALEXIS MEJIA OSORIO</h1>
                        <h2 class="h4 fw-light text-muted mb-4">Desarrollador Full-Stack</h2>
                        <p class="lead mb-4">
                            Construyo aplicaciones web modernas, conectando interfaces interactivas e intuitivas con bases de datos robustas y seguras.
                        </p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <a href="#proyectos" class="btn btn-primary btn-lg px-4 me-md-2">Ver Proyectos</a>
                            <!-- <button class="btn btn-outline-secondary btn-lg px-4">Descargar CV</button> -->
                            <a :href="urlCV" target="_blank" class="btn btn-outline-secondary btn-lg px-4">Ver / Descargar CV</a>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <img 
                            src="https://ui-avatars.com/api/?name=Dev+FullStack&size=400&background=0d6efd&color=fff&rounded=true"
                            alt="Mi Foto de Perfil"
                            class="img-fluid shadow-lg rounded-circle"
                            style="max-width: 350px; border: 5px solid white;"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-5 py-4">
            <div class="row g-5">
                <div class="col-md-6">
                    <h3 class="fw-bold mb-3 border-bottom pb-2">Sobre Mí</h3>
                    <p class="text-justify">
                        Soy un apasionado de la tecnología y el desarrollo de software. Mi viaje en la programación comenzó con la curiosidad de entender cómo funcionaban las aplicaciones que usaba a diario, lo que me llevó a estudiar y especializarme en el entorno Full-Stack.
                    </p>
                    <p class="text-justify">
                        Me enfoco en escribir código limpio, eficiente y escalable. Disfruto resolver problemas lógicos complejos en el backend tanto como diseñar interfaces fluidas y agradables para el usuario en el frontend. Siempre estoy buscando aprender nuevas herramientas y adoptar las mejores prácticas de la industria.
                    </p>
                </div>

                <div class="col-md-6">
                    <h3 class="fw-bold mb-3 border-bottom pb-2">Habilidades Técnicas</h3>
                    <p class="text-muted small mb-3">Estas son las tecnologías con las que trabajo habitualmente en mis proyectos:</p>
                    <div class="mb-3">
                        <h5 class="h6 fw-bold text-secondary">Frontend:</h5>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-primary px-3 py-2 fs-6 shadow-sm">Vue.js 3</span>
                            <span class="badge bg-dark px-3 py-2 fs-6 shadow-sm" style="background-color: #563d7c !important;">Bootstrap 5</span>
                            <span class="badge bg-warning text-dark px-3 py-2 fs-6 shadow-sm">JavaScript (ES6+)</span>
                            <span class="badge bg-info text-dark px-3 py-2 fs-6 shadow-sm">HTML5 & CSS3</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5 class="h6 fw-bold text-secondary">Backend & Bases de Datos:</h5>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-dark px-3 py-2 fs-6 shadow-sm" style="background-color: #777bb4 !important;">PHP 8</span>
                            <span class="badge bg-secondary px-3 py-2 fs-6 shadow-sm" style="background-color: #336791 !important;">PostgreSQL</span>
                            <span class="badge bg-success px-3 py-2 fs-6 shadow-sm">Node.js</span>
                            <span class="badge bg-light text-dark border px-3 py-2 fs-6 shadow-sm">PDO SQL</span>
                        </div>
                    </div>

                    <div>
                        <h5 class="h6 fw-bold text-secondary">Herramientas & Entorno:</h5>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-dark px-3 py-2 fs-6 shadow-sm">Git & GitHub</span>
                            <span class="badge bg-info text-dark px-3 py-2 fs-6 shadow-sm">Postman</span>
                            <span class="badge bg-primary px-3 py-2 fs-6 shadow-sm" style="background-color: #007acc !important;">VS Code</span>
                        </div>
                    </div>
                </div>

                <section id="trayectoria" class="py-5 bg-light">
                    <div class="container py-4">
                        <h2 class="text-center fw-bold mb-5">Mi Trayectoria</h2>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="timeline">
                                    <div class="timeline-item" v-for="item in listaExperiencia" :key="item.id_experiencia">
                                        <div class="timeline-icon" :class="item.tipo === 'experiencia' ? 'bg-primary' : 'bg-success'">
                                            <i class="bi" :class="item.tipo === 'experiencia' ? 'bi-briefcase-fill' : 'bi-mortarboard-fill'"></i>
                                        </div>
                                        <div class="timeline-content shadow-sm">
                                            <span class="badge rounded-pill text-bg-dark mb-2">
                                                {{ formatearFecha(item.fecha_inicio) }} - {{ item.actual ? 'Presente' : formatearFecha(item.fecha_fin) }}
                                            </span>
                                        <h4 class="fw-bold mb-1">{{ item.titulo }}</h4>
                                        <h6 class="text-muted mb-3"><i class="bi bi-building me-1"></i> {{ item.institucion_empresa }}</h6>
                                        <p class="mb-0 text-secondary">{{ item.descripcion }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div id="proyectos" class="container mb-5 pt-4">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="border-bottom pb-2">Proyectos Destacados</h2>
                </div>
            </div>

            <div class="row">
                <div 
                    v-for="proyecto in listaProyectos" 
                    :key="proyecto.id_proyecto" 
                    class="col-12 col-md-6 col-lg-4 mb-4"
                >
                    <div class="card h-100 shadow-sm">
                        <img :src="proyecto.url_imagen" class="card-img-top" alt="Miniatura">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ proyecto.titulo }}</h5>
                            <p class="card-text text-muted small"><strong>Tech:</strong> {{ proyecto.tecnologias }}</p>
                            <p class="card-text flex-grow-1">{{ proyecto.descripcion }}</p>
                            <a 
                                v-if="proyecto.url_github" 
                                :href="proyecto.url_github" 
                                target="_blank" 
                                class="btn btn-primary btn-sm mt-auto"
                            >
                                Ver Código
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'AppPortafolio',
    data() {
        return {
            listaProyectos: [],
            basePath: 'http://localhost:9000/',
            urlCV: '#',
            nombreCompleto: 'Cargando...',
            listaExperiencia: []
        }
    },
    mounted() {
        this.cargarProyectos();
        this.cargarCV();
        this.cargarExperiencia();
    },
    methods: {
        async cargarProyectos() {
            try {
                debugger;
                const response = await axios.get(this.basePath + 'proyectos.php');
                if (response.data.success) {
                    this.listaProyectos = response.data.data;
                }
            } catch (error) {
                console.error('Error al cargar proyectos públicos:', error);
            }
        },

        async cargarCV() {
            try {
                const response = await axios.get(this.basePath + 'files.php?tipo=cv');
                if (response.data.success && response.data.data) {
                    this.urlCV = response.data.data.url;
                }
            } catch (error) {
                console.error('Error al cargar el CV desde la tabla files:', error);
            }
        },

        async cargarExperiencia() {
            try {
                const response = await axios.get(this.basePath + 'experiencia.php');
                if (response.data.success) {
                    this.listaExperiencia = response.data.data;
                }
            } catch (error) {
                console.error('Error al cargar la experiencia:', error);
            }
        },

        // Método para poner las fechas bonitas (ej: "2024-04-01" -> "Abr 2024")
        formatearFecha(fechaSql) {
            if (!fechaSql) return '';
            const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
            const partes = fechaSql.split('-'); // [0] Año, [1] Mes, [2] Día
            const mesIndex = parseInt(partes[1]) - 1;
            return `${meses[mesIndex]} ${partes[0]}`;
        }
    }
}
</script>

<style scoped>
.timeline {
    position: relative;
    padding-left: 30px;
}
.timeline::before {
    content: '';
    position: absolute;
    top: 0;
    left: 15px;
    height: 100%;
    width: 2px;
    background-color: #dee2e6;
}
.timeline-item {
    position: relative;
    margin-bottom: 2.5rem;
}
.timeline-icon {
    position: absolute;
    left: -40px;
    top: 0;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 0 4px #f8f9fa;
    z-index: 1;
}
.timeline-content {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    border: 1px solid #f1f3f5;
    transition: transform 0.2s ease;
}
.timeline-content:hover {
    transform: translateX(5px);
}
</style>