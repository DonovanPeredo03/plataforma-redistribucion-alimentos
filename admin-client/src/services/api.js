
import axios from 'axios';
import { getToken, clearSession, setFlash } from '../auth/session';

// ==========================================
// CONFIGURACIÓN DE LA API DE LARAVEL
// ==========================================

const API_BASE_URL =
  'http://127.0.0.1:8000/api/v1/admin';

const SERVER_URL =
  'http://127.0.0.1:8000';

// ==========================================
// CONFIGURACIÓN DE AXIOS
// ==========================================

const api = axios.create({
  baseURL: API_BASE_URL,
  timeout: 10000,
  headers: {
    Accept: 'application/json',
  },
});

// ==========================================
// ACTIVIDAD 5.2 - INTERCEPTORES HTTP
// ==========================================

// Inyecta el Bearer Token en cada petición
api.interceptors.request.use((config) => {
  const token = getToken();
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// 401 / 403: limpia la sesión y redirige al login
api.interceptors.response.use(
  (response) => response,
  (error) => {
    const estado = error.response?.status;
    const url = error.config?.url ?? '';
    const esAuth = url.endsWith('/login') || url.endsWith('/logout');

    if ((estado === 401 || estado === 403) && !esAuth) {
      clearSession();
      setFlash(
        estado === 401
          ? 'Tu sesión expiró o el token no es válido. Inicia sesión nuevamente.'
          : 'No tienes permisos para acceder a este recurso. Inicia sesión con una cuenta autorizada.'
      );
      if (window.location.pathname !== '/login') {
        window.location.replace('/login');
      }
    }

    return Promise.reject(error);
  }
);

// ==========================================
// MANEJO CENTRALIZADO DE ERRORES HTTP
// ==========================================

const manejarError = (error) => {

  // Conservar errores ya procesados
  if (error.mensajeUsuario) {
    return error;
  }

  const estado = error.response?.status;

  let mensaje = '';

  // Error por tiempo de espera
  if (
    error.code === 'ECONNABORTED' ||
    error.code === 'ETIMEDOUT'
  ) {
    mensaje =
      'La petición tardó demasiado tiempo. Intenta nuevamente.';

  // Error de conexión o posible bloqueo CORS
  } else if (!error.response) {
    mensaje =
      'No se pudo establecer comunicación con Laravel. Revisa el servidor y la conexión.';

  // Error 404
  } else if (estado === 404) {
    mensaje =
      'El recurso solicitado no fue encontrado.';

  // Error 500
  } else if (estado >= 500) {
    mensaje =
      'Ocurrió un error interno en el servidor Laravel.';

  // Error 401
  } else if (estado === 401) {
    mensaje =
      'La solicitud requiere autenticación.';

  // Error 403
  } else if (estado === 403) {
    mensaje =
      'No tienes permisos para acceder a este recurso.';

  // Otros errores HTTP
  } else {
    mensaje =
      `La solicitud falló con el código HTTP ${estado}.`;
  }

  error.mensajeUsuario = mensaje;
  error.estadoHttp = estado ?? null;

  return error;
};

// ==========================================
// OBTENER TODOS LOS RECURSOS
// GET /api/v1/admin/recursos
// ==========================================

export const getRecursos = async () => {

  try {

    const response = await api.get('/recursos');

    if (
      response.status !== 200 ||
      response.data?.success !== true ||
      !Array.isArray(response.data?.data)
    ) {
      const error = new Error(
        'Respuesta inesperada de la API.'
      );

      error.mensajeUsuario =
        'Laravel devolvió una respuesta de catálogo no válida.';

      throw error;
    }

    return response.data.data;

  } catch (error) {

    throw manejarError(error);

  }

};

// ==========================================
// OBTENER UN RECURSO POR SU ID
// GET /api/v1/admin/recursos/{id}
// ==========================================

export const getRecursoById = async (id) => {

  try {

    const response = await api.get(
      `/recursos/${id}`
    );

    if (
      response.status !== 200 ||
      response.data?.success !== true ||
      !response.data?.data ||
      typeof response.data.data !== 'object' ||
      Array.isArray(response.data.data)
    ) {
      const error = new Error(
        'Respuesta inesperada de la API.'
      );

      error.mensajeUsuario =
        'Laravel devolvió información de recurso no válida.';

      throw error;
    }

    return response.data.data;

  } catch (error) {

    throw manejarError(error);

  }

};

// ==========================================
// OBTENER LA URL COMPLETA DE UNA IMAGEN
// ==========================================

export const obtenerUrlImagen = (ruta) => {

  if (!ruta) {
    return null;
  }

  // Si ya es una dirección completa
  if (
    ruta.startsWith('http://') ||
    ruta.startsWith('https://')
  ) {
    return ruta;
  }

  // Construir la dirección desde Laravel
  return `${SERVER_URL}/${ruta.replace(/^\/+/, '')}`;

};

export default api;