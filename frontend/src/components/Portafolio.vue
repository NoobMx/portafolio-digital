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
                            <!-- Botón dinámico del CV usando la tabla files -->
                            <a :href="urlCV" target="_blank" class="btn btn-outline-secondary btn-lg px-4">Ver / Descargar CV</a>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <img 
                            :src="urlFotoPerfil"
                            alt="Mi Foto de Perfil"
                            class="foto-perfil shadow-lg rounded-circle"
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
                                    <!-- Aquí está tu Experiencia y Educación intacta -->
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
                    <div class="card h-100 shadow-sm border-0 card-proyecto" @click="abrirDetalle(proyecto)">
                        <div class="proyecto-img-wrap position-relative">
                            <img :src="urlImagenDirecta(proyecto.url_imagen)" class="w-100 h-100 object-fit-cover" :alt="proyecto.titulo">
                            <span v-if="imagenesProyecto(proyecto).length > 1" class="badge bg-dark bg-opacity-75 position-absolute bottom-0 end-0 m-2">
                                <i class="bi bi-images me-1"></i>{{ imagenesProyecto(proyecto).length }}
                            </span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold clamp-2">{{ proyecto.titulo }}</h5>
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                <span v-for="tec in tecnologiasLista(proyecto.tecnologias).slice(0, 3)" :key="tec" class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle">{{ tec }}</span>
                                <span v-if="tecnologiasLista(proyecto.tecnologias).length > 3" class="badge bg-light text-muted border">+{{ tecnologiasLista(proyecto.tecnologias).length - 3 }}</span>
                            </div>
                            <p class="card-text text-secondary small clamp-3 mb-3">{{ proyecto.descripcion }}</p>
                            <div class="mt-auto d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary btn-sm flex-grow-1" @click.stop="abrirDetalle(proyecto)">
                                    <i class="bi bi-eye me-1"></i> Ver más
                                </button>
                                <a v-if="proyecto.url_github" :href="proyecto.url_github" target="_blank" class="btn btn-dark btn-sm" @click.stop title="Ver código">
                                    <i class="bi bi-github"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NUEVA SECCIÓN: CERTIFICACIONES Y CATÁLOGO -->
        <div id="certificaciones" class="container mb-5 pt-4">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="border-bottom pb-2">Certificaciones y Credenciales</h2>
                </div>
            </div>

            <div class="row g-4">
                <div 
                    v-for="cert in listaCertificaciones" 
                    :key="cert.id_file" 
                    class="col-12 col-md-6 col-lg-4"
                >
                    <div class="card h-100 shadow-sm border-0 card-certificacion">
                        <!-- Vista previa de la miniatura -->
                        <div class="position-relative overflow-hidden bg-light rounded-top" style="height: 200px;">
                            <img 
                                :src="cert.url_miniatura || 'https://placehold.co/600x400/212529/0d6efd?text=Certificado'" 
                                :alt="cert.nombre" 
                                class="w-100 h-100 object-fit-cover"
                            >
                            <span class="badge position-absolute top-0 end-0 m-2 shadow-sm" :class="cert.formato === 'pdf' ? 'bg-danger' : 'bg-primary'">
                                {{ cert.formato ? cert.formato.toUpperCase() : 'PDF' }}
                            </span>
                        </div>

                        <!-- Información de la certificación -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark h6 mb-1">{{ cert.nombre }}</h5>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-building me-1"></i> {{ cert.emisor }} <br>
                                <i class="bi bi-calendar3 me-1"></i> {{ cert.fecha_emision ? formatearFecha(cert.fecha_emision) : 'Sin fecha' }}
                            </p>
                            
                            <div class="mt-auto pt-2 border-top">
                                <a 
                                    :href="cert.url" 
                                    target="_blank" 
                                    class="btn btn-outline-primary btn-sm w-100"
                                >
                                    <i class="bi bi-eye-fill me-1"></i> Ver Documento
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mensaje si no hay certificaciones aún -->
                <div v-if="listaCertificaciones.length === 0" class="col-12 text-center text-muted py-4">
                    <i class="bi bi-patch-exclamation display-4 mb-2 d-block opacity-50"></i>
                    Aún no hay certificaciones registradas.
                </div>
            </div>
        </div>

        <!-- MODAL DETALLE DE PROYECTO -->
        <div v-if="proyectoSeleccionado" class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.6);" @click.self="cerrarDetalle">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-dark text-white border-0">
                        <h5 class="modal-title fw-bold">{{ proyectoSeleccionado.titulo }}</h5>
                        <button type="button" class="btn-close btn-close-white" @click="cerrarDetalle"></button>
                    </div>
                    <!-- CARRUSEL DE IMÁGENES -->
                    <div v-if="imagenesDetalle.length" class="carrusel" @keydown.left="cambiarImagen(-1)" @keydown.right="cambiarImagen(1)" tabindex="0">
                        <div class="carrusel-pista" :style="{ transform: `translateX(-${indiceImagen * 100}%)` }">
                            <div v-for="(img, i) in imagenesDetalle" :key="img + i" class="carrusel-slide">
                                <img :src="urlImagenDirecta(img)" :alt="proyectoSeleccionado.titulo + ' - imagen ' + (i + 1)">
                            </div>
                        </div>
                        <template v-if="imagenesDetalle.length > 1">
                            <button type="button" class="carrusel-btn izq" @click="cambiarImagen(-1)" aria-label="Anterior"><i class="bi bi-chevron-left"></i></button>
                            <button type="button" class="carrusel-btn der" @click="cambiarImagen(1)" aria-label="Siguiente"><i class="bi bi-chevron-right"></i></button>
                            <span class="carrusel-contador">{{ indiceImagen + 1 }} / {{ imagenesDetalle.length }}</span>
                        </template>
                    </div>
                    <div v-if="imagenesDetalle.length > 1" class="carrusel-miniaturas">
                        <img v-for="(img, i) in imagenesDetalle" :key="'m' + i" :src="urlImagenDirecta(img)" :class="{ activa: i === indiceImagen }" @click="indiceImagen = i" :alt="'Miniatura ' + (i + 1)">
                    </div>
                    <div class="modal-body p-4">
                        <h6 class="fw-bold text-secondary small text-uppercase mb-2">Tecnologías</h6>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span v-for="tec in tecnologiasLista(proyectoSeleccionado.tecnologias)" :key="tec" class="badge bg-primary px-3 py-2">{{ tec }}</span>
                        </div>
                        <h6 class="fw-bold text-secondary small text-uppercase mb-2">Descripción</h6>
                        <p class="mb-0" style="white-space: pre-line;">{{ proyectoSeleccionado.descripcion }}</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light border" @click="cerrarDetalle">Cerrar</button>
                        <a v-if="proyectoSeleccionado.url_github" :href="proyectoSeleccionado.url_github" target="_blank" class="btn btn-dark">
                            <i class="bi bi-github me-1"></i> Ver Código
                        </a>
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
            //basePath: 'http://localhost:9000/',
            basePath: window.location.hostname === 'localhost' 
                ? 'http://localhost:9000/' 
                : 'https://portafolio-digital-production.up.railway.app/',
            urlCV: '#',
            nombreCompleto: 'Cargando...',
            listaExperiencia: [],
            listaCertificaciones: [], // Nueva lista para el catálogo
            proyectoSeleccionado: null, // Proyecto abierto en el modal de detalle
            indiceImagen: 0,            // Imagen visible en el carrusel
            urlFotoPerfil: 'https://ui-avatars.com/api/?name=Roberto+Mejia&size=400&background=0d6efd&color=fff&rounded=true' // Respaldo si no hay foto en la BD
        }
    },
    computed: {
        imagenesDetalle() {
            return this.proyectoSeleccionado ? this.imagenesProyecto(this.proyectoSeleccionado) : [];
        }
    },
    mounted() {
        this.cargarProyectos();
        this.cargarCV();
        this.cargarExperiencia();
        this.cargarCertificaciones(); // Nueva llamada
        this.cargarFotoPerfil();
    },
    methods: {
        async cargarProyectos() {
            try {
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
                // Adaptado al nuevo formato estandarizado
                const response = await axios.get(this.basePath + 'files.php?categoria=cv&single=true');
                if (response.data.success && response.data.data) {
                    this.urlCV = response.data.data.url;
                }
            } catch (error) {
                console.error('Error al cargar el CV:', error);
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

        async cargarCertificaciones() {
            try {
                // Obtenemos solo los archivos de categoría 'certificacion'
                const response = await axios.get(this.basePath + 'files.php?categoria=certificacion');
                if (response.data.success) {
                    this.listaCertificaciones = response.data.data;
                }
            } catch (error) {
                console.error('Error al cargar certificaciones:', error);
            }
        },

        async cargarFotoPerfil() {
            try {
                const response = await axios.get(this.basePath + 'files.php?categoria=foto_perfil&single=true');
                if (response.data.success && response.data.data) {
                    this.urlFotoPerfil = this.urlImagenDirecta(response.data.data.url);
                }
            } catch (error) {
                console.error('Error al cargar la foto de perfil:', error);
            }
        },

        // Convierte un link de Google Drive (".../file/d/ID/view") en un link que sí se puede usar en <img>
        urlImagenDirecta(url) {
            const match = url && url.match(/drive\.google\.com\/file\/d\/([^/]+)/);
            return match ? `https://drive.google.com/thumbnail?id=${match[1]}&sz=w800` : url;
        },

        tecnologiasLista(texto) {
            return (texto || '').split(',').map(t => t.trim().replace(/\.$/, '')).filter(Boolean);
        },

        // Portada + galería, sin repetidas ni vacías
        imagenesProyecto(proyecto) {
            const todas = [proyecto.url_imagen, ...(proyecto.imagenes || [])].filter(Boolean);
            return [...new Set(todas)];
        },

        cambiarImagen(dir) {
            const total = this.imagenesDetalle.length;
            this.indiceImagen = (this.indiceImagen + dir + total) % total;
        },

        abrirDetalle(proyecto) {
            this.proyectoSeleccionado = proyecto;
            this.indiceImagen = 0;
            document.body.style.overflow = 'hidden';
        },

        cerrarDetalle() {
            this.proyectoSeleccionado = null;
            document.body.style.overflow = '';
        },

        formatearFecha(fechaSql) {
            if (!fechaSql) return '';
            const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
            const partes = fechaSql.split('-'); 
            const mesIndex = parseInt(partes[1]) - 1;
            return `${meses[mesIndex]} ${partes[0]}`;
        }
    }
}
</script>

<style scoped>
  /* Estilos originales de la línea del tiempo */
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

  /* Nuevos estilos para las tarjetas del catálogo */
  .card-certificacion {
      transition: transform 0.25s ease, box-shadow 0.25s ease;
      border-radius: 12px;
  }
  .card-certificacion:hover {
      transform: translateY(-5px);
      box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.12) !important;
  }
  .object-fit-cover {
      object-fit: cover;
  }

  /* Foto de perfil: siempre circular y del mismo tamaño, sin importar la imagen */
  .foto-perfil {
      width: 100%;
      max-width: 350px;
      aspect-ratio: 1 / 1;
      object-fit: cover;
      border: 5px solid white;
  }

  /* Tarjetas de proyectos con tamaño uniforme */
  .card-proyecto {
      border-radius: 12px;
      overflow: hidden;
      cursor: pointer;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
  }
  .card-proyecto:hover {
      transform: translateY(-5px);
      box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.12) !important;
  }
  .proyecto-img-wrap {
      height: 200px;
      background-color: #f8f9fa;
  }
  .clamp-2,
  .clamp-3 {
      display: -webkit-box;
      -webkit-box-orient: vertical;
      overflow: hidden;
  }
  .clamp-2 { -webkit-line-clamp: 2; line-clamp: 2; }
  .clamp-3 { -webkit-line-clamp: 3; line-clamp: 3; }

  /* Carrusel del modal de detalle */
  .carrusel {
      position: relative;
      overflow: hidden;
      background: #111;
      outline: none;
      flex-shrink: 0;
  }
  .carrusel-pista {
      display: flex;
      transition: transform 0.4s ease;
  }
  .carrusel-slide {
      flex: 0 0 100%;
      height: 400px;
      display: flex;
      align-items: center;
      justify-content: center;
  }
  .carrusel-slide img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain; /* Se ve la imagen completa, sin recortes */
  }
  .carrusel-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 40px;
      height: 40px;
      border: none;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.85);
      color: #212529;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
      transition: background 0.2s ease;
  }
  .carrusel-btn:hover { background: #fff; }
  .carrusel-btn.izq { left: 12px; }
  .carrusel-btn.der { right: 12px; }
  .carrusel-contador {
      position: absolute;
      bottom: 10px;
      right: 12px;
      background: rgba(0, 0, 0, 0.6);
      color: #fff;
      font-size: 0.8rem;
      padding: 2px 10px;
      border-radius: 12px;
  }
  .carrusel-miniaturas {
      display: flex;
      gap: 8px;
      padding: 10px 16px;
      overflow-x: auto;
      background: #f8f9fa;
      flex-shrink: 0;
  }
  .carrusel-miniaturas img {
      width: 72px;
      height: 48px;
      object-fit: cover;
      border-radius: 6px;
      cursor: pointer;
      opacity: 0.55;
      border: 2px solid transparent;
      transition: opacity 0.2s ease;
  }
  .carrusel-miniaturas img:hover { opacity: 0.85; }
  .carrusel-miniaturas img.activa {
      opacity: 1;
      border-color: #0d6efd;
  }
  @media (max-width: 576px) {
      .carrusel-slide { height: 240px; }
  }
</style>