<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFingerprintTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('fingerprint', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id");
            $table->string("finger_name", 30)->nullable();
            $table->binary("image")->nullable();
            $table->binary("fingerprint")->nullable();
            $table->integer("notified")->nullable();
            $table->index(["user_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('fingerprint');
    }

}
