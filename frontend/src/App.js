
import './App.scss';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import React from 'react';
import { BrowserRouter as Router } from "react-router-dom";

import Header from "./components/Header";
import { NavRoutes } from "./routes/NavRoutes";

function App() {
    return (
        <Router>
            <div className="App">
                <Header />
                <NavRoutes />
            </div>
        </Router>
    );
}



export default App;