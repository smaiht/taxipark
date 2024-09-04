import React from "react";

import { Route, Routes } from "react-router-dom";

import DriverList from "../components/DriverList";
import DriverDetails from "../components/DriverDetails";
import DriverEdit from "../components/DriverEdit";

import CarList from "../components/CarList";
import CarDetails from "../components/CarDetails";
import CarEdit from "../components/CarEdit";

import LogList from "../components/LogList";

export const NavRoutes = () => {
    return (
        <Routes>
            <Route path="/" element={<DriverList />} />
            <Route path="/logs" element={<LogList />} />

            <Route path="/car/list" element={<CarList />} />
            <Route path="/car/:id" element={<CarDetails />} />
            <Route path="/car/:id/edit" element={<CarEdit />} />
            <Route path="/car/create" element={<CarEdit />} />

            <Route path="/driver/list" element={<DriverList />} />
            <Route path="/driver/:id" element={<DriverDetails />} />
            <Route path="/driver/:id/edit" element={<DriverEdit />} />
            <Route path="/driver/create" element={<DriverEdit />} />
        </Routes>
    );
};
