<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserVideo;
use Illuminate\Support\Facades\Validator;

class UserVideoController extends Controller
{
    public function index()
    {
        //Se traen todos los usuarios videos  de la base de datos
        $usuarioVideo = UserVideo::all();

        //Se verifica en caso este vacia
        if($usuarioVideo == NULL){
            return "No existen usuario video ";
        }
        return response()->json($usuarioVideo);
    }

    public function store(Request $request)
    {
        $usuarioVideo = new UserVideo();
        $validarDatos = Validator::make($request->all(),[
            'id_usuario' => 'required',
            'id_video' => 'required'
        ],[
            'id_usuario.required' => 'Debe ingresar el id del usuario',
            'id_video.required' => 'Debe ingresar el id del video'
        ]);

        if ($validarDatos->fails()){
            return response()->json($validarDatos->errors(), 400);
        }

        $usuarioVideo->id_usuario= $request->id_usuario;
        $usuarioVideo->id_video= $request->id_video;
        $usuarioVideo->save();
        return response()->json([
            "message" => "Se ha creado un nuevo usuario video",
            $usuarioVideo
        ]);
    }
    public function show($id)
    {
        $usuarioVideo = UserVideo::find($id);
        
        if($usuarioVideo == NULL){
            return "No existe un usuario video";
        }

        return response()->json($usuarioVideo);
    }
    public function update(Request $request, $id)
    {
        $usuarioVideo = UserVideo::find($id);
        if($usuarioVideo == NULL){
            return "No existe un usuario video";
        }
        $validarDatos = Validator::make($request->all(),[
            'id_usuario' => 'required',
            'id_video' => 'required'
        ],[
            'id_usuario.required' => 'Debe ingresar el id del usuario',
            'id_video.required' => 'Debe ingresar el id del video'
        ]);

        if ($validarDatos->fails()){
            return response()->json($validarDatos->errors(), 400);
        }

        $usuarioVideo->id_usuario = $request->id_usuario;
        $usuarioVideo->id_video = $request->id_video;
        $usuarioVideo->save();
        return response()->json([
            "message" => "Se ha actualizado un usuario video",
            $usuarioVideo
        ]);
    }
    public function destroy($id)
    {
        $UsuarioVideo = UserVideo::find($id);
        
        if($UsuarioVideo == NULL){
            return "No existe un usuario video asociado a ese id";
        }

        $UsuarioVideo->delete();
        return response()->json([
            "message" => "Se ha borrado el usuario video",
            "id" => $UsuarioVideo->id
        ]);
    }
}
