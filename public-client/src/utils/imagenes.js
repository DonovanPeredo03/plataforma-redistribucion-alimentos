import { BASE_URL } from '../services/api';

export const IMAGEN_PLACEHOLDER = '/placeholder.svg';

export const obtenerImagen = (ruta) => {
    if (!ruta || !ruta.trim()) {
        return IMAGEN_PLACEHOLDER;
    }

    if (ruta.startsWith('http://') || ruta.startsWith('https://')) {
        return ruta;
    }

    return `${BASE_URL}/${ruta.replace(/^\/+/, '')}`;
};

export const manejarErrorImagen = (evento) => {
    const imagen = evento.currentTarget;

    if (imagen.getAttribute('src') !== IMAGEN_PLACEHOLDER) {
        imagen.src = IMAGEN_PLACEHOLDER;
    }
};
