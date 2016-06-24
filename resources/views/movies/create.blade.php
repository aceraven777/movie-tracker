@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1 class="page-header">Add Movie</h1>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {!! Form::model($movie = new \App\Movie, ['url' => 'movies', 'files' => true]) !!}
                @include('movies._form', ['submit_button_text' => 'Add Movie'])
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
