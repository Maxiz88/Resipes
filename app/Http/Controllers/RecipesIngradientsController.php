<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\RecipesIngradient;
use Illuminate\Http\Request;

class RecipesIngradientsController extends Controller
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
            $recipesingradients = RecipesIngradient::where('ingradient_quantity', 'LIKE', "%$keyword%")
                ->orWhere('recipe_id', 'LIKE', "%$keyword%")
                ->orWhere('ingradient_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $recipesingradients = RecipesIngradient::latest()->paginate($perPage);
        }

        return view('recipes-ingradients.index', compact('recipesingradients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('recipes-ingradients.create');
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
        
        $requestData = $request->all();
        
        RecipesIngradient::create($requestData);

        return redirect('recipes-ingradients')->with('flash_message', 'RecipesIngradient added!');
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
        $recipesingradient = RecipesIngradient::findOrFail($id);

        return view('recipes-ingradients.show', compact('recipesingradient'));
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
        $recipesingradient = RecipesIngradient::findOrFail($id);

        return view('recipes-ingradients.edit', compact('recipesingradient'));
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
        
        $requestData = $request->all();
        
        $recipesingradient = RecipesIngradient::findOrFail($id);
        $recipesingradient->update($requestData);

        return redirect('recipes-ingradients')->with('flash_message', 'RecipesIngradient updated!');
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
        RecipesIngradient::destroy($id);

        return redirect('recipes-ingradients')->with('flash_message', 'RecipesIngradient deleted!');
    }
}
