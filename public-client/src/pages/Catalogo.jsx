import { useEffect, useState } from 'react';
import { getCatalogoPublico } from '../services/catalogoService';
import AlimentoCard from '../components/AlimentoCard';
import Loading from '../components/Loading';
import MensajeEstado from '../components/MensajeEstado';

function Catalogo() {
    const [alimentos, setAlimentos] = useState([]);
    const [cargando, setCargando] = useState(true);
    const [error, setError] = useState(null);
    const [busqueda, setBusqueda] = useState('');
    const [categoria, setCategoria] = useState('Todas');

    const cargarCatalogo = async () => {
        setCargando(true);
        setError(null);

        try {
            const datos = await getCatalogoPublico();
            setAlimentos(datos);
        } catch (error) {
            setError(error);
        } finally {
            setCargando(false);
        }
    };

    useEffect(() => {
        cargarCatalogo();
    }, []);

    const categorias = [
        'Todas',
        ...new Set(alimentos.map(alimento => alimento.categoria))
    ];

    const alimentosFiltrados = alimentos.filter(alimento => {
        const coincideNombre = alimento.nombre
            .toLowerCase()
            .includes(busqueda.toLowerCase().trim());

        const coincideCategoria =
            categoria === 'Todas' ||
            alimento.categoria === categoria;

        return coincideNombre && coincideCategoria;
    });

    return (
        <main>

            <section className="hero">
                <div className="hero-content">

                    <span className="hero-label">
                        Alimentación sostenible
                    </span>

                    <h1>
                        Alimentos que merecen otra oportunidad
                    </h1>

                    <p>
                        Explora nuestro catálogo de alimentos disponibles
                        y contribuye a reducir el desperdicio alimentario.
                    </p>

                    <a href="#catalogo" className="btn-hero">
                        Explorar catálogo
                    </a>

                </div>
            </section>

            <section className="catalogo-container" id="catalogo">

                <div className="section-header">
                    <h2>Catálogo de alimentos</h2>
                    <p>
                        Descubre los alimentos disponibles en nuestra plataforma.
                    </p>
                </div>

                {cargando ? (
                    <Loading mensaje="Cargando alimentos..." />
                ) : error ? (
                    <MensajeEstado
                        tipo="servidor"
                        titulo={
                            error.response?.status === 500
                                ? 'Error 500 - Error del servidor'
                                : error.response?.status === 404
                                ? 'Error 404 - Catálogo no encontrado'
                                : 'No se pudo cargar el catálogo'
                        }
                        mensaje="No fue posible recuperar la información. Intenta nuevamente."
                        onReintentar={cargarCatalogo}
                    />
                ) : alimentos.length === 0 ? (
                    <MensajeEstado
                        tipo="vacio"
                        titulo="No hay alimentos disponibles"
                        mensaje="No hay productos disponibles en este momento."
                        onReintentar={cargarCatalogo}
                    />
                ) : (
                    <>
                        <div className="catalogo-filtros">

                            <input
                                type="search"
                                placeholder="Buscar alimento..."
                                aria-label="Buscar alimento"
                                value={busqueda}
                                onChange={e => setBusqueda(e.target.value)}
                            />

                            <select
                                aria-label="Filtrar por categoría"
                                value={categoria}
                                onChange={e => setCategoria(e.target.value)}
                            >
                                {categorias.map(item => (
                                    <option key={item} value={item}>
                                        {item}
                                    </option>
                                ))}
                            </select>

                        </div>

                        <p className="resultados-count">
                            Mostrando {alimentosFiltrados.length} de {' '}
                            {alimentos.length} alimentos
                        </p>

                        {alimentosFiltrados.length === 0 ? (
                            <MensajeEstado
                                tipo="noEncontrado"
                                titulo="Sin resultados"
                                mensaje="No encontramos alimentos que coincidan con tu búsqueda."
                            />
                        ) : (
                            <div className="catalogo-grid">
                                {alimentosFiltrados.map(alimento => (
                                    <AlimentoCard
                                        key={alimento.id_alimento}
                                        alimento={alimento}
                                    />
                                ))}
                            </div>
                        )}
                    </>
                )}

            </section>

        </main>
    );
}

export default Catalogo;
