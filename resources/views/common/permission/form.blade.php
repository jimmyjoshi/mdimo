<div class="box-body">
    <div class="form-group">
        {{ Form::label('name', 'Name :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name', 'required' => 'required']) }}
        </div>
    </div>
</div><div class="box-body">
    <div class="form-group">
        {{ Form::label('display_name', 'Display Name :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('display_name', null, ['class' => 'form-control', 'placeholder' => 'Display Name', 'required' => 'required']) }}
        </div>
    </div>
</div><div class="box-body">
    <div class="form-group">
        {{ Form::label('sort', 'Sort :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('sort', null, ['class' => 'form-control', 'placeholder' => 'Sort', 'required' => 'required']) }}
        </div>
    </div>
</div>