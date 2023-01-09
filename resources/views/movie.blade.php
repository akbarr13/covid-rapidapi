@extends('layouts.app')

@section('content')
    <h1 class="text-center font-bold text-2xl ">Movie List</h1>
    <input class="mx-auto flex my-4" type="text" name="search" id="search-movie">
    <div class="container">
        <div class="row justify-content-center">
            @foreach ($movies as $movie)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center mb-2">{{ $movie['title'] }}</h3>
                            <img src="{{ getenv('MOVIE_BASE_IMG_URL').$movie['poster_path'] }}" alt="">
                        </div>
                        <div class="card-body">
                            <p class="text-center">{{ $movie['overview'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
@endsection