<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

abstract class BaseCrudController extends Controller
{
    protected $modelClass;  // Clase del modelo a usar
    protected $parentItem; // Clase de items del modelo
    protected $foreignKey;
    protected $rules = [];  // Reglas de validación
    protected $rulesPatch = []; // Reglas de validación para actualización parcial
    protected $customMessages = []; // Mensajes de validación personalizados
    protected $fields = [];

    // Mostrar todos los registros
    public function index(): JsonResponse
    {
        $items = $this->modelClass::all();
        return response()->json([
            'items' => $items,
            'status' => 200
        ], 200);
    }

    // Almacenar un nuevo registro
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), $this->rules, $this->customMessages);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error validando datos',
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }

        $item = $this->modelClass::create($request->all());

        if (!$item) {
            return response()->json([
                'message' => 'Error al crear '. class_basename($this->modelClass),
                'status' => 500
            ], 500);
        }

        return response()->json([
            'item' => $item,
            'status' => 201
        ], 201);
    }

    // Mostrar un registro específico
    public function show(int $id): JsonResponse
    {
        $item = $this->modelClass::find($id);

        if (!$item) {
            return response()->json([
                'message' => class_basename($this->modelClass) . ' no encontrado',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'item' => $item,
            'status' => 200
        ], 200);
    }

    public function showBelongs(int $id): JsonResponse
    {
        if (!$this->parentItem) {
            return response()->json([
                'message' => class_basename($this->parentItem->table) . ' no encontrado',
                'status' => 404
            ], 404);
        }

        $childItems = $this->modelClass::where($this->foreignKey, $id)->get();

        return response()->json([
            'parentItem' => $this->parentItem,
            'childItems' => $childItems,
            'status' => 200
        ], 200);
    }

    // Eliminar un registro
    public function destroy(int $id): JsonResponse
    {
        $item = $this->modelClass::find($id);

        if (!$item) {
            return response()->json([
                'message' => 'Registro no encontrado',
                'status' => 404
            ], 404);
        }

        $item->delete();

        return response()->json([
            'message' => 'Registro eliminado',
            'status' => 200
        ], 200);
    }

    // Actualización parcial de un registro
    public function updatePartial(Request $request, int $id): JsonResponse
    {
        $model = $this->modelClass::find($id);

        if (!$model) {
            return response()->json([
                'message' => class_basename($this->modelClass) . ' no encontrado',
                'status' => 404
            ], 404);
        }

        
        // Filtrar las reglas para solo incluir las reglas relevantes para los campos proporcionados
        $rulesPatch = array_filter(
            $this->rulesPatch,
            function ($key) {
                return in_array($key, $this->fields);
            },
            ARRAY_FILTER_USE_KEY
        );

        $validator = Validator::make($request->all(), $rulesPatch, $this->customMessages);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error validando datos',
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }

        foreach ($this->fields as $field) {
            if ($request->has($field)) {
                $model->$field = $request->$field;
            }
        }

        $model->save();

        return response()->json([
            'message' => class_basename($this->modelClass) . ' actualizado parcialmente',
            'status' => 200
        ], 200);
    }
}
