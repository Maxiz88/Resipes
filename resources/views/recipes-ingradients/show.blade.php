@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">RecipesIngradient {{ $recipesingradient->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/recipes-ingradients') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/recipes-ingradients/' . $recipesingradient->id . '/edit') }}" title="Edit RecipesIngradient"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('recipesingradients' . '/' . $recipesingradient->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete RecipesIngradient" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $recipesingradient->id }}</td>
                                    </tr>
                                    <tr><th> Ingradient Quantity </th><td> {{ $recipesingradient->ingradient_quantity }} </td></tr><tr><th> Recipe Id </th><td> {{ $recipesingradient->recipe_id }} </td></tr><tr><th> Ingradient Id </th><td> {{ $recipesingradient->ingradient_id }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
