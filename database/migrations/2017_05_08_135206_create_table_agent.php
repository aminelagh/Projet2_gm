<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAgent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->increments('id_agent');
            $table->integer('id_fournisseur')->nullable();
            $table->string('role',255)->nullable();
            $table->string('nom',255)->nullable();
            $table->string('prenom',255)->nullable();
            $table->string('email',255)->nullable();
            $table->string('telephone',255)->nullable();
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
        Schema::dropIfExists('agents');
    }
}
