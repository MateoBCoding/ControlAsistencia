<?php

namespace App\Http\Controllers;

date_default_timezone_set("America/Bogota");

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $hoy = date("Y-m-d");
        $records = "";
        $total_usuarios = "";
        $total_marcaciones = "";
        if (Auth()->user()->getTipo->description == "admin") {   
            $query = "select count(id) total from users";
            $users = DB::select($query);
            $total_usuarios = $users[0]->total;
            $query2 = "select count(id) total from records_users where date_record like '%" . $hoy . "%'";
            $marcaciones = DB::select($query2);
            $total_marcaciones = $marcaciones[0]->total;
            $records = DB::table("records_users")
                    ->join("users", "records_users.user_id", "=", "users.id")
                    ->select("records_users.*", "users.first_name", "users.last_name")
                    ->where("records_users.date_record", "like", '%' . $hoy . '%')
                    ->orderBy("records_users.id")
                    ->paginate(15);
          
        } else {
            $records = DB::table("records_users")
                    ->join("users", "records_users.user_id", "=", "users.id")
                    ->select("records_users.*", "users.first_name", "users.last_name")
                    ->where("user_id", "=", Auth()->user()->id)
                    ->orderBy("records_users.id")
                    ->paginate(15);
        }
        return view('home', compact("records", "total_usuarios", "total_marcaciones", "hoy"));
    }

    public function search(Request $request) {
        $from = $request->from;
        $query = "select count(*) total from records_users r "
                . "join users u on u.id = r.user_id "
                . "where r.date_record like '%" . $request->search . "%' "
                . "limit " . $from . ", 15";
        $count = DB::select($query);
        $total = $count[0]->total;
        $query2 = "select r.*, concat(u.first_name,' ', u.last_name) name from records_users r "
                . "join users u on u.id = r.user_id "
                . "where r.date_record like '%" . $request->search . "%' "
                . "limit " . $from . ", 15";
        $records = DB::select($query2);
        $records["total_registros"] = count($records);
        $records["count"] = $total;
        return $records;
    }

}
