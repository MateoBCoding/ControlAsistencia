<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FingerPrint extends Model {

    use HasFactory;

    protected $table = "fingerprint";
    public $timestamps = false;
    
    protected $fillable = [
        "id",
        "user_id",
        "finger_name",
        "fingerprint",
        "notified"
    ];

}
