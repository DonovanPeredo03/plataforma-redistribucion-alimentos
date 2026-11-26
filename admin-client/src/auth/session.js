const TOKEN_KEY = 'admin_token';
const USER_KEY = 'admin_user';
const FLASH_KEY = 'auth_flash';

export const saveSession = (token, usuario) => {
  sessionStorage.setItem(TOKEN_KEY, token);
  sessionStorage.setItem(USER_KEY, JSON.stringify(usuario));
};

export const getToken = () => sessionStorage.getItem(TOKEN_KEY);

export const getUser = () => {
  try {
    return JSON.parse(sessionStorage.getItem(USER_KEY));
  } catch {
    return null;
  }
};

export const clearSession = () => {
  sessionStorage.removeItem(TOKEN_KEY);
  sessionStorage.removeItem(USER_KEY);
};

export const isAuthenticated = () => Boolean(getToken());

export const setFlash = (mensaje) =>
  sessionStorage.setItem(FLASH_KEY, mensaje);

export const popFlash = () => {
  const mensaje = sessionStorage.getItem(FLASH_KEY);
  sessionStorage.removeItem(FLASH_KEY);
  return mensaje;
};