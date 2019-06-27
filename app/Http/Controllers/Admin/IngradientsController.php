<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Ingradient;
use Illuminate\Http\Request;

class IngradientsController extends Controller
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
            $ingradients = Ingradient::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $ingradients = Ingradient::latest()->paginate($perPage);
        }

        return view('admin.ingradients.index', compact('ingradients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.ingradients.create');
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
			'name' => 'required|max:30'
		]);
        $requestData = $request->all();
        
        Ingradient::create($requestData);

        return $requestData['url'] ? 'Ingradient added!' : redirect('admin/ingradients')->with('flash_message', 'Ingradient added!');
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
        $ingradient = Ingradient::findOrFail($id);

        return view('admin.ingradients.show', compact('ingradient'));
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
        $ingradient = Ingradient::findOrFail($id);

        return view('admin.ingradients.edit', compact('ingradient'));
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
			'name' => 'required|max:30'
		]);
        $requestData = $request->all();
        
        $ingradient = Ingradient::findOrFail($id);
        $ingradient->update($requestData);

        return redirect('admin/ingradients')->with('flash_message', 'Ingradient updated!');
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
        Ingradient::destroy($id);

        return redirect('admin/ingradients')->with('flash_message', 'Ingradient deleted!');
    }
}
