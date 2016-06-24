@extends('layouts.app')

@section('content')
<div class="home-page container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @foreach ($movies as $movie)
                <div class="col-md-4">
                    <div class="movie-element">
                        <div class="text-center">
                            <img src="{{ asset("images/movies/{$movie->name_slug}/{$movie->image_path}") }}" alt="{{ $movie->name }}" />
                        </div>
                        <h3>{{ $movie->name }}</h3>
                        <p>{{ $movie->release_date }}</p>
                        @if (Auth::user())
                            <p>
                                <a class="btn btn-info" href="#" role="button">Rate Movie</a>
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
            <p>{{ $movies->links() }}</p>
        </div>
    </div>
</div>
@endsection
