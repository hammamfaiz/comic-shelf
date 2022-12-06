<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comics', function (Blueprint $table) {
            $table->id();
            $table->integer('genre_id')->nullable(false)->default(1);
            $table->integer('publisher_id')->nullable(false)->default(1);
            $table->integer('library_id')->nullable(false)->default(1);
            $table->string('title');
            $table->string('author');
            $table->integer ('stock')->nullable(false)->default(0);
            $table->integer ('price')->nullable(false)->default(0);
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
        Schema::dropIfExists('comics');
    }
};
