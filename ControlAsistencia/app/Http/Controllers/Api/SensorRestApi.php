<?php

namespace App\Http\Controllers\Api;

set_time_limit(0);
date_default_timezone_set("America/Bogota");

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\TempFingerprint;

class SensorRestApi extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $header = str_replace("Basic ", "", $request->header("Authorization"));
        $api = Config::get("constants.API_KEY");
        if ($api == $header) {
            $time_ = 600 * 5;
            $elapseTime = 0;
            $fecha_bd = 0;
            $fecha_actual = $request->timestamp;
            while ($fecha_bd <= $fecha_actual) {
                $objHuella = TempFingerprint::select("updated_at")
                                ->where("serial_number_pc", $request->serial_number_pc)
                                ->orderByDesc("updated_at")->limit(1)->first();               
                usleep(100000);
                clearstatcache();
                if (!empty($objHuella->updated_at)) {
                    $fecha_bd = strtotime($objHuella->updated_at);
                }
                $elapseTime += 1;
                if ($elapseTime == $time_) {
                    break;
                }
            }
            $rows = TempFingerprint::where("serial_number_pc", $request->serial_number_pc)->first();
            $response = array();
            $response["serial_number_pc"] = $request->serial_number_pc;
            $response["updated_at"] = strtotime($rows->updated_at);
            $response["option"] = $rows->option;
            return $response;
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
        if ($api == $header) {
            $result = TempFingerprint::where("serial_number_pc", $request->serial_number_pc)
                    ->update(["option" => "close", "image" => null]);
            $arrayResponse = array("code" => $result, "message" => "Ok");
            return $arrayResponse;
        } else {
            return response(array("status" => "No tienes permisos para acceder a este recurso"), 401)
                            ->header("HTTP/1.1 401", "Unauthorized");
        }
    }

}
