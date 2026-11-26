import { useEffect, useState, useCallback } from 'react';
import { useParams, Link } from 'react-router-dom';
import { getDetalleRecurso } from '../services/catalogoService';
import GaleriaImagenes from '../components/GaleriaImagenes';
import Loading from '../components/Loading';
import MensajeEstado from '../components/MensajeEstado';

function DetalleAlimento() {
    const { id } = useParams();

    const [alimento, setAlimento] = useState(null);
    const [cargando, setCargando] = useState(true);
    const [error, setError] = useState(null);

    const cargarDetalle = useCallback(async () => {
        setCargando(true);
        setError(null);
        setAlimento(null);

        try {
            const datos = await getDetalleRecurso(id);
            setAlimento(datos);
        } catch (error) {
            setError(error);
        } finally {
            setCargando(false);
        }
    }, [id]);

    useEffect(() => {
        cargarDetalle();
        window.scrollTo(0, 0);
    }, [cargarDetalle]);

    const formatearFecha = (fecha) => {
        if (!fecha) return 'No disponible';

        const valor = fecha.slice(0, 10);
        const [anio, mes, dia] = valor.split('-');

        return `${dia}/${mes}/${anio}`;
    };

    if (cargando) {
        return (
            <main className="detalle-container">
                <Loading mensaje="Cargando detalles del alimento..." />
            </main>
        );
    }

    if (error || !alimento) {
        const codigo = error?.response?.status;

        return (
            <main className="detalle-container">

                <Link to="/" className="btn-volver">
                    ← Volver al catálogo
                </Link>

                <MensajeEstado
                    tipo={codigo === 404 ? 'noEncontrado' : 'servidor'}
                    titulo={
                        codigo === 404
                            ? 'Error 404 - Alimento no encontrado'
                            : codigo === 500
                            ? 'Error 500 - Error del servidor'
                            : 'No se pudo cargar el alimento'
                    }
                    mensaje={
                        codigo === 404
                            ? 'El alimento no existe o ya no está disponible.'
                            : 'No fue posible recuperar la información.'
                    }
                    onReintentar={
                        codigo !== 404 ? cargarDetalle : undefined
                    }
                />

            </main>
        );
    }

    return (
        <main className="detalle-container">

            <Link to="/" className="btn-volver">
                ← Volver al catálogo
            </Link>

            <section className="detalle-grid">

                <GaleriaImagenes
                    key={alimento.id_alimento}
                    imagenes={
                        alimento.galeria?.length > 0
                            ? alimento.galeria
                            : [alimento.ruta_imagen]
                    }
                    nombre={alimento.nombre}
                />

                <div className="detalle-informacion">

                    <span className="card-category">
                        {alimento.categoria}
                    </span>

                    <h1>{alimento.nombre}</h1>

                    <span className={`detalle-estado ${
                        alimento.estado === 'Disponible'
                            ? 'estado-disponible'
                            : 'estado-expirar'
                    }`}>
                        {alimento.estado}
                    </span>

                    <h2>Descripción</h2>

                    <p className="detalle-descripcion">
                        {alimento.descripcion || 'Sin descripción disponible.'}
                    </p>

                    <h2>Información del alimento</h2>

                    <div className="detalle-datos">

                        <div>
                            <strong>Identificador</strong>
                            <span>#{alimento.id_alimento}</span>
                        </div>

                        <div>
                            <strong>Categoría</strong>
                            <span>{alimento.categoria}</span>
                        </div>

                        <div>
                            <strong>Cantidad disponible</strong>
                            <span>
                                {alimento.cantidad} {alimento.unidad}
                            </span>
                        </div>

                        <div>
                            <strong>Estado</strong>
                            <span>{alimento.estado}</span>
                        </div>

                        <div>
                            <strong>Fecha de publicación</strong>
                            <span>
                                {formatearFecha(alimento.fecha_publicacion)}
                            </span>
                        </div>

                        <div>
                            <strong>Fecha de caducidad</strong>
                            <span>
                                {formatearFecha(alimento.fecha_caducidad)}
                            </span>
                        </div>

                    </div>

                </div>

            </section>

        </main>
    );
}

export default DetalleAlimento;
