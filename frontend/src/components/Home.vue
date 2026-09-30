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
                    </ul>
                    
                    <button class="btn btn-outline-danger btn-sm" @click="cerrarSesion()">
                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                    </button>
                </div>
            </div>
        </nav>
        
        <div class="container mt-4 pt-2">
            <div v-if="vistaActiva === 'proyectos'" class="animate__animated animate__fadeIn">
                <!-- PROYECTOS CONTENT -->
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
                                        <th scope="col" class="text-end" style="width: 200px;">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="proyecto in listaProyectos" :key="proyecto.id_proyecto">
                                        <td class="text-muted font-monospace small">#{{ proyecto.id_proyecto }}</td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ proyecto.titulo }}</div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <span 
                                                    v-for="(tech, index) in proyecto.tecnologias.split(',')" 
                                                    :key="index" 
                                                    class="badge custom-badge"
                                                >
                                                    {{ tech.trim() }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-action-edit btn-sm me-2 fw-medium" @click="abrirModalEditar(proyecto)">
                                                Editar
                                            </button>
                                            <button class="btn btn-action-delete btn-sm fw-medium" @click="eliminarProyecto(proyecto.id_proyecto)">
                                                Eliminar
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
            
            <div v-if="vistaActiva === 'experiencia'" class="animate__animated animate__fadeIn">
                <!-- EXPERIENCIA CONTENT -->
                <div class="mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="fw-bold"><i class="bi bi-briefcase"></i> Gestionar Experiencia y Educación</h3>
                        <button class="btn btn-primary" @click="abrirModalExperiencia()">
                            <i class="bi bi-plus-circle"></i> Nuevo Registro
                        </button>
                    </div>
                    
                    <div class="table-responsive shadow-sm rounded">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Orden</th>
                                    <th>Tipo</th>
                                    <th>Título</th>
                                    <th>Empresa / Institución</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="exp in listaExperiencia" :key="exp.id_experiencia">
                                    <td><span class="badge text-bg-secondary">{{ exp.orden }}</span></td>
                                    <td>
                                        <span class="badge" :class="exp.tipo === 'experiencia' ? 'text-bg-primary' : 'text-bg-success'">
                                            {{ exp.tipo.toUpperCase() }}
                                        </span>
                                    </td>
                                    <td class="fw-bold">{{ exp.titulo }}</td>
                                    <td>{{ exp.institucion_empresa }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning me-2" @click="editarExperiencia(exp)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" @click="eliminarExperiencia(exp.id_experiencia)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="listaExperiencia.length === 0">
                                    <td colspan="5" class="text-center py-4 text-muted">No hay registros de experiencia.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- PROYECTOS MODAL -->
        <div class="modal fade" :class="{ 'show d-block': modalAbierto }" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-dark text-white border-0 py-3">
                        <h5 class="modal-title fw-bold">{{ editando ? 'Editar Proyecto' : 'Nuevo Proyecto' }}</h5>
                        <button type="button" class="btn-close btn-close-white" @click="cerrarModal"></button>
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
                                <label class="form-label small fw-bold text-secondary">URL de la Imagen (Opcional)</label>
                                <input v-model="form.url_imagen" type="url" class="form-control form-control-custom" placeholder="https://ejemplo.com/foto.jpg">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Enlace de GitHub (Opcional)</label>
                                <input v-model="form.url_github" type="url" class="form-control form-control-custom" placeholder="https://github.com/tu-usuario/repositorio">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Descripción</label>
                                <textarea v-model="form.descripcion" class="form-control form-control-custom" rows="3" placeholder="Describe brevemente el alcance del proyecto..."></textarea>
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
                basePath: 'http://localhost:9000/',
                //Proyectos
                modalAbierto: false,
                editando: false,
                form: {
                    id_proyecto: null,
                    titulo: '',
                    tecnologias: '',
                    url_imagen: '',
                    url_github: '',
                    descripcion: ''
                },
                //Experiencia
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
                modalExperienciaInstancia: null
            }
        },
        mounted() {
            // Cuando el componente carga, leemos el nombre del localStorage
            const usuarioString = localStorage.getItem('usuario');
            if (usuarioString) {
                const usuario = JSON.parse(usuarioString);
                this.nombreUsuario = usuario.name; // Tomamos el 'name_complete' que mandó PHP
            }
            this.cargarProyectos();

            this.cargarExperiencia();
            this.modalExperienciaInstancia = new bootstrap.Modal(document.getElementById('modalExperiencia'));
        },
        methods: {
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
                this.form = { id_proyecto: null, titulo: '', tecnologias: '', url_imagen: '', url_github: '', descripcion: '' };
                this.modalAbierto = true;
            },
            abrirModalEditar(proyecto) {
                this.editando = true;
                this.form = { ...proyecto };
                this.modalAbierto = true;
            },
            cerrarModal() {
                this.modalAbierto = false;
            },
            async guardarProyecto() {
                try {
                    debugger;
                    let response;
                    if (this.editando) {
                        // Si estamos editando mandamos petición por PUT
                        response = await axios.put(this.basePath + 'proyectos.php', this.form);
                    } else {
                        // Si es nuevo mandamos petición por POST
                        response = await axios.post(this.basePath + 'proyectos.php', this.form);
                    }

                    if (response.data.success) {
                        this.cerrarModal();
                        this.cargarProyectos();
                        
                        // Alerta refinada con SweetAlert2
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
                // Ventana de confirmación nativa de SweetAlert2
                Swal.fire({
                    title: '¿Estás completamente seguro?',
                    text: "Esta acción eliminará permanentemente el proyecto de la base de datos.",
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
                    orden: this.listaExperiencia.length + 1 // Sugerir el siguiente número
                };
                this.modalExperienciaInstancia.show();
            },
            editarExperiencia(exp) {
                this.editandoExperiencia = true;
                // Clonamos el objeto para no editar directamente la tabla hasta guardar
                this.formExperiencia = { ...exp }; 
                // Convertir el valor "actual" de la BD (puede venir como 't'/'f', 1/0, o boolean) a booleano real
                this.formExperiencia.actual = (exp.actual === true || exp.actual === 't' || exp.actual == 1);
                
                this.modalExperienciaInstancia.show();
            },
            async guardarExperiencia() {
                try {
                    // Formateamos los datos antes de enviarlos
                    
                    const datosAEnviar = { ...this.formExperiencia };
                    // Si es "actual", limpiamos la fecha de fin para evitar errores en la BD
                    if (datosAEnviar.actual) {
                        datosAEnviar.fecha_fin = null; 
                    }

                    let response;
                    if (this.editandoExperiencia) {
                        // Si estamos editando, simulamos un PUT enviando el _method
                        datosAEnviar._method = 'PUT';
                        response = await axios.post(this.basePath + 'experiencia.php', datosAEnviar);
                    } else {
                    // Si es nuevo, hacemos un POST normal
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
                        // Enviamos la petición DELETE simulada mediante POST
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
            logout() {
                localStorage.removeItem('usuario');
                this.$router.push('/');
            }
        }
    }
</script>

<style scoped>
    .nav-link.active {
        border-bottom: 3px solid #0d6efd !important; /* Una pequeña línea azul abajo del botón activo */
        border-radius: 0;
    }
    .nav-link:focus {
        box-shadow: none; /* Elimina el molesto recuadro azul de enfoque de Bootstrap en los botones */
    }
    .admin-panel {
        min-height: 100vh;
        background-color: #f4f6f9;
    }
    .main-navbar {
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .tracking-wider {
        letter-spacing: 0.05em;
    }
    .btn-logout {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.2);
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    .btn-logout:hover {
        background-color: #dc3545;
        color: #fff;
    }
    .btn-add-project {
        background-color: #212529;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.2s ease;
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

    /* Estilos de campos del modal */
    .form-control-custom {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px 14px;
    }
    .form-control-custom:focus {
        border-color: #212529;
        box-shadow: 0 0 0 0.25rem rgba(33, 37, 41, 0.1);
    }
</style>