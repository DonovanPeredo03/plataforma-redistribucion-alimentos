function MensajeEstado({
    tipo = 'vacio',
    titulo,
    mensaje,
    onReintentar
}) {
    const iconos = {
        vacio: '📦',
        error: '⚠️',
        noEncontrado: '🔍',
        servidor: '🔌'
    };

    return (
        <div className={`mensaje-estado mensaje-${tipo}`}>

            <span className="mensaje-icono">
                {iconos[tipo] || iconos.error}
            </span>

            <h2>{titulo}</h2>

            <p>{mensaje}</p>

            {onReintentar && (
                <button
                    className="btn-reintentar"
                    onClick={onReintentar}
                >
                    Volver a intentar
                </button>
            )}

        </div>
    );
}

export default MensajeEstado;
