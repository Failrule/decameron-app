<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\Validator;

class hotelController extends Controller
{
    public function index()
    {

        $hoteles = Hotel::all();

        $data = [
            'hoteles' => $hoteles,
            'status' => 200
        ];

        return response()->json($data, 200); 
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
        ]);

        if($validator->fails()) {
            $data = ['message' => 'Error validando datos',
            'errors' => $validator->errors(),
            'status' => 422
            ];
            return response()->json($data,422);
        }

        $hotel = Hotel::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'nit' => $request->nit,
            'cant_habitaciones' => $request->cant_habitaciones
        ]);

        if(!$hotel) {
            $data = [
                'message' => 'Error al crear hotel',
                'status' => 500
            ];
            return response()->json($data,500);
        }
        
        $data = [
            'hotel' => $hotel,
            'status' => 201
        ];

        return response()->json($data,201);
    }

    public function show($id)
    {
        $hotel = Hotel::find($id);

        if(!$hotel) {
            $data = [
                'message' => 'Hotel no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $data = [
            'hotel' => $hotel,
            'status' => 200
        ];

        return response()->json($data,200);
    }

    public function destroy($id) 
    {
        $hotel = Hotel::find($id);

        if(!$hotel) {
            $data = [
                'message' => 'Hotel no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        
        $hotel->delete();

        $data = [
            'message' => 'Hotel eliminado',
            'status' => 200
        ];

        return response()->json($data,200);
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::find($id);

        if(!$hotel) {
            $data = [
                'message' => 'Hotel no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:hotel',
            'direccion' => 'required|min:10',
            'ciudad' => 'required|unique:hotel',
            'nit' => [
                'required',
                'regex:/^[0-9]{9}-[0-9]{1}$/'
            ],
            'cant_habitaciones' => [
                'required',
                'integer',
                'max:42'
            ]
        ]);

        if($validator->fails()) {
            $data = ['message' => 'Error validando datos',
            'errors' => $validator->errors(),
            'status' => 422
            ];
            return response()->json($data,422);
        }

        $hotel->nombre = $request->nombre;
        $hotel->direccion = $request->direccion;
        $hotel->ciudad = $request->ciudad;
        $hotel->nit = $request->nit;
        $hotel->cant_habitaciones = $request->cant_habitaciones;

        $hotel->save();

        $data = [
            'message' => 'Hotel actualizado',
            'status' => 200
        ];

        return response()->json($data,200);
    }


    public function updatePartial(Request $request, $id)
    {
        $hotel = Hotel::find($id);

        if(!$hotel) {
            $data = [
                'message' => 'Hotel no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'unique:hotel',
            'direccion' => 'min:10',
            'ciudad' => 'unique:hotel',
            'nit' => [
                'unique:hotel',
                'regex:/^[0-9]{9}-[0-9]{1}$/'
            ],
            'cant_habitaciones' => [
                'integer',
                'max:42'
            ]
        ]);

        if($validator->fails()) {
            $data = ['message' => 'Error validando datos',
            'errors' => $validator->errors(),
            'status' => 422
            ];
            return response()->json($data,422);
        }

        if ($request->has('nombre')) {
            $hotel->nombre = $request->nombre;
        }

        if ($request->has('direccion')) {
            $hotel->direccion = $request->direccion;
        }

        if ($request->has('ciudad')) {
            $hotel->ciudad = $request->ciudad;
        }

        if ($request->has('nit')) {
            $hotel->nit = $request->nit;
        }
        
        if ($request->has('cant_habitaciones')) {
            $hotel->cant_habitaciones = $request->cant_habitaciones;
        }

        $hotel->save();

        $data = [
            'message' => 'Hotel actualizado',
            'status' => 200
        ];

        return response()->json($data,200);
    }

    
}
