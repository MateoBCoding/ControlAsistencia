<?php

namespace App\Http\Controllers;

set_time_limit(0);
date_default_timezone_set("America/Bogota");

use App\Models\TempFingerprint;
use App\Models\Fingerprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FingerPrintController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        $response = Fingerprint::where("notified", 0)->where("user_id", $id)->get();
        if (count($response) > 0) {
            Fingerprint::where("id", $response[0]->id)
                    ->update(["notified" => 1]);
        }
        return $response;
    }

    function check_in($token, $time) {
        $time_ = 600 * 5;
        $elapsedTime = 0;
        $fecha_bd = 0;
        $fecha_actual = $time;
        while ($fecha_bd <= $fecha_actual) {
            $objHuella = TempFingerprint::select("updated_at")
                            ->where("serial_number_pc", $token)->orderByDesc("updated_at")->limit(1)->first();
            usleep(100000);
            clearstatcache();
            if (!empty($objHuella->updated_at)) {
                $fecha_bd = strtotime($objHuella->updated_at);
            }
            $elapsedTime = $elapsedTime + 1;
            if ($elapsedTime == $time_) {
                break;
            }
        }
        $response = array("user_id_number" => null,
            "name" => null, "image" => null, "updated_at" => 0);
        $query = "SELECT user_id_number, name, image, updated_at, text "
                . "FROM temp_fingerprint "
                . "WHERE serial_number_pc = '" . $token . "'";
        $rs = DB::select($query);
        if (count($rs) > 0) {
            $response["user_id_number"] = $rs[0]->user_id_number;
            $response["name"] = $rs[0]->name;
            $response["image"] = $rs[0]->image;
            $response["updated_at"] = strtotime($rs[0]->updated_at);
            $response["text"] = $rs[0]->text;
        }
        return $response;
    }

}
