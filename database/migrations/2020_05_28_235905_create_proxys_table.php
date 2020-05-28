<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProxysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxys', function (Blueprint $table) {
            $table->id();
            $table->string("proxy_id");
            $table->string("version");
            $table->string("ip");
            $table->string("host");
            $table->string("port");
            $table->string("user");
            $table->string("pass");
            $table->string("type");
            $table->string("country");
            $table->timestamp("date");
            $table->timestamp("date_end");
            $table->string("descr")->nullable();
            $table->boolean("active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proxys');
    }
}
