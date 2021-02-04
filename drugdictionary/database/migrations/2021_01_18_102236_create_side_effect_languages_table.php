<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSideEffectLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side_effect_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('side_effect_id');
            $table->unsignedTinyInteger('language');
            $table->text('description')->nullable();
            $table->text('general')->nullable();
            $table->text('doctor_attention')->nullable();
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
        Schema::dropIfExists('side_effect_languages');
    }
}
