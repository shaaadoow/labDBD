<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{
    
    //Muestra todas las regiones
    public function index()
    {
        //Se traen todas las regiones de la tabla regions de la base de datos
        $regions = Region::all();

        //Se verifica en caso este vacia
        if($regions == NULL){
            return "No existen regiones.";
        }
        //Se retornan los paises en formato json
        return response()->json($regions);
    }

    //Guarda una nueva region-> Create
    public function store(Request $request)
    {
        $region = new Region();

        $validarDatos = Validator::make($request->all(),[
            'nombre_region' => 'required|max:100',
            'id_pais' => 'required'
        ],[
            'nombre_region.required' => 'Debe ingresar el nombre de la region',
            'nombre_region.max:100' => 'El nombre de la region no puede exceder los 100 caracteres',
            'id_pais.required' => 'Debe ingresar el id del pais al que pertenece la region'
        ]);

        if ($validarDatos->fails()){
            return back()->with('login',$validarDatos->errors());
        }

        $region->nombre_region = $request->nombre_region;
        $region->id_pais = $request->id_pais;

        $region->save();

        return back()->with('login','Region creada !');
    }

    //Muestra solo una region, según su id -> Read
    public function show($id)
    {
        $region = Region::find($id);
        
        if($region == NULL){
            return "No existe una region asociada a ese id";
        }

        return response()->json($region);
    }

    //Actualiza una region -> Update
    public function update(Request $request, $id)
    {
        $region = Region::findOrFail($id);
        
       
        $validarDatos = Validator::make($request->all(),[
            'nombre_region' => 'required|max:100',
            'id_pais' => 'required'
        ],[
            'nombre_region.required' => 'Debe ingresar el nombre de la region',
            'nombre_region.max:100' => 'El nombre de la region no puede exceder los 100 caracteres',
            'id_pais.required' => 'Debe ingresar el id del pais al que pertenece la region'
        ]);

        if ($validarDatos->fails()){
            return back()->with('login',$validarDatos->errors());
        }

        $region->nombre_region = $request->nombre_region;
        $region->id_pais = $region->id_pais;

        $region->save();

        return redirect()->route('vistaCrudAdmin')->with('register','Datos de region actualizados !');
    }

    //Borra una region -> Delete
    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        
        $region->delete();

        return back()->with('login','Región eliminada');
    }
}
