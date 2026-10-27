<template>
    <div class="admin-panel">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark main-navbar shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">Panel de Administración</a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAdmin">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNavAdmin">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <button 
                                class="nav-link btn btn-link fw-semibold px-3 border-0" 
                                :class="{ 'active text-primary fw-bold': vistaActiva === 'proyectos' }"
                                @click="vistaActiva = 'proyectos'"
                            >
                                <i class="bi bi-folder-fill me-1"></i> Proyectos
                            </button>
                        </li>
                        <li class="nav-item">
                            <button 
                                class="nav-link btn btn-link fw-semibold px-3 border-0" 
                                :class="{ 'active text-primary fw-bold': vistaActiva === 'experiencia' }"
                                @click="vistaActiva = 'experiencia'"
                            >
                                <i class="bi bi-briefcase-fill me-1"></i> Experiencia y Educación
                            </button>
                        </li>
                        <li class="nav-item">
                            <button 
                                class="nav-link btn btn-link fw-semibold px-3 border-0" 
                                :class="{ 'active text-primary fw-bold': vistaActiva === 'archivos' }"
                                @click="vistaActiva = 'archivos'"
                            >
                                <i class="bi bi-file-earmark-code-fill me-1"></i> Archivos y Certificaciones
                            </button>
                        </li>
                    </ul>
                    
                    <button class="btn btn-outline-danger btn-sm" @click="logout()">
                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                    </button>
                </div>
            </div>
        </nav>
        
        <div class="container mt-4 pt-2">
            <!-- PESTAÑA 1: PROYECTOS -->
            <div v-if="vistaActiva === 'proyectos'" class="animate__animated animate__fadeIn">
                <div class="container mt-5 pt-2">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="h3 fw-bold text-dark mb-1">Gestión de Proyectos</h2>
                            <p class="text-muted small mb-0">Administra los elementos que se muestran en tu portafolio público.</p>
                        </div>
                        <button class="btn btn-add-project shadow-sm fw-medium px-4" @click="abrirModalCrear">
                            <i class="bi bi-plus-lg me-2"></i>Nuevo Proyecto
                        </button>
                    </div>

                    <div v-if="error" class="alert alert-custom-danger shadow-sm border-0 d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <div>{{ msgError }}</div>
                    </div>

                    <div class="custom-table-container shadow-sm border-0 mb-5">
                        <div class="table-responsive">
                            <table class="table custom-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 80px;">ID</th>
                                        <th scope="col" style="width: 300px;">Título del Proyecto</th>
                                        <th scope="col">Tecnologías</th>
                                        <th scope="col" class="text-end" style="width: 150px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="proyecto in listaProyectos" :key="proyecto.id_proyecto">
                                        <td class="text-muted font-monospace small">#{{ proyecto.id_proyecto }}</td>
                                        <td><div class="fw-semibold text-dark">{{ proyecto.titulo }}</div></td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <span 
                                                    v-for="(tech, index) in proyecto.tecnologias.split(',')" 
                                                    :key="index" 
                                                    class="badge"
                                                    :class="[
                                                        'bg-primary bg-opacity-10 text-primary border border-primary',
                                                        'bg-success bg-opacity-10 text-success border border-success',
                                                        'bg-info bg-opacity-10 text-info border border-info',
                                                        'bg-danger bg-opacity-10 text-danger border border-danger',
                                                        'bg-warning bg-opacity-10 text-dark border border-warning',
                                                        'bg-dark bg-opacity-10 text-dark border border-dark'
                                                    ][index % 6]"
                                                >
                                                    {{ tech.trim() }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <!-- Botones solo con iconos -->
                                            <button class="btn btn-action-edit btn-sm me-2 fw-medium" @click="abrirModalEditar(proyecto)" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-action-delete btn-sm fw-medium" @click="eliminarProyecto(proyecto.id_proyecto)" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="listaProyectos.length === 0">
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-folder-x display-6 d-block mb-2 text-secondary opacity-50"></i>
                                            No hay proyectos registrados en la base de datos.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- PESTAÑA 2: EXPERIENCIA -->
            <div v-if="vistaActiva === 'experiencia'" class="animate__animated animate__fadeIn">
                <div class="container mt-5 pt-2">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="h3 fw-bold text-dark mb-1">Experiencia y Educación</h2>
                            <p class="text-muted small mb-0">Administra tu trayectoria laboral y académica que aparece en la línea del tiempo.</p>
                        </div>
                        <button class="btn btn-add-project shadow-sm fw-medium px-4" @click="abrirModalExperiencia()">
                            <i class="bi bi-plus-lg me-2"></i>Nuevo Registro
                        </button>
                    </div>
                    
                    <div class="custom-table-container shadow-sm border-0 mb-5">
                        <div class="table-responsive">
                            <table class="table custom-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 80px;">Orden</th>
                                        <th scope="col" style="width: 150px;">Tipo</th>
                                        <th scope="col">Título (Puesto o Carrera)</th>
                                        <th scope="col">Institución / Empresa</th>
                                        <th scope="col" class="text-end" style="width: 200px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="exp in listaExperiencia" :key="exp.id_experiencia">
                                        <td class="text-muted font-monospace small">#{{ exp.orden }}</td>
                                        <td>
                                            <span class="badge" 
                                                  :class="exp.tipo === 'experiencia' ? 'bg-primary bg-opacity-10 text-primary border border-primary' : 'bg-success bg-opacity-10 text-success border border-success'">
                                                {{ exp.tipo.toUpperCase() }}
                                            </span>
                                        </td>
                                        <td><div class="fw-semibold text-dark">{{ exp.titulo }}</div></td>
                                        <td><span class="text-muted small"><i class="bi bi-building me-1"></i> {{ exp.institucion_empresa }}</span></td>
                                        <td class="text-end">
                                            <button class="btn btn-action-edit btn-sm me-2 fw-medium" @click="editarExperiencia(exp)">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-action-delete btn-sm fw-medium" @click="eliminarExperiencia(exp.id_experiencia)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="listaExperiencia.length === 0">
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bi bi-briefcase display-6 d-block mb-2 text-secondary opacity-50"></i>
                                            No hay registros de experiencia.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PESTAÑA 3: ARCHIVOS Y CERTIFICACIONES -->
            <div v-if="vistaActiva === 'archivos'" class="animate__animated animate__fadeIn">
                <div class="container mt-5 pt-2">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="h3 fw-bold text-dark mb-1">Archivos y Certificaciones</h2>
                            <p class="text-muted small mb-0">Gestiona tu CV, foto de perfil y diplomas para el catálogo digital.</p>
                        </div>
                        <button class="btn btn-add-project shadow-sm fw-medium px-4" @click="abrirModalArchivo()">
                            <i class="bi bi-plus-lg me-2"></i>Agregar Archivo
                        </button>
                    </div>

                    <div class="custom-table-container shadow-sm border-0 mb-5">
                        <div class="table-responsive">
                            <table class="table custom-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 80px;">ID</th>
                                        <th scope="col">Nombre del Documento</th>
                                        <th scope="col" style="width: 140px;">Categoría</th>
                                        <th scope="col" style="width: 120px;">Formato</th>
                                        <th scope="col">Emisor</th>
                                        <th scope="col" class="text-end" style="width: 210px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="file in listaArchivos" :key="file.id_file">
                                        <td class="text-muted font-monospace small">#{{ file.id_file }}</td>
                                        <td><div class="fw-semibold text-dark">{{ file.nombre }}</div></td>
                                        <td>
                                            <span class="badge" 
                                                  :class="file.categoria === 'cv' ? 'bg-info bg-opacity-10 text-info border border-info' : 'bg-primary bg-opacity-10 text-primary border border-primary'">
                                                {{ file.categoria.toUpperCase() }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge custom-badge">
                                                <i class="bi" :class="file.formato === 'pdf' ? 'bi-file-pdf text-danger' : 'bi-image text-success'"></i>
                                                {{ file.formato ? file.formato.toUpperCase() : 'PDF' }}
                                            </span>
                                        </td>
                                        <td><span class="text-muted small">{{ file.emisor || 'N/A' }}</span></td>
                                        <td class="text-end">
                                            <a :href="file.url" target="_blank" class="btn btn-action-view btn-sm me-2 fw-medium" title="Ver Documento">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <button class="btn btn-action-edit btn-sm me-2 fw-medium" @click="editarArchivo(file)">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-action-delete btn-sm fw-medium" @click="eliminarArchivo(file.id_file)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="listaArchivos.length === 0">
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="bi bi-file-earmark-x display-6 d-block mb-2 text-secondary opacity-50"></i>
                                            No hay archivos ni certificaciones registradas.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PROYECTOS MODAL -->
        <div class="modal fade" :class="{ 'show d-block': modalAbierto }" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog" :class="modalMaximizado ? 'modal-fullscreen' : 'modal-lg modal-dialog-centered modal-dialog-scrollable'">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-dark text-white border-0 py-3">
                        <h5 class="modal-title fw-bold">{{ editando ? 'Editar Proyecto' : 'Nuevo Proyecto' }}</h5>
                        <div class="ms-auto d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-outline-light border-0" @click="modalMaximizado = !modalMaximizado" :title="modalMaximizado ? 'Restaurar' : 'Maximizar'">
                                <i class="bi" :class="modalMaximizado ? 'bi-fullscreen-exit' : 'bi-arrows-fullscreen'"></i>
                            </button>
                            <button type="button" class="btn-close btn-close-white" @click="cerrarModal"></button>
                        </div>
                    </div>
                    <div class="modal-body p-4">
                        <form @submit.prevent="guardarProyecto">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Título del Proyecto</label>
                                <input v-model="form.titulo" type="text" class="form-control form-control-custom" required placeholder="Ej: E-commerce Angular">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Tecnologías (Separadas por comas)</label>
                                <input v-model="form.tecnologias" type="text" class="form-control form-control-custom" required placeholder="Ej: Vue 3, PHP 8, PostgreSQL">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">URL de la Imagen de Portada (Opcional)</label>
                                <input v-model="form.url_imagen" type="url" class="form-control form-control-custom" placeholder="https://ejemplo.com/foto.jpg">
                                <div class="form-text">Es la que se ve en la tarjeta y la primera del carrusel.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Galería del Carrusel (Opcional)</label>
                                <div class="input-group">
                                    <input v-model="nuevaImagen" type="url" class="form-control form-control-custom" placeholder="https://ejemplo.com/captura.jpg" @keydown.enter.prevent="agregarImagen">
                                    <button type="button" class="btn btn-dark px-3" @click="agregarImagen" :disabled="!nuevaImagen.trim()">
                                        <i class="bi bi-plus-lg me-1"></i>Agregar
                                    </button>
                                </div>
                                <div class="form-text">Pega la URL y presiona Enter o "Agregar". Puedes cambiar el orden con las flechas.</div>

                                <div v-if="form.imagenes.length" class="galeria-admin mt-3">
                                    <div v-for="(img, i) in form.imagenes" :key="img + i" class="galeria-item shadow-sm">
                                        <img :src="urlImagenDirecta(img)" :alt="'Imagen ' + (i + 1)">
                                        <span class="galeria-num">{{ i + 1 }}</span>
                                        <div class="galeria-acciones">
                                            <button type="button" class="btn btn-sm btn-light" @click="moverImagen(i, -1)" :disabled="i === 0" title="Mover a la izquierda"><i class="bi bi-chevron-left"></i></button>
                                            <button type="button" class="btn btn-sm btn-light" @click="moverImagen(i, 1)" :disabled="i === form.imagenes.length - 1" title="Mover a la derecha"><i class="bi bi-chevron-right"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger" @click="quitarImagen(i)" title="Quitar"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="text-muted small mt-2"><i class="bi bi-images me-1"></i>Aún no hay imágenes en la galería.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Enlace de GitHub (Opcional)</label>
                                <input v-model="form.url_github" type="url" class="form-control form-control-custom" placeholder="https://github.com/tu-usuario/repositorio">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Descripción</label>
                                <textarea v-model="form.descripcion" class="form-control form-control-custom" :rows="modalMaximizado ? 14 : 6" placeholder="Describe brevemente el alcance del proyecto..."></textarea>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="button" class="btn btn-light px-4 border" @click="cerrarModal">Cancelar</button>
                                <button type="submit" class="btn btn-dark px-4">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- EXPERIENCIA MODAL -->
        <div class="modal fade" id="modalExperiencia" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-bg-primary">
                        <h5 class="modal-title">{{ editandoExperiencia ? 'Editar Registro' : 'Nuevo Registro' }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="guardarExperiencia">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipo</label>
                                    <select class="form-select" v-model="formExperiencia.tipo" required>
                                        <option value="experiencia">Experiencia Laboral</option>
                                        <option value="educacion">Educación</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Orden de aparición</label>
                                    <input type="number" class="form-control" v-model="formExperiencia.orden" required>
                                    <div class="form-text">Ej: 1 para que salga primero.</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Título (Puesto o Carrera)</label>
                                <input type="text" class="form-control" v-model="formExperiencia.titulo" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Institución o Empresa</label>
                                <input type="text" class="form-control" v-model="formExperiencia.institucion_empresa" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fecha de Inicio</label>
                                    <input type="date" class="form-control" v-model="formExperiencia.fecha_inicio" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fecha de Fin</label>
                                    <input type="date" class="form-control" v-model="formExperiencia.fecha_fin" :disabled="formExperiencia.actual">
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="checkActual" v-model="formExperiencia.actual">
                                <label class="form-check-label" for="checkActual">Este es mi puesto/estudio actual (Oculta fecha fin)</label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" rows="3" v-model="formExperiencia.descripcion"></textarea>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ARCHIVOS Y CERTIFICACIONES MODAL -->
        <div class="modal fade" id="modalArchivo" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-bg-success">
                        <h5 class="modal-title">{{ editandoArchivo ? 'Editar Archivo' : 'Nuevo Archivo / Certificación' }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="guardarArchivo">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Categoría</label>
                                    <select class="form-select" v-model="formArchivo.categoria" required>
                                        <option value="certificacion">Certificación</option>
                                        <option value="cv">Curriculum Vitae (CV)</option>
                                        <option value="reconocimiento">Reconocimiento</option>
                                        <option value="foto_perfil">Foto de Perfil</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Formato</label>
                                    <select class="form-select" v-model="formArchivo.formato" required>
                                        <option value="pdf">PDF</option>
                                        <option value="png">PNG</option>
                                        <option value="jpg">JPG</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre del Documento / Certificación</label>
                                <input type="text" class="form-control" v-model="formArchivo.nombre" required placeholder="Ej: Certificado PHP 8 Moderno">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Entidad Emisora</label>
                                    <input type="text" class="form-control" v-model="formArchivo.emisor" placeholder="Ej: Udemy, Cambridge, UPT">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Fecha de Emisión</label>
                                    <input type="date" class="form-control" v-model="formArchivo.fecha_emision">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">URL del Documento Original (Drive / Servidor)</label>
                                <input type="url" class="form-control" v-model="formArchivo.url" required placeholder="https://drive.google.com/file/d/.../view">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">URL de la Imagen en Miniatura (Opcional)</label>
                                <input type="url" class="form-control" v-model="formArchivo.url_miniatura" placeholder="https://ejemplo.com/miniatura.jpg">
                                <div class="form-text">Si la dejas vacía, usará una miniatura genérica.</div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save"></i> Guardar Archivo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios';
    import Swal from 'sweetalert2';
    import * as bootstrap from 'bootstrap';

    export default {
        name: 'AppHome',
        data() {
            return {
                vistaActiva: 'proyectos',
                nombreUsuario: '',
                listaProyectos: [],
                error: false,
                msgError: '',
                //basePath: 'http://localhost:9000/',
                basePath: window.location.hostname === 'localhost' 
                    ? 'http://localhost:9000/' 
                    : 'https://portafolio-digital-production.up.railway.app/',
                // Proyectos
                modalAbierto: false,
                modalMaximizado: false,
                editando: false,
                nuevaImagen: '',
                form: {
                    id_proyecto: null,
                    titulo: '',
                    tecnologias: '',
                    url_imagen: '',
                    url_github: '',
                    descripcion: '',
                    imagenes: []
                },
                
                // Experiencia
                listaExperiencia: [],
                formExperiencia: {
                    id_experiencia: null,
                    tipo: 'experiencia',
                    titulo: '',
                    institucion_empresa: '',
                    fecha_inicio: '',
                    fecha_fin: '',
                    descripcion: '',
                    actual: false,
                    orden: 1
                },
                editandoExperiencia: false,
                modalExperienciaInstancia: null,

                // Archivos
                listaArchivos: [],
                formArchivo: {
                    id_file: null,
                    nombre: '',
                    categoria: 'certificacion',
                    formato: 'pdf',
                    emisor: '',
                    fecha_emision: '',
                    url: '',
                    url_miniatura: ''
                },
                editandoArchivo: false,
                modalArchivoInstancia: null
            }
        },
        mounted() {
            const usuarioString = localStorage.getItem('usuario');
            if (usuarioString) {
                const usuario = JSON.parse(usuarioString);
                this.nombreUsuario = usuario.name;
            }
            this.cargarProyectos();
            this.cargarExperiencia();
            this.cargarArchivos();

            this.modalExperienciaInstancia = new bootstrap.Modal(document.getElementById('modalExperiencia'));
            this.modalArchivoInstancia = new bootstrap.Modal(document.getElementById('modalArchivo'));
        },
        methods: {
            // PROYECTOS
            async cargarProyectos() {
                try {
                    const response = await axios.get(this.basePath + 'proyectos.php');
                    if (response.data.success) {
                        this.listaProyectos = response.data.data;
                    }
                } catch (error) {
                    this.error = true;
                    this.msgError = 'No se pudieron cargar los proyectos desde el servidor.';
                    console.error(error);
                }
            },
            abrirModalCrear() {
                this.editando = false;
                this.form = { id_proyecto: null, titulo: '', tecnologias: '', url_imagen: '', url_github: '', descripcion: '', imagenes: [] };
                this.nuevaImagen = '';
                this.modalAbierto = true;
            },
            abrirModalEditar(proyecto) {
                this.editando = true;
                this.form = { ...proyecto, imagenes: [...(proyecto.imagenes || [])] };
                this.nuevaImagen = '';
                this.modalAbierto = true;
            },
            // GALERÍA DEL CARRUSEL
            agregarImagen() {
                const url = this.nuevaImagen.trim();
                if (!url) return;
                if (!this.form.imagenes.includes(url)) this.form.imagenes.push(url);
                this.nuevaImagen = '';
            },
            quitarImagen(i) {
                this.form.imagenes.splice(i, 1);
            },
            moverImagen(i, dir) {
                const j = i + dir;
                if (j < 0 || j >= this.form.imagenes.length) return;
                const lista = this.form.imagenes;
                [lista[i], lista[j]] = [lista[j], lista[i]];
            },
            // Convierte un link de Google Drive (".../file/d/ID/view") en uno que sí se puede usar en <img>
            urlImagenDirecta(url) {
                const match = url && url.match(/drive\.google\.com\/file\/d\/([^/]+)/);
                return match ? `https://drive.google.com/thumbnail?id=${match[1]}&sz=w800` : url;
            },
            cerrarModal() {
                this.modalAbierto = false;
                this.modalMaximizado = false;
            },
            async guardarProyecto() {
                // Si dejaste una URL escrita sin presionar "Agregar", también se guarda
                if (this.nuevaImagen.trim()) this.agregarImagen();
                try {
                    let response;
                    if (this.editando) {
                        response = await axios.put(this.basePath + 'proyectos.php', this.form);
                    } else {
                        response = await axios.post(this.basePath + 'proyectos.php', this.form);
                    }

                    if (response.data.success) {
                        this.cerrarModal();
                        this.cargarProyectos();
                        Swal.fire({
                            icon: 'success',
                            title: '¡Operación Exitosa!',
                            text: response.data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('Atención', response.data.message, 'warning');
                    }
                } catch (error) {
                    Swal.fire('Error', 'Surgió un inconveniente al procesar la solicitud.', 'error');
                }
            },
            async eliminarProyecto(id) {
                Swal.fire({
                    title: '¿Estás completamente seguro?',
                    text: "Esta acción eliminará permanentemente el proyecto.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#212529',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const response = await axios.delete(`${this.basePath}proyectos.php?id=${id}`);
                            if (response.data.success) {
                                this.cargarProyectos();
                                Swal.fire('¡Eliminado!', response.data.message, 'success');
                            } else {
                                Swal.fire('Error', response.data.message, 'error');
                            }
                        } catch (error) {
                            Swal.fire('Error', 'No se pudo completar la eliminación.', 'error');
                        }
                    }
                });
            },

            // EXPERIENCIA
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
            abrirModalExperiencia() {
                this.editandoExperiencia = false;
                this.formExperiencia = {
                    id_experiencia: null,
                    tipo: 'experiencia',
                    titulo: '',
                    institucion_empresa: '',
                    fecha_inicio: '',
                    fecha_fin: '',
                    descripcion: '',
                    actual: false,
                    orden: this.listaExperiencia.length + 1
                };
                this.modalExperienciaInstancia.show();
            },
            editarExperiencia(exp) {
                this.editandoExperiencia = true;
                this.formExperiencia = { ...exp }; 
                this.formExperiencia.actual = (exp.actual === true || exp.actual === 't' || exp.actual == 1);
                this.modalExperienciaInstancia.show();
            },
            async guardarExperiencia() {
                try {
                    const datosAEnviar = { ...this.formExperiencia };
                    if (datosAEnviar.actual) {
                        datosAEnviar.fecha_fin = null; 
                    }

                    let response;
                    if (this.editandoExperiencia) {
                        datosAEnviar._method = 'PUT';
                        response = await axios.post(this.basePath + 'experiencia.php', datosAEnviar);
                    } else {
                        response = await axios.post(this.basePath + 'experiencia.php', datosAEnviar);
                    }

                    if (response.data.success) {
                        Swal.fire('¡Éxito!', 'Registro guardado correctamente', 'success');
                        this.modalExperienciaInstancia.hide();
                        this.cargarExperiencia();
                    } else {
                        Swal.fire('Error', response.data.message || 'No se pudo guardar.', 'error');
                    }
                } catch (error) {
                    console.error('Error al guardar:', error);
                    Swal.fire('Error', 'Hubo un problema de conexión.', 'error');
                }
            },
            async eliminarExperiencia(id) {
                const confirmacion = await Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                });

                if (confirmacion.isConfirmed) {
                    try {
                        const response = await axios.post(this.basePath + 'experiencia.php', {
                            _method: 'DELETE',
                            id_experiencia: id
                        });

                        if (response.data.success) {
                            Swal.fire('¡Eliminado!', 'El registro ha sido borrado.', 'success');
                            this.cargarExperiencia();
                        } else {
                            Swal.fire('Error', response.data.message, 'error');
                        }
                    } catch (error) {
                        console.error('Error al eliminar:', error);
                        Swal.fire('Error', 'Hubo un problema al borrar el registro.', 'error');
                    }
                }
            },

            // ARCHIVOS Y CERTIFICACIONES
            async cargarArchivos() {
                try {
                    const response = await axios.get(this.basePath + 'files.php');
                    if (response.data.success) {
                        this.listaArchivos = response.data.data;
                    }
                } catch (error) {
                    console.error('Error al cargar archivos:', error);
                }
            },
            abrirModalArchivo() {
                this.editandoArchivo = false;
                this.formArchivo = {
                    id_file: null,
                    nombre: '',
                    categoria: 'certificacion',
                    formato: 'pdf',
                    emisor: '',
                    fecha_emision: '',
                    url: '',
                    url_miniatura: ''
                };
                this.modalArchivoInstancia.show();
            },
            editarArchivo(file) {
                this.editandoArchivo = true;
                this.formArchivo = { ...file };
                this.modalArchivoInstancia.show();
            },
            async guardarArchivo() {
                try {
                    let response;
                    if (this.editandoArchivo) {
                        response = await axios.put(this.basePath + 'files.php', this.formArchivo);
                    } else {
                        response = await axios.post(this.basePath + 'files.php', this.formArchivo);
                    }

                    if (response.data.success) {
                        Swal.fire('¡Éxito!', response.data.message, 'success');
                        this.modalArchivoInstancia.hide();
                        this.cargarArchivos();
                    } else {
                        Swal.fire('Atención', response.data.message, 'warning');
                    }
                } catch (error) {
                    console.error('Error al guardar archivo:', error);
                    Swal.fire('Error', 'No se pudo guardar el archivo.', 'error');
                }
            },
            async eliminarArchivo(id) {
                const confirmacion = await Swal.fire({
                    title: '¿Eliminar archivo?',
                    text: "Se eliminará el registro de la base de datos.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                });

                if (confirmacion.isConfirmed) {
                    try {
                        const response = await axios.delete(`${this.basePath}files.php?id=${id}`);
                        if (response.data.success) {
                            Swal.fire('¡Eliminado!', response.data.message, 'success');
                            this.cargarArchivos();
                        } else {
                            Swal.fire('Error', response.data.message, 'error');
                        }
                    } catch (error) {
                        console.error('Error al eliminar archivo:', error);
                        Swal.fire('Error', 'No se pudo eliminar el archivo.', 'error');
                    }
                }
            },

            // CERRAR SESIÓN
            logout() {
                localStorage.removeItem('usuario');
                this.$router.push('/');
            }
        }
    }
</script>

<style scoped>
    .nav-link.active {
        border-bottom: 3px solid #0d6efd !important;
        border-radius: 0;
    }
    .nav-link:focus {
        box-shadow: none;
    }
    .admin-panel {
        min-height: 100vh;
        background-color: #f4f6f9;
    }
    .main-navbar {
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .btn-add-project {
        background-color: #212529;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.2s ease;
    }
    .galeria-admin {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 12px;
    }
    .galeria-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        background: #f1f3f5;
        aspect-ratio: 16 / 10;
    }
    .galeria-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .galeria-num {
        position: absolute;
        top: 6px;
        left: 6px;
        background: rgba(33, 37, 41, 0.85);
        color: #fff;
        font-size: 0.75rem;
        border-radius: 4px;
        padding: 0 6px;
    }
    .galeria-acciones {
        position: absolute;
        bottom: 6px;
        right: 6px;
        display: flex;
        gap: 4px;
    }
    .galeria-acciones .btn {
        padding: 2px 6px;
        line-height: 1;
    }
    .btn-add-project:hover {
        background-color: #343a40;
        transform: translateY(-1px);
    }
    .custom-table-container {
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e9ecef;
    }
    .custom-table {
        width: 100%;
        border-collapse: separate;
    }
    .custom-table thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 16px 24px;
        border-bottom: 2px solid #edeff1;
    }
    .custom-table tbody tr:hover {
        background-color: #fdfdfd;
    }
    .custom-table tbody td, 
    .custom-table tbody th {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f3f5;
        color: #333c48;
    }
    .custom-badge {
        background-color: #eef2f6 !important;
        color: #495057 !important;
        font-weight: 500;
        font-size: 0.75rem;
        padding: 6px 10px;
        border-radius: 6px;
        border: 1px solid #dfe4ec;
    }
    .btn-action-edit {
        color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.05);
        border: 1px solid rgba(13, 110, 253, 0.1);
        border-radius: 6px;
        padding: 5px 14px;
        transition: all 0.2s ease;
    }
    .btn-action-edit:hover {
        background-color: #0d6efd;
        color: #fff;
    }
    .btn-action-delete {
        color: #dc3545;
        background-color: rgba(220, 53, 69, 0.05);
        border: 1px solid rgba(220, 53, 69, 0.1);
        border-radius: 6px;
        padding: 5px 14px;
        transition: all 0.2s ease;
    }
    .btn-action-delete:hover {
        background-color: #dc3545;
        color: #fff;
    }
    .form-control-custom {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px 14px;
    }
    .form-control-custom:focus {
        border-color: #212529;
        box-shadow: 0 0 0 0.25rem rgba(33, 37, 41, 0.1);
    }

    .btn-action-view {
        color: #6c757d;
        background-color: rgba(108, 117, 125, 0.05);
        border: 1px solid rgba(108, 117, 125, 0.2);
        border-radius: 6px;
        padding: 5px 14px;
        transition: all 0.2s ease;
    }

    .btn-action-view:hover {
        background-color: #6c757d;
        color: #fff;
    }
</style>