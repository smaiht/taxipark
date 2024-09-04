
import React from 'react';
import { Link } from 'react-router-dom';
import logo from '../assets/images/evoy-logo.png';

function Header() {
    return (
        <header className="App-header">
            <nav className="navbar navbar-expand-lg navbar-dark w-100">
                <div className="container d-flex justify-content-between w-100">
                    <Link className="navbar-brand me-5" to="/">
                        <img src={logo} className="App-logo" alt="logo" />
                        <p>
                            taxipark
                        </p>
                    </Link>

                    <button
                        className="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarNav"
                        aria-controls="navbarNav"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span className="navbar-toggler-icon"></span>
                    </button>

                    <div className="collapse navbar-collapse" id="navbarNav">
                        <ul className="navbar-nav d-flex justify-content-between w-100">
                            <li className="nav-item">
                                <Link className="nav-link text-light" to="/driver/list">Водители</Link>
                            </li>
                            <li className="nav-item">
                                <Link className="nav-link text-light" to="/car/list">Машины</Link>
                            </li>
                            <li className="nav-item">
                                <Link className="nav-link text-light" to="/logs">Логи</Link>
                            </li>
                        </ul>
                    </div>

                </div>
            </nav>
        </header>
    );
}

export default Header;