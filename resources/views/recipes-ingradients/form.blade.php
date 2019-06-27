<div class="form-group {{ $errors->has('ingradient_quantity') ? 'has-error' : ''}}">
    <label for="ingradient_quantity" class="control-label">{{ 'Ingradient Quantity' }}</label>
    <input class="form-control" name="ingradient_quantity" type="text" id="ingradient_quantity" value="{{ isset($recipesingradient->ingradient_quantity) ? $recipesingradient->ingradient_quantity : ''}}" >
    {!! $errors->first('ingradient_quantity', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('recipe_id') ? 'has-error' : ''}}">
    <label for="recipe_id" class="control-label">{{ 'Recipe Id' }}</label>
    <input class="form-control" name="recipe_id" type="number" id="recipe_id" value="{{ isset($recipesingradient->recipe_id) ? $recipesingradient->recipe_id : ''}}" >
    {!! $errors->first('recipe_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('ingradient_id') ? 'has-error' : ''}}">
    <label for="ingradient_id" class="control-label">{{ 'Ingradient Id' }}</label>
    <input class="form-control" name="ingradient_id" type="number" id="ingradient_id" value="{{ isset($recipesingradient->ingradient_id) ? $recipesingradient->ingradient_id : ''}}" >
    {!! $errors->first('ingradient_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
