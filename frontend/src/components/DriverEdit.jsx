import React, { useState, useEffect } from 'react';
import { useParams, useNavigate, Link } from 'react-router-dom';

function DriverEdit() {
    const [driver, setDriver] = useState({
        name: '',
        birthday: '',
        car: null,
    })

    const [cars, setCars] = useState([])
    const { id } = useParams()
    const navigate = useNavigate()

    useEffect(() => {
        if (id) {
            fetch(`${process.env.REACT_APP_BACKEND_URL}/driver/${id}`)
                .then(response => response.json())
                .then(data => setDriver(data))
                .catch(error => console.error('Error:', error))
        }

        fetch(`${process.env.REACT_APP_BACKEND_URL}/car/list`)
            .then(response => response.json())
            .then(data => setCars(data))
            .catch(error => console.error('Error:', error))
    }, [id])

    const handleChange = (event) => {
        const { name, value } = event.target
        
        if (name === 'car') {
            const selectedCar = cars.find(car => car.id === parseInt(value))

            setDriver(prevDriver => ({
                ...prevDriver,
                car: selectedCar || null,
            }))

        } else {
            setDriver(prevDriver => ({
                ...prevDriver,
                [name]: value,
            }))
        }
    }

    const handleSubmit = (event) => {
        event.preventDefault()
        const url = id ? `${process.env.REACT_APP_BACKEND_URL}/driver/${id}/do-edit` : `${process.env.REACT_APP_BACKEND_URL}/driver/do-create`

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                name: driver.name,
                birthday: driver.birthday,
                car: driver.car ? { id: driver.car.id } : null,
            }),
        })
            .then(response => response.json())
            .then(data => {
                navigate(`/driver/${data.id}`)
            })
            .catch(error => console.error('Error:', error))
    };

    return (
        <div className="d-flex flex-column align-items-center">
            <h1 className="mb-4">{id ? 'Редактировать водителя' : 'Создать водителя'}</h1>
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label htmlFor="name" className="form-label">Имя</label>
                    <input type="text" className="form-control" id="name" name="name" value={driver.name} onChange={handleChange} required />
                </div>
                <div className="mb-3">
                    <label htmlFor="birthday" className="form-label">Дата рождения</label>
                    <input type="date" className="form-control" id="birthday" name="birthday" value={driver.birthday} onChange={handleChange} required />
                </div>
                <div className="mb-3">
                    <label htmlFor="car" className="form-label">Машина</label>
                    <select className="form-select" id="car" name="car" value={driver.car?.id || ''} onChange={handleChange}>
                        <option value="">Не назначена</option>
                        {cars.map(car => (
                            <option key={car.id} value={car.id}>{car.brand} {car.model} ({car.licensePlate})</option>
                        ))}
                    </select>
                </div>
                <button type="submit" className="btn btn-primary">Сохранить</button>
                <Link to={id ? `/driver/${id}` : '/'} className="btn btn-secondary ms-2">Отмена</Link>
            </form>
        </div>
    );
}

export default DriverEdit;