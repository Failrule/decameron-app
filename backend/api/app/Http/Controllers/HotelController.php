<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HotelController extends BaseCrudController
{
    // Define la clase del modelo
    protected $modelClass = Hotel::class;

    // Define las reglas de validación específicas para el modelo Hotel
    protected $rules = [
        'nombre' => 'required|unique:hotel',
        'direccion' => 'required|min:10',
        'ciudad' => 'required|unique:hotel',
        'nit' => [
            'required',
            'unique:hotel',
            'regex:/^[0-9]{9}-[0-9]{1}$/'
        ],
        'cant_habitaciones' => [
            'required',
            'integer',
            'max:42'
        ]
    ];

    protected $rulesPatch = [
        'nombre' => 'sometimes|unique:hotel',
        'direccion' => 'sometimes|min:10',
        'ciudad' => 'sometimes|unique:hotel',
        'nit' => [
            'sometimes',
            'unique:hotel',
            'regex:/^[0-9]{9}-[0-9]{1}$/'
        ],
        'cant_habitaciones' => [
            'sometimes',
            'integer',
            'max:42'
        ]
    ];

    // Define los mensajes de validación personalizados
    protected $customMessages = [
        'nombre.required' => 'El nombre del hotel es obligatorio.',
        'nombre.unique' => 'El nombre del hotel ya está en uso.',
        'direccion.required' => 'La dirección del hotel es obligatoria.',
        'direccion.min' => 'La dirección del hotel debe tener al menos 10 caracteres.',
        'ciudad.required' => 'La ciudad es obligatoria.',
        'ciudad.unique' => 'La ciudad ya está en uso.',
        'nit.required' => 'El NIT es obligatorio.',
        'nit.unique' => 'El NIT ya está en uso.',
        'nit.regex' => 'El NIT debe tener el formato correcto.',
        'cant_habitaciones.required' => 'La cantidad de habitaciones es obligatoria.',
        'cant_habitaciones.integer' => 'La cantidad de habitaciones debe ser un número entero.',
        'cant_habitaciones.max' => 'La cantidad de habitaciones no puede ser mayor a 42.',
    ];

    // Define reglas de validación para la creación de un nuevo registro
    protected function getCreateRules(Request $request): array
    {
        return $this->rules;
    }

    // Define reglas de validación para la actualización parcial de un registro
    protected function getUpdateRules(Request $request): array
    {
        return $this->rulesPatch;
    }

    public function updatePartial(Request $request, int $id): JsonResponse
    {
        //$fields = (new Hotel)->getFillable();
        $this->fields = (new Hotel)->getFillable();
        return parent::updatePartial($request,$id);
    }
}
