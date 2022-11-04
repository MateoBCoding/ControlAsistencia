<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id");
            $table->dateTime("date_record", $presicion = 0);
            $table->string("type_record", 10);
            $table->index(["user_id"]);            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records_users');
    }
}
