<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedirectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redirects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('old_url')->nullable();
            $table->string('new_url')->nullable();
            $table->boolean('draft')->default(true);
            $table->boolean('online')->default(true);
            $table->integer('order_column')->nullable();
            $table->timestamps();
        });
    }
}
