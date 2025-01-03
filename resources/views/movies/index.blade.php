@extends('layouts.main')
@section('content')
    <div class="container mx-auto px-4 pt-16">
        <div class="popular-movies">
            <h2 class="uppercase tracking-wider text-orange-400 text-lg font-semibold">
                popular movies
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-16">
                @foreach ($popularMovies as $movie)
                    <x-Movie-card :movie="$movie" />
                @endforeach
            </div>
            <div class="now-playing-movies py-24">
                <h2 class="uppercase tracking-wider text-orange-400 text-lg font-semibold">
                    Now Playing
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-16">
                    @foreach ($nowPlayingMovies as $movie)
                        <x-Movie-card :movie="$movie" />
                    @endforeach

                </div>
            </div>
        </div>
    @endsection
