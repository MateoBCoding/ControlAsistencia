<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordUser extends Model {

    use HasFactory;

    protected $table = "records_users";
    public $timestamps = false;
    protected $fillable = [
        "id",
        "user_id",
        "date_record",
        "type_record"
    ];

}
