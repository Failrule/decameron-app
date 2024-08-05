import React, { useState  } from 'react'
import { useNavigate } from 'react-router-dom';
import axios from 'axios';

const endpoint = 'http://localhost:8000/api/hoteles'; 

export const CreateHotels = () => {

  const [nombre, setNombre] = useState('');
  const [direccion, setDireccion] = useState('');
  const [ciudad, setCiudad] = useState('');
  const [nit, setNit] = useState('');
  const [cantHabitaciones, setCantHabitaciones] = useState('');
  const [error, setError] = useState('');
  const navigate = useNavigate();

  const handleSubmit = async (event) => {
    event.preventDefault();

    const data = {
      nombre,
      direccion,
      ciudad,
      nit,
      cant_habitaciones: cantHabitaciones
    };

    try {
      await axios.patch(endpoint, data);
      navigate('/');
    } catch (error) {
      if (error.response && error.response.status === 422) {
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
        setError('Error al crear el hotel. Intenta nuevamente.');
        console.error('Error creating hotel:', error);
      }
    }

  };

    return (
      <div className='container mt-5'>
            <h2>Crear Hotel</h2>
            {error && <div className='alert alert-danger'>{error}</div>}
            <form onSubmit={handleSubmit}>
              <div className='mb-3'>
                <label htmlFor='nombre' className='form-label'>Nombre</label>
                <input
                  type='text'
                  id='nombre'
                  className='form-control'
                  value={nombre}
                  onChange={(e) => setNombre(e.target.value)}
                  required
                />
              </div>
              <div className='mb-3'>
                <label htmlFor='direccion' className='form-label'>Dirección</label>
                <input
                  type='text'
                  id='direccion'
                  className='form-control'
                  value={direccion}
                  onChange={(e) => setDireccion(e.target.value)}
                  required
                />
              </div>
              <div className='mb-3'>
                <label htmlFor='ciudad' className='form-label'>Ciudad</label>
                <input
                  type='text'
                  id='ciudad'
                  className='form-control'
                  value={ciudad}
                  onChange={(e) => setCiudad(e.target.value)}
                  required
                />
              </div>
              <div className='mb-3'>
                <label htmlFor='nit' className='form-label'>NIT</label>
                <input
                  type='text'
                  id='nit'
                  className='form-control'
                  value={nit}
                  onChange={(e) => setNit(e.target.value)}
                  required
                />
              </div>
              <div className='mb-3'>
                <label htmlFor='cantHabitaciones' className='form-label'>Cantidad de Habitaciones</label>
                <input
                  type='number'
                  id='cantHabitaciones'
                  className='form-control'
                  value={cantHabitaciones}
                  onChange={(e) => setCantHabitaciones(e.target.value)}
                  required
                />
              </div>
              <button type='submit' className='btn btn-primary'>Crear Hotel</button>
            </form>
          </div>
    )
}
