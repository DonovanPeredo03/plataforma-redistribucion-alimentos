function Loading({ mensaje = 'Cargando información...' }) {
    return (
        <div className="loading-container" role="status">
            <div className="spinner"></div>
            <h3>{mensaje}</h3>
            <p>Estamos consultando la información.</p>
        </div>
    );
}

export default Loading;
