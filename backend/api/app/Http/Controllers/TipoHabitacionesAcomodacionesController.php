<?php

namespace App\Http\Controllers;

use App\Models\TipoHabitacionesAcomodaciones;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class TipoHabitacionesAcomodacionesController extends BaseCrudController
{
    // Define la clase del modelo
    protected $modelClass = TipoHabitacionesAcomodaciones::class;

    // Define las reglas de validación específicas para el modelo TipoHabitacionesAcomodaciones
    protected $rules = [];
    protected $rulesPatch = [];

    // Define los mensajes de validación personalizados
    protected $customMessages = [
        'hotel_id.required' => 'El ID del hotel es obligatorio.',
        'hotel_id.exists' => 'El ID del hotel debe existir en la base de datos.',
        'tipo.required' => 'El tipo de habitación es obligatorio.',
        'tipo.string' => 'El tipo de habitación debe ser una cadena de texto.',
        'tipo.unique' => 'El tipo de habitación ya existe para este hotel.',
        'acomodacion.required' => 'La acomodación es obligatoria.',
        'acomodacion.string' => 'La acomodación debe ser una cadena de texto.',
        'acomodacion.unique' => 'La acomodación ya existe para este hotel.',
        'cantidad.required' => 'La cantidad es obligatoria.',
        'cantidad.integer' => 'La cantidad debe ser un número entero.',
        'cantidad.min' => 'La cantidad debe ser al menos 1.',
    ];

    // Define reglas de validación para la creación de un nuevo registro
    protected function getCreateRules(Request $request): array
    {
        return [
            'hotel_id' => 'required|exists:hotel,id',
            'tipo' => [
                'required',
                'string',
                Rule::unique('tipo_habitaciones_acomodaciones')
                    ->where(function ($query) use ($request) {
                        return $query->where('hotel_id', $request->hotel_id);
                    })
            ],
            'acomodacion' => [
                'required',
                'string',
                Rule::unique('tipo_habitaciones_acomodaciones')
                    ->where(function ($query) use ($request) {
                        return $query->where('hotel_id', $request->hotel_id);
                    })
            ],
            'cantidad' => 'required|integer|min:1',
        ];
    }

    // Método para definir reglas de validación para la actualización parcial de un registro
    protected function getUpdateRules(Request $request): array
    {
        return [
            'hotel_id' => 'sometimes|exists:hotel,id',
            'tipo' => [
                'sometimes',
                'string',
                Rule::unique('tipo_habitaciones_acomodaciones')
                    ->where(function ($query) use ($request) {
                        return $query->where('hotel_id', $request->hotel_id);
                    })
                    ->ignore($request->id) // Ignorar la validación en caso de actualización parcial del mismo registro
            ],
            'acomodacion' => [
                'sometimes',
                'string',
                Rule::unique('tipo_habitaciones_acomodaciones')
                    ->where(function ($query) use ($request) {
                        return $query->where('hotel_id', $request->hotel_id);
                    })
                    ->ignore($request->id) // Ignorar la validación en caso de actualización parcial del mismo registro
            ],
            'cantidad' => 'sometimes|integer|min:1',
        ];
    }

    public function updatePartial(Request $request, int $id): JsonResponse
    {
        $this->fields = (new TipoHabitacionesAcomodaciones)->getFillable();
        return parent::updatePartial($request, $id);
    }
}
