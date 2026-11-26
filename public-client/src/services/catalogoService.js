import api from './api';

// Obtener el catálogo general de alimentos
export const getCatalogoPublico = async () => {
    const respuesta = await api.get('catalogo');
    return respuesta.data.data;
};

// Obtener el detalle de un alimento por su ID
export const getDetalleRecurso = async (id) => {
    const respuesta = await api.get(`catalogo/${id}`);
    return respuesta.data.data;
};

// Obtener información pública y estadísticas
export const getInformacionSecciones = async () => {
    const respuesta = await api.get('informacion');
    return respuesta.data.data;
};
