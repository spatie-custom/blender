<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTables extends Migration
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
            $table->datetime('publish_date');
            $table->boolean('draft')->default(true);
            $table->boolean('online')->default(true);
            $table->string('technical_name')->nullable();
            $table->integer('order_column')->nullable();
            $table->timestamps();
        });

        Schema::create('article_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->unsigned();
            $table->string('locale')->index();
            $table->string('url');
            $table->string('name');
            $table->text('text');
            $table->unique(['article_id', 'locale']);
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article_translations');
        Schema::drop('articles');
    }
}
