<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;
use App\Models\UserVideo;
use App\Http\Controllers\EditUserController;
use App\Http\Controllers\CategoryVideoController;
use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Models\Commune;
use App\Models\Video;


class ViewsController extends Controller
{   
    //Vista indice
    public function vistaIndice(){
        $videos =  VideoController::index();
        return view('index',compact('videos'));
    }

    //Vista login
    public function vistaLogin(){

        return view('login');
    }

    //Vista Register
    public function vistaRegister(){
        //Se consiguen las comunas desde la base de datos
        $comunas = CommuneController::index();

        return view('register',compact('comunas'));
    }

    public function vistaEditarUsuario($user){
        $usuario=User::findOrFail($user);
        $comunas = CommuneController::index();
        $comuna_usuario=Commune::find($usuario->id_comuna);

        return view('editUser',compact('comunas','usuario','comuna_usuario'));
    }

    public function vistaUsuario(){
        $user=Auth::user();
        $comunas = CommuneController::index();
        $comuna=Commune::find($user->id_comuna);
        return view('userView',compact('user','comuna'));
    }

    //Vista My videos
    public function vistaMyVideos(){
        $videos =  VideoController::index();
        if(!Auth::check()){
            return redirect()->action([ViewsController::class, 'vistaLogin']);
        }
        $videosUser = array();
        foreach($videos as $vid){
            if($vid->id_usuario_autor == Auth::id()){
                array_push($videosUser,$vid);
            }
        }
        return view('myvideos',compact('videosUser'));
    }
    //Vista My videos
    public function vistaEditVideo($id){
        if(!Auth::check()){
            return redirect()->action([ViewsController::class, 'vistaLogin'])->with('Conectarse', 'No conectado, conectese!');
        }
        $video =  VideoController::show($id);
        if(!(Auth::id() == $video->id_usuario_autor)){
            return redirect()->action([ViewsController::class, 'vistaMyVideos'])->with('mensaje', 'No es tu video');
        }
        return view('editvideo',compact('video'));
    }

    public function vistaTopVideos(){
        $videos =  VideoController::ordenadosViews();
        return view('topvideos',compact('videos'));
    }
    public function actualizarVideo(Request $datos, $idVideo){
        if(!(strpos($datos->direccion_video,' ') === false) || (strlen($datos->direccion_video)) != 41 ){
            return back()->with('BadUrl', 'Url invalido!');
        }
        //Se busca al usuario segun su id
        $videoActualizar = VideoController::show($idVideo);

        //Se actualizan sus datos de acuerdo al formulario
        $videoActualizar->titulo_video = $datos->titulo_video;
        $videoActualizar->descripcion = $datos->descripcion;
        $videoActualizar->direccion_video = $datos->direccion_video;

        //Se guardan los cambios en la base de datos
        $videoActualizar->save();

        //Se regresa a la vista anterior
        return redirect()->action([ViewsController::class, 'vistaMyVideos'])->with('mensaje', 'Video actualizado!');
    }
    public function vistaVideosCategoria($id){
        $videos =  CategoryVideoController::videosPorCategoria($id);
        $categorias =  CategoryController::index();
        return view('categoryvideos',compact('videos','categorias'));
    }
    public function refrescarPagina(Request $request){
        $videos =  CategoryVideoController::videosPorCategoria($request->id);
        $categorias =  CategoryController::index();
        return redirect()->action([ViewsController::class, 'vistaVideosCategoria'],['id' =>$request->id])->with('videosCargados', 'Lista de Videos actualizados');
    }
    public function vistaSubirVideo(){
        if(!Auth::check()){
        }
            return redirect()->action([ViewsController::class, 'vistaLogin']);
        return view('uploadvideo');
    }
    public function SubirVideo(Request $request){
        if(!(strpos($request->direccion_video,' ') === false) || (strlen($request->direccion_video)) != 41 ){
            return redirect()->action([ViewsController::class, 'vistaSubirVideo'])->with('BadUrl', 'Url invalido!');
        }
        $videoNuevo = new Video();
        $videoNuevo->descripcion= $request->descripcion;
        $videoNuevo->titulo_video = $request->titulo_video;
        $videoNuevo->direccion_video = $request->direccion_video;
        $videoNuevo->visitas = 0;
        $videoNuevo->restriccion_edad = 0;
        $videoNuevo->popularidad = 0;
        $videoNuevo->cantidad_temporadas = 0;
        $videoNuevo->id_usuario_autor = Auth::id();
        $videoNuevo->id_comuna = Auth::user()->id_comuna;
        $videoNuevo->save();
        return redirect()->action([ViewsController::class, 'vistaMyVideos'])->with('mensaje', 'Video Subido!');
    }




    //Vista My videos
    /*public function vistaHistorial(){
        $user_id = Auth::user()->id;

        $videosHistorial = UserVideo::all()
                    ->select('id_usuario', $user_id)
                    ->groupBy('id_usuario')->distinct()->get();
        /*$arrayVideos = array();                            
        foreach ($videosHistorial as $vid) {
            array_push($arrayVideos, VideoController::show($vid->id));
        }
            

        return view('historial',compact('videosHistorial'));
    }*/
}
