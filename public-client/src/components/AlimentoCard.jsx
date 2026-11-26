import { Link } from 'react-router-dom';
import { obtenerImagen, manejarErrorImagen } from '../utils/imagenes';

function AlimentoCard({ alimento }) {
    return (
        <article className="alimento-card">

            <div className="card-image-container">
                <img
                    src={obtenerImagen(alimento.ruta_imagen)}
                    alt={alimento.nombre}
                    onError={manejarErrorImagen}
                    className="card-image"
                    loading="lazy"
                />

                <span className={`estado-badge ${
                    alimento.estado === 'Disponible'
                        ? 'estado-disponible'
                        : 'estado-expirar'
                }`}>
                    {alimento.estado}
                </span>
            </div>

            <div className="card-content">

                <span className="card-category">
                    {alimento.categoria}
                </span>

                <h3>{alimento.nombre}</h3>

                <p className="card-description">
                    {alimento.descripcion || 'Sin descripción disponible.'}
                </p>

                <div className="card-quantity">
                    <strong>Cantidad disponible:</strong>
                    <span>
                        {alimento.cantidad} {alimento.unidad}
                    </span>
                </div>

                <Link
                    to={`/catalogo/${alimento.id_alimento}`}
                    className="btn-detalle"
                >
                    Ver detalles →
                </Link>

            </div>

        </article>
    );
}

export default AlimentoCard;
