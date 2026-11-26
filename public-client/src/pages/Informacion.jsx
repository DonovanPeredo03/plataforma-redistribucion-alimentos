import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { getInformacionSecciones } from '../services/catalogoService';
import Loading from '../components/Loading';
import MensajeEstado from '../components/MensajeEstado';

function Informacion() {
    const [datos, setDatos] = useState(null);
    const [cargando, setCargando] = useState(true);
    const [error, setError] = useState(null);

    const cargarInformacion = async () => {
        setCargando(true);
        setError(null);

        try {
            const respuesta = await getInformacionSecciones();
            setDatos(respuesta);
        } catch (error) {
            setError(error);
        } finally {
            setCargando(false);
        }
    };

    useEffect(() => {
        cargarInformacion();
    }, []);

    return (
        <main className="informacion-container">

            <section className="informacion-hero">
                <span>🌱 Nuestro propósito</span>

                <h1>Sobre Alimenta+</h1>

                <p>
                    Somos una plataforma dedicada a la redistribución
                    de alimentos, promoviendo el aprovechamiento de
                    recursos y la reducción del desperdicio alimentario.
                </p>
            </section>

            <section className="estadisticas-section">

                <div className="section-header">
                    <h2>Nuestra plataforma en cifras</h2>
                    <p>
                        Información actualizada directamente
                        desde nuestro catálogo.
                    </p>
                </div>

                {cargando ? (
                    <Loading mensaje="Cargando estadísticas..." />
                ) : error ? (
                    <MensajeEstado
                        tipo="servidor"
                        titulo={
                            error.response?.status === 500
                                ? 'Error 500 - Error del servidor'
                                : error.response?.status === 404
                                ? 'Error 404 - Información no encontrada'
                                : 'No se pudo cargar la información'
                        }
                        mensaje="Intenta nuevamente para consultar las estadísticas."
                        onReintentar={cargarInformacion}
                    />
                ) : datos ? (
                    <>
                        <div className="estadisticas-grid">

                            <article className="estadistica-card">
                                <span>📦</span>
                                <h3>{datos.total_alimentos}</h3>
                                <p>Alimentos en catálogo</p>
                            </article>

                            <article className="estadistica-card">
                                <span>📋</span>
                                <h3>{datos.total_categorias}</h3>
                                <p>Categorías activas</p>
                            </article>

                            <article className="estadistica-card">
                                <span>✅</span>
                                <h3>{datos.disponibles}</h3>
                                <p>Alimentos disponibles</p>
                            </article>

                            <article className="estadistica-card">
                                <span>⏳</span>
                                <h3>{datos.por_expirar}</h3>
                                <p>Alimentos por expirar</p>
                            </article>

                        </div>

                        <section className="categorias-section">

                            <h2>Categorías activas</h2>

                            {datos.categorias.length === 0 ? (
                                <MensajeEstado
                                    tipo="vacio"
                                    titulo="No hay categorías disponibles"
                                    mensaje="Actualmente no existen alimentos en el catálogo público."
                                />
                            ) : (
                                <div className="categorias-grid">

                                    {datos.categorias.map(categoria => (
                                        <article
                                            className="categoria-card"
                                            key={categoria.nombre}
                                        >
                                            <h3>{categoria.nombre}</h3>

                                            <p>
                                                {categoria.total} alimentos
                                            </p>

                                            <div className="categoria-barra">
                                                <div
                                                    className="categoria-progreso"
                                                    style={{
                                                        width: `${
                                                            datos.total_alimentos > 0
                                                                ? categoria.total /
                                                                  datos.total_alimentos * 100
                                                                : 0
                                                        }%`
                                                    }}
                                                />
                                            </div>
                                        </article>
                                    ))}

                                </div>
                            )}

                        </section>
                    </>
                ) : (
                    <MensajeEstado
                        tipo="vacio"
                        titulo="Información no disponible"
                        mensaje="No hay estadísticas para mostrar."
                    />
                )}

            </section>

            <section className="mision-section">

                <h2>Nuestra misión</h2>

                <p>
                    Facilitar el acceso a los alimentos disponibles,
                    fomentar su aprovechamiento y contribuir a una
                    comunidad más responsable y sostenible.
                </p>

                <Link to="/" className="btn-detalle">
                    Explorar catálogo
                </Link>

            </section>

        </main>
    );
}

export default Informacion;
