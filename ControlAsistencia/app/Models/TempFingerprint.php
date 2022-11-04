<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempFingerprint extends Model {

    use HasFactory;

    protected $table = "temp_fingerprint";
    
    protected $fillable = [
        "id",
        "user_id",
        "serial_number_pc",
        "finger_name",
        "image",
        "fingerprint",
        "option",
        "created_at",
        "updated_at",
        "name",
        "user_id_number"
    ];

}
