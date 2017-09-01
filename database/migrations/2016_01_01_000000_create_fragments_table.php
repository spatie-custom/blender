<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFragmentsTable extends Migration
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
            $table->string('group');
            $table->index('group');
            $table->string('key');
            $table->json('text');
            $table->string('description')->nullable();
            $table->boolean('contains_html')->default(false);
            $table->boolean('contains_image')->default(false);
            $table->boolean('hidden')->default(false);
            $table->boolean('draft')->default(true);
            $table->timestamps();
        });
    }
}
