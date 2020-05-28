<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProxyAndLastChangeToPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->ipAddress("proxy")->nullable();
            $table->integer("port")->nullable();
            $table->timestamp("last_changed")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->removeColumn("proxy");
            $table->removeColumn("port");
            $table->removeColumn("last_changed");
        });
    }
}
