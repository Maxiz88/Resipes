<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecipesIngradientsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recipes_ingradients', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->string('ingradient_quantity')->nullable();
			$table->bigInteger('recipe_id')->unsigned();
			$table->bigInteger('ingradient_id')->unsigned();
		});

		Schema::table('recipes_ingradients', function($table){
			$table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
			$table->foreign('ingradient_id')->references('id')->on('ingradients')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('recipes_ingradients');
	}
}
