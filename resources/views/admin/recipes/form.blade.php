<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($recipe->name) ? $recipe->name : ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'Description' }}</label>
    <textarea class="form-control" rows="5" name="description" type="textarea" id="description" >{{ isset($recipe->description) ? $recipe->description : ''}}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <input class="form-control" name="user_id" type="hidden" id="user_id" value="{{ Auth::user() ? Auth::user()->id : ''}}" >
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="table-responsive">
    <table class="table ingradients">
        <thead>
        <tr>
         <th>Ingradient</th><th>Quantity</th><th></th>
        </tr>
        </thead>
        <tbody>

        @if(isset($recipe) && count($recipe->ingradient))
        @foreach($recipe->ingradient as $ingradient)
            <tr class="content">

                <td>
                    <select class="form-control" name="ingradient_id[]">
                        @foreach($ingradients as $ingradient_all)
                            <option value="{{ $ingradient_all->id }}" {{ $ingradient->id == $ingradient_all->id ? 'selected' : '' }}>{{ $ingradient_all->name }}</option>
                        @endforeach
                    </select>

                </td>
                <td>
                    <input class="form-control" name="ingradient_quantity[]" type="text" id="name" value="{{ $ingradient->pivot->ingradient_quantity }}" >
                </td>
                <td>
                    <button class="btn btn-danger btn-sm delete_ingradient" title="Delete Ingradient" data="{{ $ingradient->id }}">Delete</button>

                </td>
            </tr>
        @endforeach
        @else
            <tr class="content">

                <td>
                    <select class="form-control" name="ingradient_id[]">
                        @foreach($ingradients as $ingradient_all)
                            <option value="{{ $ingradient_all->id }}">{{ $ingradient_all->name }}</option>
                        @endforeach
                    </select>

                </td>
                <td>
                    <input class="form-control" name="ingradient_quantity[]" type="text" id="name" value="" >
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete_ingradient" title="Delete Ingradient" data="">Delete</button>

                </td>
            </tr>
        @endif
        <tr>
            <td>
            <button type="button" class="btn btn-success btn-sm add_ingradient" title="Add Ingradient">Add</button>
            </td>
            <td><span class="float-right">Not in the list?</span></td>
            <td><button type="button" class="btn btn-info btn-sm create_ingradient" data-toggle="modal" data-target="#addIngradient">Create new ingradient</button>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<hr>
<div class="form-group float-right">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>

<div class="modal fade" id="addIngradient">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add ingradient</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" class="form-control" name="ingradient" placeholder="Enter title">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary add-ingradient">Save changes</button>
                    </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    $(function () {
        $('.delete_ingradient').click(function (e) {
            e.preventDefault();
            var ingradient = $(this).attr('data');
            if(ingradient !== '') {
                $.ajax({
                    url: 'delete-ingradient',
                    type: 'GET',
                    data: {ingradient: ingradient},
                    success: function (response) {
                        if (response !== '') {
                            $('#addIngradient .modal-body').html('<div class="alert alert-success">'+response+'</div>');
                            $('#addIngradient').modal('show');
                            window.setTimeout(function () {
                                location.reload()
                            }, 3000);
                        }
                    }
                });
            }
        });

        $('.add_ingradient').click(function (e) {
           e.preventDefault();
           var row = $('table.ingradients').find('tr.content').html();

           $('table.ingradients > tbody > tr:last-child').before('<tr>'+row+'</tr>');
           var added_row = $('table.ingradients > tbody > tr:last-child').prev('tr');
           added_row.find('input#name').val('');
           console.log(added_row.find('.delete_ingradient').attr('data'));
            added_row.find('.delete_ingradient').attr('data', '').addClass('delete_row');

            $('.delete_row').click(function (e) {
                e.preventDefault();
                $(this).closest('tr').remove();
            })
        });

        $('#addIngradient .add-ingradient').click(function (e) {
            e.preventDefault();
            console.log($(this));

            var ingradient = $('#addIngradient input').val();
            if(ingradient !== '') {
                $.ajax({
                    url: '/admin/ingradients',
                    type: 'POST',
                    data: {name: ingradient, _token: $('meta[name="csrf-token"]').attr('content'), url: location.href},
                    success: function (response) {
                        if (response !== '') {
                            $('#addIngradient .modal-body').html('<div class="alert alert-success">'+response+'</div>');
                            window.setTimeout(function () {
                                location.reload()
                            }, 3000);
                        }
                    }
                });
            }
        });
    });


</script>