<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Ingradient;
use App\Recipe;
use Illuminate\Http\Request;

class RecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $recipes = Recipe::where('name', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('user_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $recipes = Recipe::latest()->paginate($perPage);
        }

        return view('admin.recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
	    $ingradients = Ingradient::all();
        return view('admin.recipes.create', compact('recipe', 'ingradients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'name' => 'required|max:30',
			'description' => 'required|min:10',
			'ingradient_quantity.*' => 'required'
		]);
        $requestData = $request->all();
        $recipe = Recipe::create($requestData);

	    /**
	     * @todo relize it in other method for update and create
	     */

	    if($requestData['ingradient_id']) {

		    $ingradient = $requestData['ingradient_id'];

		    foreach ( $ingradient as $key => $value ) {
		    	$this->addIngradientByRecipe($recipe, $value, $requestData['ingradient_quantity'][$key]);
		    }
	    }

        return redirect('admin/recipes')->with('flash_message', 'Recipe added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $recipe = Recipe::findOrFail($id);
        return view('admin.recipes.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $recipe = Recipe::findOrFail($id);
        $ingradients = Ingradient::all();
        return view('admin.recipes.edit', compact('recipe', 'ingradients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'name' => 'required|max:30',
	        'description' => 'required|min:10',
			'ingradient_quantity.*' => 'required'
		]);
        $requestData = $request->all();

        $recipe = Recipe::findOrFail($id);
        $recipe->update($requestData);
	    if($requestData['ingradient_id']) {

	    	$ingradient = $requestData['ingradient_id'];

		    foreach ( $ingradient as $key => $value ) {

			    $ingradient_exist = $recipe->ingradient()->where('ingradient_id', $value)->exists();
			    if($ingradient_exist) {
				    $this->updateIngradientByRecipe($recipe, $value, $requestData['ingradient_quantity'][$key]);
			    } else {
				    $this->addIngradientByRecipe($recipe, $value, $requestData['ingradient_quantity'][$key]);
			    }

		    }
	    }

        return redirect('admin/recipes')->with('flash_message', 'Recipe updated!');
    }

	/**
	 * @param $recipe
	 * @param $ingradient_id
	 * @param $ingradient_quantity
	 *
	 * @return mixed
	 */
    public function updateIngradientByRecipe($recipe, $ingradient_id, $ingradient_quantity) {
    	return $recipe->ingradient()->updateExistingPivot($ingradient_id, ['ingradient_quantity' => $ingradient_quantity]);
    }

	/**
	 * @param $recipe
	 * @param $ingradient_id
	 * @param $ingradient_quantity
	 *
	 * @return mixed
	 */
    public function addIngradientByRecipe($recipe, $ingradient_id, $ingradient_quantity) {
	    return $recipe->ingradient()->attach([$ingradient_id => ['ingradient_quantity' => $ingradient_quantity]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Recipe::destroy($id);

        return redirect('admin/recipes')->with('flash_message', 'Recipe deleted!');
    }


    public function deleteIngradient(Request $request, $id) {
        $responseData = '';
    	$requestData = $request->all();
    	if($requestData['ingradient']) {
    	    $recipe = Recipe::find($id);
    	    $ingradientName = Ingradient::where('id', $requestData['ingradient'])->first()->name;
    	    $deleted = $recipe->ingradient()->detach($requestData['ingradient']);
	        if($deleted) {
	        	$responseData = 'ingradient ' . $ingradientName . ' deleted';
	        }
    	}
    	return $responseData;
    }
}
