import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';

function CarList() {
    const [cars, setCars] = useState([]);

    useEffect(() => {
        fetch(`${process.env.REACT_APP_BACKEND_URL}/car/list`)
            .then(response => response.json())
            .then(data => setCars(data))
            .catch(error => console.error('Error:', error))
    }, []);

    return (
        <div className="d-flex align-items-center flex-column">
            <div className="mb-4 d-flex align-items-center">
                <h1 className="">Список машин</h1>
                <Link to="/car/create" className="ms-4 btn btn-secondary">+</Link>
            </div>
            <div className="list-group row">
                {cars.map(car => (
                    <Link
                        to={`/car/${car.id}`}
                        key={car.id}
                        className="list-group-item list-group-item-action"
                    >
                        <div className="d-flex w-100 justify-content-between">
                            <h5 className="mb-1">{car.brand} {car.model}</h5>
                            <small>{car.licensePlate}</small>
                        </div>
                    </Link>
                ))}
            </div>
        </div>
    );
}

export default CarList;