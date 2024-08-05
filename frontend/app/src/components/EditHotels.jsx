import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useNavigate, useParams } from 'react-router-dom';

const endpoint = 'http://localhost:8000/api/hoteles';

export const EditHotels = () => {
  const [nombre, setNombre] = useState('');
  const [direccion, setDireccion] = useState('');
  const [ciudad, setCiudad] = useState('');
  const [nit, setNit] = useState('');
  const [cantHabitaciones, setCantHabitaciones] = useState('');
  const [error, setError] = useState('');
  const [editableFields, setEditableFields] = useState({});
  const navigate = useNavigate();
  const { id } = useParams();

  useEffect(() => {
    const getHotelById = async () => {
      try {
        const response = await axios.get(`${endpoint}/${id}`);
        const hotel = response.data.item;
        setNombre(hotel.nombre);
        setDireccion(hotel.direccion);
        setCiudad(hotel.ciudad);
        setNit(hotel.nit);
        setCantHabitaciones(hotel.cant_habitaciones);
      } catch (error) {
        console.error('Error fetching hotel data:', error);
      }
    };

    getHotelById();
  }, [id]);

  const handleEditClick = (field) => {
    setEditableFields((prev) => ({ ...prev, [field]: !prev[field] }));
  };

  const handleSubmit = async (event) => {
    event.preventDefault();

    const data = {};
    if (editableFields.nombre) data.nombre = nombre;
    if (editableFields.direccion) data.direccion = direccion;
    if (editableFields.ciudad) data.ciudad = ciudad;
    if (editableFields.nit) data.nit = nit;
    if (editableFields.cantHabitaciones) data.cant_habitaciones = cantHabitaciones;

    try {
      await axios.patch(`${endpoint}/${id}`, data);
      navigate('/');
    } catch (error) {
      if (error.response && error.response.status === 422) {
        const { message, errors } = error.response.data;
        let errorMessages = message;

        if (errors) {
          const errorList = Object.entries(errors)
            .map(([field, messages]) => messages.map((msg) => `${field}: ${msg}`))
            .flat()
            .join(' | ');

          errorMessages += ` | ${errorList}`;
        }
        setError(errorMessages);
        console.error('Validation errors:', errorMessages);
      } else {
        setError('Error al actualizar el hotel. Intenta nuevamente.');
        console.error('Error updating hotel:', error);
      }
    }
  };

  return (
    <div className='container mt-5'>
      <h2>Editar Hotel</h2>
      {error && <div className='alert alert-danger'>{error}</div>}
      <form onSubmit={handleSubmit}>
        <div className='mb-3'>
          <label htmlFor='nombre' className='form-label'>Nombre</label>
          <div className='d-flex'>
            <input
              type='text'
              id='nombre'
              className='form-control'
              value={nombre}
              onChange={(e) => setNombre(e.target.value)}
              readOnly={!editableFields.nombre}
              required
            />
            <button type='button' className='btn btn-secondary' onClick={() => handleEditClick('nombre')}>
              {editableFields.nombre ? 'Cancelar' : 'Editar'}
            </button>
          </div>
        </div>
        <div className='mb-3'>
          <label htmlFor='direccion' className='form-label'>Dirección</label>
          <div className='d-flex'>
            <input
              type='text'
              id='direccion'
              className='form-control'
              value={direccion}
              onChange={(e) => setDireccion(e.target.value)}
              readOnly={!editableFields.direccion}
              required
            />
            <button type='button' className='btn btn-secondary' onClick={() => handleEditClick('direccion')}>
              {editableFields.direccion ? 'Cancelar' : 'Editar'}
            </button>
          </div>
        </div>
        <div className='mb-3'>
          <label htmlFor='ciudad' className='form-label'>Ciudad</label>
          <div className='d-flex'>
            <input
              type='text'
              id='ciudad'
              className='form-control'
              value={ciudad}
              onChange={(e) => setCiudad(e.target.value)}
              readOnly={!editableFields.ciudad}
              required
            />
            <button type='button' className='btn btn-secondary' onClick={() => handleEditClick('ciudad')}>
              {editableFields.ciudad ? 'Cancelar' : 'Editar'}
            </button>
          </div>
        </div>
        <div className='mb-3'>
          <label htmlFor='nit' className='form-label'>NIT</label>
          <div className='d-flex'>
            <input
              type='text'
              id='nit'
              className='form-control'
              value={nit}
              onChange={(e) => setNit(e.target.value)}
              readOnly={!editableFields.nit}
              required
            />
            <button type='button' className='btn btn-secondary' onClick={() => handleEditClick('nit')}>
              {editableFields.nit ? 'Cancelar' : 'Editar'}
            </button>
          </div>
        </div>
        <div className='mb-3'>
          <label htmlFor='cantHabitaciones' className='form-label'>Cantidad de Habitaciones</label>
          <div className='d-flex'>
            <input
              type='number'
              id='cantHabitaciones'
              className='form-control'
              value={cantHabitaciones}
              onChange={(e) => setCantHabitaciones(e.target.value)}
              readOnly={!editableFields.cantHabitaciones}
              required
            />
            <button type='button' className='btn btn-secondary' onClick={() => handleEditClick('cantHabitaciones')}>
              {editableFields.cantHabitaciones ? 'Cancelar' : 'Editar'}
            </button>
          </div>
        </div>
        <button type='submit' className='btn btn-primary'>Actualizar Hotel</button>
      </form>
    </div>
  );
};
