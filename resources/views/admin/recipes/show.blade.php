@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Recipe {{ $recipe->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/recipes') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/recipes/' . $recipe->id . '/edit') }}" title="Edit Recipe"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/recipes' . '/' . $recipe->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Recipe" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <h3>{{ $recipe->name }}</h3>
                        <p>{{ $recipe->description }}</p>
                        <div class="table-responsive">
                            @if(isset($recipe) && count($recipe->ingradient))
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Ingradients</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recipe->ingradient as $ingradient)
                                <tr><td> {{ $ingradient->name }} </td><td> {{ $ingradient->pivot->ingradient_quantity }} </td></tr>
                                @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
