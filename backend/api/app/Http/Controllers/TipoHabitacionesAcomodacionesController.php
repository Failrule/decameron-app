<?php

namespace App\Http\Controllers;

use App\Models\TipoHabitacionesAcomodaciones;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class TipoHabitacionesAcomodacionesController extends BaseCrudController
{
    protected $modelClass = TipoHabitacionesAcomodaciones::class;

    protected $rules = [
        'hotel_id' => 'required|exists:hotel,id',
        'tipo' => 'required|string|max:255',
        'acomodacion' => 'required|string|max:255',
        'cantidad' => 'required|integer|min:1',
    ];

    protected $rulesPatch = [
        'hotel_id' => 'sometimes|exists:hotel,id',
        'tipo' => 'sometimes|string|max:255',
        'acomodacion' => 'sometimes|string|max:255',
        'cantidad' => 'sometimes|integer|min:1',
    ];

    protected $customMessages = [
        'hotel_id.required' => 'El ID del hotel es obligatorio.',
        'hotel_id.exists' => 'El hotel especificado no existe.',
        'tipo.required' => 'El tipo de habitación es obligatorio.',
        'tipo.string' => 'El tipo de habitación debe ser una cadena de texto.',
        'tipo.max' => 'El tipo de habitación no puede exceder los 255 caracteres.',
        'acomodacion.required' => 'La acomodación es obligatoria.',
        'acomodacion.string' => 'La acomodación debe ser una cadena de texto.',
        'acomodacion.max' => 'La acomodación no puede exceder los 255 caracteres.',
        'cantidad.required' => 'La cantidad de habitaciones es obligatoria.',
        'cantidad.integer' => 'La cantidad de habitaciones debe ser un número entero.',
        'cantidad.min' => 'La cantidad de habitaciones debe ser al menos 1.',
    ];

    public function storeTypeAcc(Request $request, int $id): JsonResponse
    {
        try {
            if ($request->has('cantidad') && $this->checkMaxQtyHotelRooms($id, $request->cantidad, 0)) {
                return response()->json([
                    'message' => 'El total de las cantidades de tipo de habitación supera el máximo de habitaciones del hotel.',
                    'status' => 400
                ], 400);
            }
            return parent::store($request);
        } catch (QueryException $e) {
            if ($e->getCode() === '23505') {
                return response()->json([
                    'message' => 'El '. class_basename($this->modelClass) . ' ya está registrados para este hotel',
                    'status' => 409
                ], 409);
            }
            return response()->json([
                'message' => 'Error al crear ' . class_basename($this->modelClass),
                'status' => 500
            ], 500);
        }
    }

    public function updatePartial(Request $request, int $id): JsonResponse
    {
        $model = $this->modelClass::find($id);
        //$this->fields = (new TipoHabitacionesAcomodaciones)->getFillable();
        $cantidadActual = TipoHabitacionesAcomodaciones::where('id', $id)->value('cantidad');
        if ($request->has('cantidad') && $this->checkMaxQtyHotelRooms($model->hotel_id, $request->cantidad, $cantidadActual)) {
            return response()->json([
                'message' => 'El total de las cantidades de tipo de habitación supera el máximo de habitaciones del hotel.',
                'status' => 400
            ], 400);
        }

        try {
            return parent::updatePartial($request, $id);
        } catch (QueryException $e) {
            if ($e->getCode() === '23505') {
                return response()->json([
                    'message' => 'El '. class_basename($this->modelClass) . ' ya está registrados para este hotel',
                    'status' => 409
                ], 409);
            }
            return response()->json([
                'message' => 'Error al crear ' . class_basename($this->modelClass),
                'status' => 500
            ], 500);
        }
    }

    public function showBelongs(int $id): JsonResponse
    {
        $this->parentItem = Hotel::find($id);
        $this->foreignKey = 'hotel_id';
        return parent::showBelongs($id);
    }


    /**
     * Verifica si el total de las cantidades de tipo de habitación supera el máximo de habitaciones del hotel.
     *
     * @param int $hotelId
     * @param int $cantidadNueva
     * @return bool
     */
    public function checkMaxQtyHotelRooms(int $hotelId, int $cantidadNueva,int $cantidadActual): bool
    {
        $hotel = Hotel::find($hotelId);
        $totalCantidad = TipoHabitacionesAcomodaciones::where('hotel_id', $hotelId)->sum('cantidad');
        $cantidadFutura = ($totalCantidad - $cantidadActual) + $cantidadNueva;
        return ($cantidadFutura > $hotel->cant_habitaciones);
    }
}
