import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';

const endpoint = 'http://localhost:8000/api';

export const CreateTypeAcc = () => {
  const [typesAcc, setTypesAcc] = useState([]);
  const { id } = useParams();
  const navigate = useNavigate();
  const [tipo, setTipo] = useState('');
  const [acomodacion, setAcomodacion] = useState('');
  const [cantidad, setCantidad] = useState('');
  const [error, setError] = useState('');

  const data = {
    tipo,
    acomodacion,
    cantidad,
    hotel_id: id
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    try {
      console.log(data);
      await axios.post(`${endpoint}/tipo_habitaciones_acomodaciones/${id}`, data);
      navigate(`/typesacc/${id}`);
    } catch (error) {
      if (error.response && (error.response.status === 422 || error.response.status === 409 || error.response.status === 100 )) {
        // Manejo del error 422
        const { message, errors } = error.response.data;
        let errorMessages = message;

        if (errors) {
          // Combina todos los mensajes de error específicos
          const errorList = Object.entries(errors)
            .map(([field, messages]) => messages.map(msg => `${field}: ${msg}`))
            .flat()
            .join(' | ');

          errorMessages += ` | ${errorList}`;
        }

        setError(errorMessages);
        console.error('Validation errors:', errorMessages);
      } else {
        // Manejo de otros errores
        setError('Error al crear el registro. Intenta nuevamente.');
        console.error('Error creating hotel:', error);
      }
    }
  };

  return (
    <div className='container mt-5'>
      <h2>Crear Tipo de Habitación y Acomodación</h2>
      {error && <div className='alert alert-danger'>{error}</div>}
      <form onSubmit={handleSubmit}>
        <div className='mb-3'>
          <label htmlFor='tipo' className='form-label'>Tipo</label>
          <input
            type='text'
            className='form-control'
            id='tipo'
            value={tipo}
            onChange={(e) => setTipo(e.target.value)}
            required
          />
        </div>
        <div className='mb-3'>
          <label htmlFor='acomodacion' className='form-label'>Acomodación</label>
          <input
            type='text'
            className='form-control'
            id='acomodacion'
            value={acomodacion}
            onChange={(e) => setAcomodacion(e.target.value)}
            required
          />
        </div>
        <div className='mb-3'>
          <label htmlFor='cantidad' className='form-label'>Cantidad</label>
          <input
            type='number'
            className='form-control'
            id='cantidad'
            value={cantidad}
            onChange={(e) => setCantidad(e.target.value)}
            required
          />
        </div>
        <button type='submit' className='btn btn-primary'>Crear</button>
      </form>
    </div>
  );
};
