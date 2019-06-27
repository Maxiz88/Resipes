<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipesIngradient extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'recipes_ingradients';

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
    protected $fillable = ['ingradient_quantity', 'recipe_id', 'ingradient_id'];

    public function recipe()
    {
        return $this->belongsToMany('App\Recipe');
    }
    public function ingradient()
    {
        return $this->belongsToMany('App\Ingradient');
    }
    
}
