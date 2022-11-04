<?php

namespace App\Http\Controllers;

date_default_timezone_set("America/Bogota");

use App\Models\User;
use App\Models\FingerPrint;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Image;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $users = User::paginate(10);
        return view("usuarios.index", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $usersType = UserType::all();
        return view("usuarios.create", compact("usersType"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (auth()->user()->getTipo->description == 'admin') {
        $request->validate([
            "user_id_number" => "required",
            "first_name" => "required",
            "password" => "required",
            "user_type_id" => "required"
        ]);
        $user = new User();
        $user->user_id_number = $request->user_id_number;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->user_type_id = $request->user_type_id;
        $user->user_arl_id = $request->user_arl_id;
        $user->password = Hash::make($request->password);
        $user->url_image = Config::get("constants.RUTA_APP") . "/" . $request->url_image;
        $user->save();
        }else{  
        $request->validate([
            "user_id_number" => "required",
            "first_name" => "required",
            "user_type_id" => "required"
        ]);
        $user = new User();
        $user->user_id_number = $request->user_id_number;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->user_type_id = $request->user_type_id;
        $user->user_arl_id = $request->user_arl_id;
        $user->password = Hash::make(0000);
        $user->url_image = Config::get("constants.RUTA_APP") . "/" . $request->url_image;
        $user->save();
        }
        
        $imagenCodificada = file_get_contents("php://input"); //Obtener la imagen
        if (strlen($imagenCodificada) <= 0) {
            exit("No se ha recibido ninguna imagen");
        }
//La imagen traerá al inicio data:image/png;base64, cosa que debemos remover
        $imagenCodificadaLimpia = str_replace(" ", "+", urldecode($imagenCodificada));
        
//Venía en base64 pero s&oaccute;lo la codificamos así para que viaje por la red, ahora la decodificamos y
//todo el contenido lo guardamos en un archivo
        $imagenDecodificada = base64_decode($imagenCodificadaLimpia);
        
//Calcular un nombre único
        $nuevoNombre = "foto_" . uniqid() . ".png";
        $nombreImagenGuardada = $nuevoNombre;

//Escribir el archivo
        file_put_contents($nombreImagenGuardada, $imagenDecodificada);

//Terminar y devolver el nombre de la foto
        
        
        return redirect('/usuarios')->with(["estado" => "Ok", "mensaje" => "Usuario creado correctamente..!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $usuario = User::find($id);
        $userType = UserType::all();
        return view("usuarios.show", compact("usuario", "userType"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $usuario = User::find($id);
        $usersType = UserType::all();
        return view("usuarios.edit", compact("usuario", "usersType"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario) {
        $request->validate([
            "user_id_number" => "required",
            "first_name" => "required",
            "last_name" => "required",
            "password" => "required",
            "user_type_id" => "required"
        ]);
        $ruta = "";
        if ($request->hasFile("url_image")) {
            $file = $request->file("url_image");
            $nombre = $request->user_id_number . "." . $file->guessExtension();
            $ruta = public_path("image_user\\" . $nombre);
            $image_resize = Image::make($request->url_image->getRealPath());
            $image_resize->resize(128, 128, function ($constraint) {
                $constraint->upsize();
            });
            $image_resize->orientate();
            $image_resize->save($ruta);
            $ruta = Config::get("constants.RUTA_APP") . "/image_user/" . $nombre;
        }
        $rq = $request->all();
        if ($ruta != '') {
            $rq["url_image"] = $ruta;
        }
        $usuario->update($rq);
//        $usuario->update($request->all());
        return redirect('/usuarios')->with(["estado" => "Ok", "mensaje" => "Usuario editado correctamente..!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        User::destroy($id);
        return redirect('/usuarios')->with(["estado" => "Ok", "mensaje" => "Usuario eliminado correctamente..!"]);
    }

    public function fingerList($id) {
        $user = User::find($id);
        $fingerList = FingerPrint::select("*")->where("user_id", "=", $id)->orderBy("id")->get();
        return view("usuarios.finger-list", compact("user", "fingerList"));
    }

    public function deletFinger($user_id, $id) {
        FingerPrint::destroy($id);
        return redirect('/usuarios/' . $user_id . "/finger-list")->with(["estado" => "Ok", "mensaje" => "Huella eliminada correctamente..!"]);
    }

    public function search(Request $request) {
        $from = $request->from;
        $query = "SELECT count(*) total from users "
                . "where (first_name like '%" . $request->search . "%' "
                . "or last_name like '%" . $request->search . "%' "
                . "or email like '%" . $request->search . "%'";
        $rs = DB::select($query);
        $count = $rs[0]->total;
        $query2 = "SELECT u.*, ut.description userType, concat(u.first_name, ' ', u.last_name) name "
                . "FROM users u "
                . "JOIN users_type ut ON ut.id = u.user_type_id "
                . "where (first_name like '%" . $request->search . "%' "
                . "or last_name like '%" . $request->search . "%' "
                . "or email like '%" . $request->search . "%' "
                . "limit " . $from . ", 15";
        $usuarios = DB::select($query2);
        $usuarios["total_registros"] = count($usuarios);
        $usuarios["count"] = $count;
        return $usuarios;
    }

    public function show_update(Request $request, User $usuario) {
        $request->validate([
            "user_id_number" => "required",
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email",
        ]);
        $ruta = "";
        if ($request->hasFile("url_image")) {
            $file = $request->file("url_image");
            $nombre = $request->user_id_number . "." . $file->guessExtension();
            $ruta = public_path("image_user\\" . $nombre);
            $image_resize = Image::make($request->url_image->getRealPath());
            $image_resize->resize(128, 128, function ($constraint) {
                $constraint->upsize();
            });
            $image_resize->orientate();
            $image_resize->save($ruta);
            $ruta = Config::get("constants.RUTA_APP") . "/image_user/" . $nombre;
        }
        $rq = $request->all();
        if ($ruta != '') {
            $rq["url_image"] = $ruta;
        }
        $usuario->update($rq);
        return redirect("/usuarios/" . $usuario->id)->with(["estado" => "Ok", "mensaje" => "Perfil actualizado correctamente..!"]);
    }

    public static function save_record(Request $request) {
        $typeRecord = "";
        $text = "Registro almacenado correctamente..!";
        $hoy = date("Y-m-d");
        $user = User::select("id")->where("user_id_number", $request->user_id_number)->first();
        if ($user) {
            $query = "SELECT type_record FROM records_users WHERE user_id = " . $user->id . " "
                    . "and date_record like '%" . $hoy . "%' order by date_record desc";
            $rs = DB::select($query);
            if (count($rs) > 0) {
                $text = ($rs[0]->type_record == "chek out") ? "Ya registraste salida..!" : $text;
            }
            if (count($rs) == 0) {
                $text = "Ingreso Regitrado..!";
                $typeRecord = "chek in";
            }
            if (count($rs) == 1 && $text == "") {
                $text = "Salida Registrada..!";
                $typeRecord = "chek out";
            }
            if ($text != "Ya registraste salida..!") {
                $record = new RecordUser();
                $record->user_id = $user->id;
                $record->date_record = date("Y-m-d H:i:s");
                $record->type_record = $typeRecord;
                $record->save();
            }
            return array("estado" => "Ok", "mensaje" => $text, "icono" => "success");
        } else {
            return array("estado" => "Ok", "mensaje" => "El usuario no existe..!", "icono" => "error");
        }
    }

}
