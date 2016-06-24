<div class="form-group">
    {!! Form::label('form_name', 'Name:') !!}
    {!! Form::text('name', null, ['id' => 'form_name', 'class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('form_release_date', 'Release Date:') !!}
    {!! Form::date('release_date', null, ['id' => 'form_release_date', 'class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('form_image', 'Image:') !!}
    {!! Form::file('image', ['id' => 'form_image', 'accept' => 'image/*']) !!}
    <p>200px x 300px</p>
</div>

{!! Form::submit($submit_button_text, ['class' => 'btn btn-primary']) !!}