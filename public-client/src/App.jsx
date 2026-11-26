import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Navbar from './components/Navbar';
import Catalogo from './pages/Catalogo';
import DetalleAlimento from './pages/DetalleAlimento';
import Informacion from './pages/Informacion';
import './App.css';
import './Informacion.css';

function App() {
    return (
        <BrowserRouter>

            <Navbar />

            <Routes>
                <Route path="/" element={<Catalogo />} />

                <Route
                    path="/catalogo/:id"
                    element={<DetalleAlimento />}
                />

                <Route
                    path="/informacion"
                    element={<Informacion />}
                />
            </Routes>

            <footer className="footer">
                <h3>Alimenta+</h3>
                <p>Plataforma de redistribución de alimentos.</p>
                <p>© 2026 Alimenta+</p>
            </footer>

        </BrowserRouter>
    );
}

export default App;
