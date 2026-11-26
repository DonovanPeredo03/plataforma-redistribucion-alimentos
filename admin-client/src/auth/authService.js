import api from '../services/api';
import { saveSession, clearSession } from './session';

// POST /api/v1/admin/login
// Respuesta: { data: { administrador, token, tipo } }
export const login = async (correo, contrasena) => {

  const { data } = await api.post('/login', { correo, contrasena });

  const { token, administrador } = data.data;

  saveSession(token, {
    nombre: administrador.nombre,
    correo: administrador.correo,
    rol: administrador.perfil, // el backend lo llama "perfil"
  });

  return administrador;
};

// POST /api/v1/admin/logout  (revoca el token en la BD de Laravel)
export const logout = async () => {

  try {
    await api.post('/logout'); // el interceptor adjunta el Bearer
  } catch (error) {
    // Aunque falle (token ya revocado), se limpia la sesión local.
    console.warn('Logout en API no completado:', error.message);
  } finally {
    clearSession();
  }
};
