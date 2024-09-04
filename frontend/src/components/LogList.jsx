import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';

function LogList() {
    const [logs, setLogs] = useState([]);

    useEffect(() => {
        fetch(`${process.env.REACT_APP_BACKEND_URL}/car-change-logs`)
            .then(response => response.json())
            .then(data => setLogs(data));
    }, []);

    return (
        <div>
            <h2>История изменений машин</h2>
            <table className='w-100'>
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Водитель</th>
                        <th>Старая машина</th>
                        <th>Новая машина</th>
                    </tr>
                </thead>
                <tbody>
                    {logs.map(log => (
                        <tr key={log.id}>
                            <td>{new Date(log.changeDate).toLocaleString()}</td>
                            <td>
                                <Link to={`/driver/${log.driver.id}`}>{log.driver.name}</Link>
                            </td>
                            <td>
                                {log.oldCar 
                                    ? <Link to={`/car/${log.oldCar.id}`}>{log.oldCar.brand} {log.oldCar.model}</Link>
                                    : 'Нет'}
                            </td>
                            <td>
                                {log.newCar 
                                    ? <Link to={`/car/${log.newCar.id}`}>{log.newCar.brand} {log.newCar.model}</Link>
                                    : 'Нет'}
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}

export default LogList;