
import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import {
  getRecursos,
  obtenerUrlImagen
} from '../services/api';
import { getUser, setFlash } from '../auth/session';
import { logout } from '../auth/authService';

import ResourceDetail from '../components/ResourceDetail';
import '../App.css';

function DashboardPage() {

  // ==========================================
  // SESIÓN (ACTIVIDAD 5.2)
  // ==========================================

  const navigate = useNavigate();
  const usuario = getUser();

  const cerrarSesion = async () => {
    await logout();
    setFlash('Sesión cerrada correctamente.');
    navigate('/login', { replace: true });
  };

  // ==========================================
  // ESTADOS PRINCIPALES
  // ==========================================

  const [recursos, setRecursos] = useState([]);
  const [cargando, setCargando] = useState(true);
  const [error, setError] = useState('');

  // CONTROL PARA REINTENTAR LA CONEXIÓN
  const [reintento, setReintento] = useState(0);

  // ==========================================
  // BÚSQUEDA Y FILTROS
  // ==========================================

  const [busqueda, setBusqueda] = useState('');
  const [categoriaSeleccionada, setCategoriaSeleccionada] =
    useState('Todas');

  // ==========================================
  // VENTANA DE DETALLES
  // ==========================================

  const [recursoSeleccionado, setRecursoSeleccionado] =
    useState(null);

  // ==========================================
  // CONSUMIR API DE LARAVEL
  // ==========================================

  useEffect(() => {

    let activo = true;

    const cargarRecursos = async () => {

      try {
        setCargando(true);
        setError('');

        const datos = await getRecursos();

        if (activo) {
          setRecursos(
            Array.isArray(datos) ? datos : []
          );
        }

      } catch (err) {

        console.error(
          'Error al obtener los recursos:',
          err
        );

        if (activo) {
          setRecursos([]);

          setError(
            err.mensajeUsuario ||
            'No se pudo obtener el catálogo de alimentos.'
          );
        }

      } finally {

        if (activo) {
          setCargando(false);
        }

      }
    };

    cargarRecursos();

    return () => {
      activo = false;
    };

  }, [reintento]);

  // ==========================================
  // REINTENTAR CONEXIÓN
  // ==========================================

  const reintentarConexion = () => {
    setReintento((anterior) => anterior + 1);
  };

  // ==========================================
  // ESTADÍSTICAS
  // ==========================================

  const totalRecursos = recursos.length;

  const disponibles = recursos.filter(
    (recurso) => recurso.estado === 'Disponible'
  ).length;

  const totalCategorias = new Set(
    recursos
      .map((recurso) => recurso.categoria)
      .filter(Boolean)
  ).size;

  // ==========================================
  // LISTA DE CATEGORÍAS
  // ==========================================

  const categorias = [
    ...new Set(
      recursos
        .map((recurso) => recurso.categoria)
        .filter(Boolean)
    )
  ].sort((a, b) => a.localeCompare(b));

  // ==========================================
  // NORMALIZAR TEXTO
  // ==========================================

  const normalizarTexto = (texto) => {
    return String(texto ?? '')
      .toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '');
  };

  // ==========================================
  // FILTRAR ALIMENTOS
  // ==========================================

  const recursosFiltrados = recursos.filter((alimento) => {

    const textoBusqueda = normalizarTexto(busqueda);

    const nombre = normalizarTexto(alimento.nombre);
    const descripcion = normalizarTexto(alimento.descripcion);
    const categoria = normalizarTexto(alimento.categoria);

    const coincideBusqueda =
      nombre.includes(textoBusqueda) ||
      descripcion.includes(textoBusqueda) ||
      categoria.includes(textoBusqueda);

    const coincideCategoria =
      categoriaSeleccionada === 'Todas' ||
      alimento.categoria === categoriaSeleccionada;

    return coincideBusqueda && coincideCategoria;
  });

  // ==========================================
  // LIMPIAR FILTROS
  // ==========================================

  const limpiarFiltros = () => {
    setBusqueda('');
    setCategoriaSeleccionada('Todas');
  };

  // ==========================================
  // ABRIR Y CERRAR DETALLES
  // ==========================================

  const abrirDetalle = (id) => {
    setRecursoSeleccionado(id);
  };

  const cerrarDetalle = () => {
    setRecursoSeleccionado(null);
  };

  // ==========================================
  // INTERFAZ
  // ==========================================

  return (

    <div className="dashboard">

      {/* MENÚ LATERAL */}

      <aside className="sidebar">

        <div className="logo">
          <span>🌱</span>
          <h2>FoodAdmin</h2>
        </div>

        <p className="menu-titulo">
          ADMINISTRACIÓN
        </p>

        <nav className="menu">

          <a href="#inicio" className="menu-activo">
            📊 Dashboard
          </a>

          <a href="#catalogo">
            📦 Catálogo de alimentos
          </a>

        </nav>

        <div className="sidebar-footer">

          <p>Actividad 5.2</p>

          <small>
            React + Laravel REST API
          </small>

        </div>

      </aside>

      {/* CONTENIDO PRINCIPAL */}

      <main className="contenido">

        {/* ENCABEZADO */}

        <header className="encabezado" id="inicio">

          <div>

            <h1>Panel Administrativo</h1>

            <p>
              Gestión y visualización del catálogo de alimentos
            </p>

          </div>

          <div className="encabezado-acciones">

            <div className="usuario-sesion">
              <span className="usuario-nombre">
                👤 {usuario?.nombre}
              </span>
              <small>
                {usuario?.rol} · {usuario?.correo}
              </small>
            </div>

            <div className="etiqueta-api">

              <span
                className={
                  cargando
                    ? 'punto-amarillo'
                    : error
                    ? 'punto-rojo'
                    : 'punto-verde'
                }
              ></span>

              {cargando
                ? 'Conectando...'
                : error
                ? 'API no disponible'
                : 'API RESTful'
              }

            </div>

            <button
              type="button"
              className="btn-logout"
              onClick={cerrarSesion}
            >
              🚪 Cerrar sesión
            </button>

          </div>

        </header>

        <div className="bienvenida" role="status">
  ¡Bienvenido, {usuario?.nombre}! Inicio de sesión exitoso.
</div>

        {/* ESTADÍSTICAS */}

        <section className="estadisticas">

          <div className="estadistica-card">

            <div className="estadistica-icono azul">
              📦
            </div>

            <div>
              <p>Total de alimentos</p>

              <h2>
                {cargando || error ? '—' : totalRecursos}
              </h2>
            </div>

          </div>

          <div className="estadistica-card">

            <div className="estadistica-icono verde">
              ✅
            </div>

            <div>
              <p>Alimentos disponibles</p>

              <h2>
                {cargando || error ? '—' : disponibles}
              </h2>
            </div>

          </div>

          <div className="estadistica-card">

            <div className="estadistica-icono naranja">
              🗂️
            </div>

            <div>
              <p>Categorías registradas</p>

              <h2>
                {cargando || error ? '—' : totalCategorias}
              </h2>
            </div>

          </div>

        </section>

        {/* CATÁLOGO */}

        <section className="catalogo-seccion" id="catalogo">

          <div className="seccion-encabezado">

            <div>

              <h2>Catálogo de alimentos</h2>

              <p>
                Productos registrados en la base de datos
              </p>

            </div>

          </div>

          {/* BUSCADOR Y FILTROS */}

          {!cargando && !error && recursos.length > 0 && (

            <>

              <div className="filtros">

                <div className="buscador">

                  <label htmlFor="buscar-alimento">
                    Buscar alimento
                  </label>

                  <input
                    id="buscar-alimento"
                    type="search"
                    placeholder="Buscar por nombre o descripción..."
                    value={busqueda}
                    onChange={(e) => setBusqueda(e.target.value)}
                  />

                </div>

                <div className="filtro-categoria">

                  <label htmlFor="filtro-categoria">
                    Categoría
                  </label>

                  <select
                    id="filtro-categoria"
                    value={categoriaSeleccionada}
                    onChange={(e) =>
                      setCategoriaSeleccionada(e.target.value)
                    }
                  >

                    <option value="Todas">
                      Todas las categorías
                    </option>

                    {categorias.map((categoria) => (

                      <option
                        key={categoria}
                        value={categoria}
                      >
                        {categoria}
                      </option>

                    ))}

                  </select>

                </div>

                <button
                  type="button"
                  className="btn-limpiar"
                  onClick={limpiarFiltros}
                >
                  Limpiar filtros
                </button>

              </div>

              <div className="resultado-cantidad">

                Mostrando{' '}

                <strong>
                  {recursosFiltrados.length}
                </strong>

                {' '}de{' '}

                <strong>
                  {totalRecursos}
                </strong>

                {' '}alimentos

              </div>

            </>

          )}

          {/* ESTADO DE CARGA */}

          {cargando && (

            <div className="mensaje" role="status">

              <div className="spinner"></div>

              <p>
                Cargando información desde Laravel...
              </p>

            </div>

          )}

          {/* ERROR DE CONEXIÓN */}

          {!cargando && error && (

            <div className="mensaje error" role="alert">

              <h3>⚠️ No se pudo cargar el catálogo</h3>

              <p>{error}</p>

              <button
                type="button"
                className="btn-restablecer"
                onClick={reintentarConexion}
              >
                🔄 Reintentar conexión
              </button>

            </div>

          )}

          {/* CATÁLOGO VACÍO */}

          {!cargando &&
            !error &&
            recursos.length === 0 && (

            <div className="mensaje">

              <h3>No hay alimentos registrados</h3>

              <p>
                Actualmente no existen recursos en el catálogo.
              </p>

            </div>

          )}

          {/* SIN RESULTADOS EN LOS FILTROS */}

          {!cargando &&
            !error &&
            recursos.length > 0 &&
            recursosFiltrados.length === 0 && (

            <div className="mensaje">

              <h3>🔎 No encontramos resultados</h3>

              <p>
                Intenta buscar otro alimento o seleccionar
                una categoría diferente.
              </p>

              <button
                type="button"
                className="btn-restablecer"
                onClick={limpiarFiltros}
              >
                Mostrar todos los alimentos
              </button>

            </div>

          )}

          {/* TARJETAS DE ALIMENTOS */}

          {!cargando &&
            !error &&
            recursosFiltrados.length > 0 && (

            <div className="catalogo-grid">

              {recursosFiltrados.map((alimento) => (

                <button
                  type="button"
                  className="alimento-card"
                  key={alimento.id_alimento}
                  onClick={() =>
                    abrirDetalle(alimento.id_alimento)
                  }
                  aria-label={`Ver detalles de ${alimento.nombre}`}
                >

                  <div className="alimento-imagen">

                    <img
                      src={
                        obtenerUrlImagen(alimento.ruta_imagen) ||
                        '/placeholder.svg'
                      }
                      alt={`Imagen de ${alimento.nombre}`}
                      loading="lazy"
                      onError={(evento) => {

                        evento.currentTarget.onerror = null;

                        evento.currentTarget.src =
                          '/placeholder.svg';

                      }}
                    />

                  </div>

                  <div className="alimento-info">

                    <span className="categoria">
                      {alimento.categoria}
                    </span>

                    <h3>
                      {alimento.nombre}
                    </h3>

                    <p className="alimento-descripcion">
                      {alimento.descripcion}
                    </p>

                    <div className="alimento-datos">

                      <span>

                        <strong>Cantidad:</strong>{' '}

                        {alimento.cantidad}{' '}
                        {alimento.unidad}

                      </span>

                      <span className="estado">
                        {alimento.estado}
                      </span>

                    </div>

                  </div>

                </button>

              ))}

            </div>

          )}

        </section>

        {/* PIE DE PÁGINA */}

        <footer className="footer">

          Actividad 5.2 - Autenticación con Token Sanctum

          <p>
            Frontend React | Backend Laravel
          </p>

        </footer>

      </main>

      {/* VENTANA DE DETALLES */}

      {recursoSeleccionado !== null && (

        <ResourceDetail
          id={recursoSeleccionado}
          onClose={cerrarDetalle}
        />

      )}

    </div>

  );
}

export default DashboardPage;