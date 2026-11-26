import { NavLink } from 'react-router-dom';

function Navbar() {
    return (
        <header className="navbar">
            <div className="navbar-container">

                <NavLink to="/" className="navbar-brand">
                    <span className="brand-icon">🌱</span>

                    <div>
                        <strong>Alimenta+</strong>
                        <small>Redistribución de alimentos</small>
                    </div>
                </NavLink>

                <nav className="navbar-links">
                    <NavLink to="/" end>
                        Inicio
                    </NavLink>

                    <NavLink to="/informacion">
                        Información
                    </NavLink>
                </nav>

                <span className="public-label">
                    Acceso público
                </span>

            </div>
        </header>
    );
}

export default Navbar;
