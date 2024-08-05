import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams, Link } from 'react-router-dom';

const endpoint = 'http://localhost:8000/api';

export const ShowRoomTypesAcc = () => {
  const { id } = useParams();
  const [typesAcc, setTypesAcc] = useState([]);
  const [hotelId, setHotelId] = useState(null);

  useEffect(() => {
    getAllTypesAcc();
  }, []);

  const getAllTypesAcc = async () => {
    try {
      const response = await axios.get(`${endpoint}/tipo_habitaciones_acomodaciones/${id}`);
      setTypesAcc(response.data.childItems);
      setHotelId(response.data.parentItem.id);
    } catch (error) {
      console.error('Error fetching room types accommodations:', error);
    }
  };

  const deleteTypeAcc = async (id) => {
    try {
      await axios.delete(`${endpoint}/tipo_habitaciones_acomodaciones/${id}`);
      getAllTypesAcc();
    } catch (error) {
      console.error('Error deleting room types accommodations:', error);
    }
  };

  return (
    <div className='container mt-5'>
      <div className='d-flex justify-content-between align-items-center mb-3'>
        <h2>Tipos de Habitaciones y Acomodaciones</h2>
        <Link to={`/createtipeacc/${hotelId}`} className='btn btn-success btn-lg text-white'>Crear</Link>
      </div>
      <table className='table table-striped'>
        <thead className='bg-primary text-white'>
          <tr>
            <th className='text-center'>Tipo</th>
            <th className='text-center'>Acomodación</th>
            <th className='text-center'>Cantidad</th>
            <th className='text-center'>Acción</th>
          </tr>
        </thead>
        <tbody>
          {typesAcc.map((typeAcc) => (
            <tr key={typeAcc.id}>
              <td className='text-center'>{typeAcc.tipo}</td>
              <td className='text-center'>{typeAcc.acomodacion}</td>
              <td className='text-center'>{typeAcc.cantidad}</td>
              <td className='text-center'>
                <div className='d-flex justify-content-center'>
                  {/* <Link to={`/editTypeAcc/${hotelId}`} className='btn btn-warning m-1'>Editar</Link> */}
                  <button onClick={() => deleteTypeAcc(typeAcc.id)} className='btn btn-danger m-1'>Eliminar</button>
                </div>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};
