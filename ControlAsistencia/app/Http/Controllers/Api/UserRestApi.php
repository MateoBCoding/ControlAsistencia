<?php

namespace App\Http\Controllers\Api;

set_time_limit(0);
date_default_timezone_set("America/Bogota");

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempFingerprint;
use App\Models\Fingerprint;
use App\Models\RecordUser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class UserRestApi extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $header = str_replace("Basic ", "", $request->header("Authorization"));
        $api = Config::get("constants.API_KEY");
        if ($api == $header) {
            $from = $request->from;
            $query = "SELECT count(*) total FROM users u INNER JOIN fingerprint f on u.id = f.user_id";
            $rs = DB::select($query);
            $count = $rs[0]->total;
            $query2 = "SELECT u.id, " . $count . " as count, f.fingerprint, concat(u.first_name,' ',u.last_name) name,"
                    . "u.user_id_number FROM users u INNER JOIN fingerprint f on u.id = f.user_id "
                    . "limit " . $from . ", 10";
            $usuarios = DB::select($query2);
            return $usuarios;
        } else {
            return response(array("status" => "No tienes permisos para acceder a este recurso"), 401)
                            ->header("HTTP/1.1 401", "Unauthorized");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $header = str_replace("Basic ", "", $request->header("Authorization"));
        $api = Config::get("constants.API_KEY");
        if ($api == $header) {
            $temp = TempFingerprint::where("serial_number_pc", $request->serial_number_pc)->first();
            $dedo = explode("_", $temp->finger_name);
            $fingerprint = new FingerPrint();
            $fingerprint->user_id = $temp->user_id;
            $fingerprint->finger_name = $dedo[0] . " " . $dedo[1];
            $fingerprint->image = $request->image;
            $fingerprint->fingerprint = $request->fingerprint;
            $fingerprint->notified = 0;
            $response = $fingerprint->save();
            TempFingerprint::destroy($temp->id);
            $arrayResponse = array("response" => $response);
            return $arrayResponse;
        } else {
            return response(array("status" => "No tienes permisos para acceder a este recurso"), 401)
                            ->header("HTTP/1.1 401", "Unauthorized");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $header = str_replace("Basic ", "", $request->header("Authorization"));
        $api = Config::get("constants.API_KEY");
        $response = 0;
        if ($api == $header) {
            $text = $request->text;
            if ($request->user_id > 0) {
                $text = self::saveRecord($request->user_id);
            }
            $response = TempFingerprint::where("serial_number_pc", $request->serial_number_pc)
                    ->update([
                "fingerprint" => $request->fingerprint,
                "image" => $request->image,
                "user_id" => $request->user_id,
                "user_id_number" => $request->user_id_number,
                "name" => $request->name, "text" => $text
            ]);
            return array("response" => $response);
        } else {
            return response(array("status" => "No tienes permisos para acceder a este recurso"), 401)
                            ->header("HTTP/1.1 401", "Unauthorized");
        }
    }

    public static function saveRecord($userId) {
        $typeRecord = "";
        $text = "";
        $hoy = date("Y-m-d");
        $query = "SELECT type_record FROM records_users WHERE user_id = " . $userId . " "
                . "and date_record like '%" . $hoy . "%' order by date_record desc limit 1";
        $rs = DB::select($query);
        if (count($rs) > 0 && $rs[0]->type_record == "chek out") {
            $text = "Ya registraste salida..!";
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
            $record->user_id = $userId;
            $record->date_record = date("Y-m-d H:i:s");
            $record->type_record = $typeRecord;
            $record->save();
        }
        return $text;
    }

    public function sincronizar(Request $request) {
        $header = str_replace("Basic ", "", $request->header("Authorization"));
        $api = Config::get("constants.API_KEY");
        if ($api == $header) {
            $query = "SELECT u.id user_id, u.user_id_number, f.fingerprint, f.finger_id,"
                    . " concat(u.first_name,' ',u.last_name) name,"
                    . "u.user_id_number FROM users u INNER JOIN fingerprint f on u.id = f.user_id "
                    . "WHERE f.id > " . $request->finger_id;
            $usuarios = DB::select($query);
            return $usuarios;
        } else {
            return response(array("status" => "No tienes permisos para acceder a este recurso"), 401)
                            ->header("HTTP/1.1 401", "Unauthorized");
        }
    }

}
