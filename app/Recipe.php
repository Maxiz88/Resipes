<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'recipes';

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
    protected $fillable = ['name', 'description', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

	public function ingradient()
	{
		return $this->belongsToMany('App\Ingradient', 'recipes_ingradients', 'recipe_id', 'ingradient_id')->withPivot('ingradient_quantity');
	}
    
}
