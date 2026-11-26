import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { login } from '../auth/authService';
import { popFlash } from '../auth/session';

function LoginPage() {

  const navigate = useNavigate();

  const [correo, setCorreo] = useState('');
  const [contrasena, setContrasena] = useState('');
  const [error, setError] = useState('');
  const [cargando, setCargando] = useState(false);

  // Mensaje informativo (sesión expirada, logout, sin permisos...)
  const [info] = useState(() => popFlash());

  const enviarFormulario = async (evento) => {

    evento.preventDefault();
    setError('');
    setCargando(true);

    try {

      await login(correo, contrasena);
      navigate('/dashboard', { replace: true });

    } catch (err) {

      const datos = err.response?.data;

      if (datos?.errors) {
        setError(Object.values(datos.errors).flat().join(' '));
      } else if (datos?.message) {
        setError(datos.message);
      } else {
        setError(
          'No se pudo establecer comunicación con Laravel. Revisa el servidor.'
        );
      }

    } finally {
      setCargando(false);
    }
  };

  return (

    <main className="login-fondo">

      <section className="login-tarjeta">

        <div className="login-logo">
          <span>🌱</span>
          <h1>FoodAdmin</h1>
        </div>

        <p className="login-subtitulo">
          Inicia sesión para acceder al panel administrativo
        </p>

        {info && (
          <div className="login-aviso info" role="status">
            {info}
          </div>
        )}

        {error && (
          <div className="login-aviso error" role="alert">
            {error}
          </div>
        )}

        <form onSubmit={enviarFormulario} className="login-form">

          <label htmlFor="correo">Correo electrónico</label>
          <input
            id="correo"
            type="email"
            required
            autoComplete="username"
            placeholder="admin@correo.com"
            value={correo}
            onChange={(e) => setCorreo(e.target.value)}
          />

          <label htmlFor="contrasena">Contraseña</label>
          <input
            id="contrasena"
            type="password"
            required
            autoComplete="current-password"
            placeholder="••••••••"
            value={contrasena}
            onChange={(e) => setContrasena(e.target.value)}
          />

          <button type="submit" disabled={cargando}>
            {cargando ? 'Entrando...' : 'Iniciar sesión'}
          </button>

        </form>

      </section>

    </main>
  );
}

export default LoginPage;
