<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->json('name')->nullable();
            $table->json('text')->nullable();
            $table->json('slug')->nullable();
            $table->json('meta_values')->nullable();
            $table->boolean('draft')->default(true);
            $table->boolean('online')->default(true);
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('technical_name')->nullable();
            $table->integer('order_column')->nullable();
            $table->timestamps();
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('articles');
        });
    }
}
