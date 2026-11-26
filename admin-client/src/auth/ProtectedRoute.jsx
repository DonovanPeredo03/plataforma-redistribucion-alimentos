import { useEffect } from 'react';
import { Navigate, Outlet } from 'react-router-dom';
import { isAuthenticated } from './session';

// Guardia: sin token en la sesión => /login
export function ProtectedRoute() {

  // Si el navegador restaura la página desde caché (botón "atrás")
  // se vuelve a validar la sesión.
  useEffect(() => {
    const alMostrar = (evento) => {
      if (evento.persisted && !isAuthenticated()) {
        window.location.replace('/login');
      }
    };
    window.addEventListener('pageshow', alMostrar);
    return () => window.removeEventListener('pageshow', alMostrar);
  }, []);

  if (!isAuthenticated()) {
    return <Navigate to="/login" replace />;
  }

  return <Outlet />;
}

// Si ya hay sesión activa, /login redirige al dashboard
export function PublicOnlyRoute() {

  if (isAuthenticated()) {
    return <Navigate to="/dashboard" replace />;
  }

  return <Outlet />;
}
