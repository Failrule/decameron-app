import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const endpoint = 'http://localhost:8000/api';

export const ShowHotels = () => {
  const [hotels, setHotels] = useState([]);

  useEffect(() => {
    getAllHotels();
  }, []);

  const getAllHotels = async () => {
    try {
      const response = await axios.get(`${endpoint}/hoteles`);
      setHotels(response.data.items);
    } catch (error) {
      console.error('Error fetching hotels:', error);
    }
  };

  const deleteHotel = async (id) => {
    try {
      await axios.delete(`${endpoint}/hotel/${id}`);
      getAllHotels();
    } catch (error) {
      console.error('Error deleting hotel:', error);
    }
  };

  return (
    <div>
      <div className='d-grid gap-2'>
        <Link to="/create" className='btn btn-success btn-lg m-2 text-white'>Crear</Link>
      </div>
      <table className='table table-striped'>
        <thead className='bg-primary text-white'>
          <tr>
            <th className='text-center'>Nombre</th>
            <th className='text-center'>Dirección</th>
            <th className='text-center'>Ciudad</th>
            <th className='text-center'>Habitaciones</th>
            <th className='text-center'>Acción</th>
          </tr>
        </thead>
        <tbody>
          {hotels.map((hotel) => (
            <tr key={hotel.id}>
              <td className='text-center'>{hotel.nombre}</td>
              <td className='text-center'>{hotel.direccion}</td>
              <td className='text-center'>{hotel.ciudad}</td>
              <td className='text-center'>{hotel.cant_habitaciones}</td>
              <td className='text-center'>
                <div className='d-flex justify-content-center'>
                  <Link to={`/ver/${hotel.id}`} className='btn btn-success m-1'>Ver</Link>
                  <Link to={`/edit/${hotel.id}`} className='btn btn-warning m-1'>Editar</Link>
                  <button onClick={() => deleteHotel(hotel.id)} className='btn btn-danger m-1'>Eliminar</button>
                </div>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};
