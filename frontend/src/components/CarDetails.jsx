import React, { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';

function CarDetails() {
    const [car, setCar] = useState(null);
    const { id } = useParams();

    useEffect(() => {
        fetch(`${process.env.REACT_APP_BACKEND_URL}/car/${id}`)
            .then(response => response.json())
            .then(data => setCar(data))
            .catch(error => console.error('Error:', error));
    }, [id]);

    if (!car) return <div>Загрузка...</div>;

    return (
        <div>
            <h1 className="mb-4">Информация о машине</h1>
            <div className="card">
                <div className="card-body">
                    <h5 className="card-title">{car.brand} {car.model}</h5>
                    <p className="card-text">Номер: {car.licensePlate}</p>
                    {car.drivers && car.drivers.length > 0 ? (
                        <div>
                            <h6 className="card-subtitle mb-2 text-muted">Водители</h6>
                                {car.drivers.map(driver => (
                                    <p key={driver.id} className="card-text">
                                        <Link to={`/driver/${driver.id}`}>{driver.name}</Link>
                                    </p>
                                ))}
                        </div>
                    ) : (
                        <p className="card-text">У машины нет назначенных водителей</p>
                    )}
                </div>
            </div>
            <Link to="/car/list" className="btn btn-primary mt-3">Назад к списку</Link>
            <Link to={`/car/${car.id}/edit`} className="btn btn-warning mt-3 ms-3">Редактировать</Link>
        </div>
    );
}

export default CarDetails;