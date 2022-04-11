<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUlLocalizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ul_localizations', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('english')->nullable();
            $table->text('brazilian')->nullable();
            $table->text('old_english')->nullable();
            $table->text('old_brazilian')->nullable();
            $table->integer('verificado')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ul_localizations');
    }
}
