import React, { useState, useEffect } from 'react';
import { useParams, useNavigate, Link } from 'react-router-dom';

function CarEdit() {
    const [car, setCar] = useState({
        licensePlate: '',
        brand: '',
        model: '',
        drivers: [],
    });

    const [drivers, setDrivers] = useState([]);
    const { id } = useParams();
    const navigate = useNavigate();

    useEffect(() => {
        if (id) {
            fetch(`${process.env.REACT_APP_BACKEND_URL}/car/${id}`)
                .then(response => response.json())
                .then(data => setCar(data))
                .catch(error => console.error('Error:', error));
        }

        fetch(`${process.env.REACT_APP_BACKEND_URL}/driver/list`)
            .then(response => response.json())
            .then(data => setDrivers(data))
            .catch(error => console.error('Error:', error));
    }, [id]);

    const handleChange = (event) => {
        const { name, value } = event.target;
        setCar(prevCar => ({
            ...prevCar,
            [name]: value,
        }));
    };

    const handleDriverChange = (event) => {
        const { options } = event.target;
        const selectedDrivers = Array.from(options)
            .filter(option => option.selected)
            .map(option => drivers.find(driver => driver.id === parseInt(option.value)));

        setCar(prevCar => ({
            ...prevCar,
            drivers: selectedDrivers,
        }));
    };

    const handleSubmit = (event) => {
        event.preventDefault()
        const url = id ? `${process.env.REACT_APP_BACKEND_URL}/car/${id}/do-edit` : `${process.env.REACT_APP_BACKEND_URL}/car/do-create`

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                licensePlate: car.licensePlate,
                brand: car.brand,
                model: car.model,
                drivers: car.drivers.map(driver => ({ id: driver.id })),
            }),
        })
            .then(response => response.json())
            .then(data => {
                navigate(`/car/${data.id}`);
            })
            .catch(error => console.error('Error:', error));
    };

    return (
        <div className="d-flex flex-column align-items-center">
            <h1 className="mb-4">{id ? 'Редактировать машину' : 'Создать машину'}</h1>
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label htmlFor="licensePlate" className="form-label">Номер</label>
                    <input type="text" className="form-control" id="licensePlate" name="licensePlate" value={car.licensePlate} onChange={handleChange} required />
                </div>
                <div className="mb-3">
                    <label htmlFor="brand" className="form-label">Марка</label>
                    <input type="text" className="form-control" id="brand" name="brand" value={car.brand} onChange={handleChange} required />
                </div>
                <div className="mb-3">
                    <label htmlFor="model" className="form-label">Модель</label>
                    <input type="text" className="form-control" id="model" name="model" value={car.model} onChange={handleChange} required />
                </div>
                <div className="mb-3">
                    <label htmlFor="drivers" className="form-label">Водители</label>
                    <select className="form-select" id="drivers" name="drivers" multiple value={car.drivers.map(driver => driver.id)} onChange={handleDriverChange}>
                        {drivers.map(driver => (
                            <option key={driver.id} value={driver.id}>{driver.name}</option>
                        ))}
                    </select>
                </div>
                <button type="submit" className="btn btn-primary">Сохранить</button>
                <Link to={id ? `/car/${id}` : '/'} className="btn btn-secondary ms-2">Отмена</Link>
            </form>
        </div>
    );
}

export default CarEdit;