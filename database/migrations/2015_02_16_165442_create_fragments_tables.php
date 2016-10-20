<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFragmentsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fragments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('contains_html')->default(false);
            $table->boolean('hide_fragment')->default(false);
            $table->boolean('draft')->default(true);
            $table->timestamps();
        });

        Schema::create('fragment_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fragment_id')->unsigned();
            $table->text('text');
            $table->string('locale')->index();

            $table->unique(['fragment_id', 'locale']);
            $table->foreign('fragment_id')->references('id')->on('fragments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fragment_translations');
        Schema::drop('fragments');
    }
}
