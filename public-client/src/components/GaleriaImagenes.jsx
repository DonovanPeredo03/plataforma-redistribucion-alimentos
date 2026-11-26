import { useState } from 'react';
import {
    obtenerImagen,
    manejarErrorImagen
} from '../utils/imagenes';

function GaleriaImagenes({ imagenes = [], nombre }) {
    const [indice, setIndice] = useState(0);

    const galeria = imagenes.length > 0
        ? imagenes
        : [null];

    return (
        <div className="detalle-galeria">

            <div className="galeria-principal">
                <img
                    src={obtenerImagen(galeria[indice])}
                    alt={nombre}
                    onError={manejarErrorImagen}
                    className="detalle-imagen"
                />
            </div>

            <div className="galeria-miniaturas">

                {galeria.map((imagen, posicion) => (
                    <button
                        key={posicion}
                        type="button"
                        className={`miniatura ${
                            indice === posicion
                                ? 'miniatura-activa'
                                : ''
                        }`}
                        onClick={() => setIndice(posicion)}
                        aria-label={`Ver imagen ${posicion + 1}`}
                        aria-pressed={indice === posicion}
                    >
                        <img
                            src={obtenerImagen(imagen)}
                            alt={`${nombre} - Imagen ${posicion + 1}`}
                            onError={manejarErrorImagen}
                        />
                    </button>
                ))}

            </div>

            <p className="galeria-contador">
                Imagen {indice + 1} de {galeria.length}
            </p>

        </div>
    );
}

export default GaleriaImagenes;
