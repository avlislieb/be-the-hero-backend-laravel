<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOngs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ongs', function (Blueprint $table) {

            $table->string('id');
            $table->primary('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('city',100)->nullable();
            $table->string('uf', 2)->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('ongs');
    }
}
