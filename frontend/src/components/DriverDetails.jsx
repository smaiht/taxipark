import React, { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';

function DriverDetails() {
    const [driver, setDriver] = useState(null);
    const { id } = useParams();

    useEffect(() => {
        fetch(`${process.env.REACT_APP_BACKEND_URL}/driver/${id}`)
            .then(response => response.json())
            .then(data => setDriver(data))
            .catch(error => console.error('Error:', error))
    }, [id]);

    if (!driver) return <div>Загрузка...</div>;

    return (
        <div>
            <h1 className="mb-4">Информация о водителе</h1>
            <div className="card">
                <div className="card-body">
                    <h5 className="card-title">{driver.name}</h5>
                    <p className="card-text">Дата рождения: {driver.birthday} ({driver.age} лет)</p>
                    {driver.car ? (
                        <div>
                            <h6 className="card-subtitle mb-2 text-muted">
                                <Link to={`/car/${driver.car.id}`}>Информация о машине</Link>
                            </h6>
                            <p className="card-text">Марка: {driver.car.brand}</p>
                            <p className="card-text">Модель: {driver.car.model}</p>
                            <p className="card-text">Номер: {driver.car.licensePlate}</p>
                        </div>
                    ) : (
                        <p className="card-text">У водителя нет назначенной машины</p>
                    )}
                </div>
            </div>
            <Link to="/" className="btn btn-primary mt-3">Назад к списку</Link>
            <Link to={`/driver/${driver.id}/edit`} className="btn btn-warning mt-3 ms-3">Редактировать</Link>
        </div>
    );
}

export default DriverDetails;