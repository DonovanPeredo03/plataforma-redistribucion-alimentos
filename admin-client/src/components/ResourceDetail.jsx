
import { useEffect, useRef, useState } from 'react';

import {
  getRecursoById,
  obtenerUrlImagen
} from '../services/api';

function ResourceDetail({ id, onClose }) {

  // ==========================================
  // ESTADOS DEL COMPONENTE
  // ==========================================

  const [recurso, setRecurso] = useState(null);
  const [cargando, setCargando] = useState(true);
  const [error, setError] = useState('');

  // CONTROL PARA REINTENTAR LA CONSULTA
  const [reintento, setReintento] = useState(0);

  const botonCerrarRef = useRef(null);

  // ==========================================
  // CONSULTAR DETALLES DESDE LARAVEL
  // ==========================================

  useEffect(() => {

    let activo = true;

    const cargarDetalle = async () => {

      try {

        setCargando(true);
        setError('');
        setRecurso(null);

        const datos = await getRecursoById(id);

        if (activo) {
          setRecurso(datos);
        }

      } catch (err) {

        console.error(
          'Error al consultar el recurso:',
          err
        );

        if (activo) {

          setError(
            err.mensajeUsuario ||
            'No se pudo obtener la información del alimento.'
          );

        }

      } finally {

        if (activo) {
          setCargando(false);
        }

      }

    };

    cargarDetalle();

    return () => {
      activo = false;
    };

  }, [id, reintento]);

  // ==========================================
  // CERRAR CON LA TECLA ESCAPE
  // ==========================================

  useEffect(() => {

    const manejarTecla = (evento) => {

      if (evento.key === 'Escape') {
        onClose();
      }

    };

    window.addEventListener(
      'keydown',
      manejarTecla
    );

    return () => {

      window.removeEventListener(
        'keydown',
        manejarTecla
      );

    };

  }, [onClose]);

  // ==========================================
  // ENFOCAR EL BOTÓN CERRAR
  // ==========================================

  useEffect(() => {

    botonCerrarRef.current?.focus();

  }, []);

  // ==========================================
  // REINTENTAR CONSULTA
  // ==========================================

  const reintentarConsulta = () => {

    setReintento(
      (anterior) => anterior + 1
    );

  };

  // ==========================================
  // INTERFAZ DE DETALLES
  // ==========================================

  return (

    <div
      className="detalle-fondo"
      onClick={onClose}
    >

      <section
        className="detalle-panel"
        role="dialog"
        aria-modal="true"
        aria-label="Detalle del alimento"
        onClick={(evento) =>
          evento.stopPropagation()
        }
      >

        {/* BOTÓN CERRAR */}

        <button
          ref={botonCerrarRef}
          type="button"
          className="detalle-cerrar"
          onClick={onClose}
        >
          ✕ Cerrar
        </button>

        {/* ESTADO DE CARGA */}

        {cargando && (

          <div
            className="mensaje"
            role="status"
          >

            <div className="spinner"></div>

            <p>
              Cargando detalles del alimento...
            </p>

          </div>

        )}

        {/* ERROR DE CONSULTA */}

        {!cargando && error && (

          <div
            className="mensaje error"
            role="alert"
          >

            <h3>
              ⚠️ Error al cargar el alimento
            </h3>

            <p>{error}</p>

            <button
              type="button"
              className="btn-restablecer"
              onClick={reintentarConsulta}
            >
              🔄 Reintentar consulta
            </button>

          </div>

        )}

        {/* INFORMACIÓN COMPLETA */}

        {!cargando && !error && recurso && (

          <div className="detalle-contenido">

            {/* IMAGEN */}

            <div className="detalle-imagen">

              <img
                src={
                  obtenerUrlImagen(recurso.ruta_imagen) ||
                  '/placeholder.svg'
                }

                alt={`Fotografía de ${recurso.nombre}`}

                onError={(evento) => {

                  evento.currentTarget.onerror = null;

                  evento.currentTarget.src =
                    '/placeholder.svg';

                }}
              />

            </div>

            {/* DATOS DEL ALIMENTO */}

            <div className="detalle-informacion">

              <span className="categoria">
                {recurso.categoria}
              </span>

              <h2>
                {recurso.nombre}
              </h2>

              <p className="detalle-descripcion">
                {recurso.descripcion || 'Sin descripción.'}
              </p>

              <div className="detalle-datos">

                <div>
                  <strong>ID del alimento:</strong>
                  <span>{recurso.id_alimento}</span>
                </div>

                <div>
                  <strong>ID del usuario:</strong>
                  <span>{recurso.id_usuario}</span>
                </div>

                <div>
                  <strong>Categoría:</strong>
                  <span>{recurso.categoria}</span>
                </div>

                <div>
                  <strong>Cantidad disponible:</strong>

                  <span>
                    {recurso.cantidad} {recurso.unidad}
                  </span>
                </div>

                <div>
                  <strong>Estado:</strong>
                  <span>{recurso.estado}</span>
                </div>

                <div>
                  <strong>Fecha de publicación:</strong>

                  <span>
                    {recurso.fecha_publicacion ||
                      'No registrada'}
                  </span>
                </div>

                <div>
                  <strong>Fecha de caducidad:</strong>

                  <span>
                    {recurso.fecha_caducidad ||
                      'No registrada'}
                  </span>
                </div>

              </div>

            </div>

          </div>

        )}

      </section>

    </div>

  );
}

export default ResourceDetail;
