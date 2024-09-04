import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';

function DriverList() {
    const [drivers, setDrivers] = useState([]);

    useEffect(() => {
        fetch(`${process.env.REACT_APP_BACKEND_URL}/driver/list`)
            .then(response => response.json())
            .then(data => setDrivers(data))
            .catch(error => console.error('Error:', error));
    }, []);

    return (
        <div className="d-flex align-items-center flex-column">
            <div className="mb-4 d-flex align-items-center">
                <h1 className="">Список водителей</h1>
                <Link to="/driver/create" className="ms-4 btn btn-secondary">+</Link>
            </div>
            <div className="list-group row ">
                {drivers.map(driver => (
                    <Link
                        to={`/driver/${driver.id}`}
                        key={driver.id}
                        className="list-group-item list-group-item-action"
                    >
                        <div className="d-flex w-100 justify-content-between">
                            <h5 className="mb-1">{driver.name}</h5>
                            <small>{driver.birthday}</small>
                        </div>
                        <p className="mb-1">
                            {driver.car
                                ? `${driver.car.brand} ${driver.car.model} (${driver.car.licensePlate})`
                                : 'Нет назначенной машины'}
                        </p>
                    </Link>
                ))}
            </div>
        </div>
    );
}

export default DriverList;