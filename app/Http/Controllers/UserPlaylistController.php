<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPlaylist;
use Illuminate\Support\Facades\Validator;

class UserPlaylistController extends Controller
{
    public function index()
    {
        //Se traen todas las tuplas de la tabla intermedia UserPlaylist de la base de datos
        $userPlaylists = UserPlaylist::all();

        //Se verifica en caso este vacia
        if($userPlaylists == NULL){
            return "No existe ninguna tupla en la tabla intermedia user-playlist.";
        }
        //Se retornan las tuplas de la tabla intermedia UserPlaylist en formato json
        return response()->json($userPlaylists);
    }

    //Guarda una nueva tupla-> Create
    public function store(Request $request)
    {
        $userPlaylist = new UserPlaylist();

        $validarDatos = Validator::make($request->all(),[
            'id_playlist' => 'required',
            'id_usuario' => 'required',
        ],[ //Mensajes de error abajo
            'id_playlist.required' => 'Debe ingresar el id de la playlist',
            'id_usuario.required' => 'Debe ingresar el id del usuario',
        ]);
        if ($validarDatos->fails()){
            return response()->json($validarDatos->errors(), 400);
        }

        $userPlaylist->id_playlist = $request->id_playlist;
        $userPlaylist->id_usuario = $request->id_usuario;
        $userPlaylist->save();

        return response()->json([
            "message" => "Se ha generado una nueva tupla en la tabla intermedia user-playlist",
            "id" => $userPlaylist->id
        ]);
    }

    //Muestra solo una tupla, según su id -> Read
    public function show($id)
    {
        $userPlaylist = UserPlaylist::find($id);
        if($userPlaylist == NULL){
            return "No existe ninguna tupla de la tabla intermedia user-playlist con ese id";
        }
        return response()->json($userPlaylist);
    }


    //Actualiza una tupla -> Update
    public function update(Request $request, $id)
    {
        $userPlaylist = UserPlaylist::find($id);

        $validarDatos = Validator::make($request->all(),[
            'id_playlist' => 'required',
            'id_usuario' => 'required',
        ],[ //Mensajes de error abajo
            'id_playlist.required' => 'Debe ingresar el id de la playlist',
            'id_usuario.required' => 'Debe ingresar el id del usuario',
        ]);
        if ($validarDatos->fails()){
            return response()->json($validarDatos->errors(), 400);
        }

        $userPlaylist->id_playlist = $request->id_playlist;
        $userPlaylist->id_usuario = $request->id_usuario;
        $userPlaylist->save();

        $userPlaylist->save();
        return response()->json($userPlaylist);
    }

    //Borra una tupla -> Delete
    public function destroy($id)
    {
        $userPlaylist = UserPlaylist::find($id);
        
        if($userPlaylist == NULL){
            return "No existe ninguna tupla de la tabla intermedia user-playlist con ese id";
        }

        $userPlaylist->delete();
        return response()->json([
            "message" => "Se ha borrado la tupla de la tabla intermedia user-playlist",
            "id" => $userPlaylist->id
        ]);
    }
}