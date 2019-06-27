<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingradient extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ingradients';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

	public function recipe()
	{
		return $this->belongsToMany('App\Recipe', 'recipes_ingradients', 'ingradient_id', 'recipe_id');
	}
    
}
