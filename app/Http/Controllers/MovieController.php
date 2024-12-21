<?php

namespace App\Http\Controllers;

use App\Services\MovieService;

class MovieController extends Controller
{
    private $movieService;
    public function __construct()
    {
        $this->movieService = new MovieService();
    }

    public function index()
    {
        $popularMovies = $this->movieService->getPopularMovies();
        $nowPlayingMovies = $this->movieService->getNowPlayingMovies();
        return view('movies.index',[
            'popularMovies' => $popularMovies,
            'nowPlayingMovies' => $nowPlayingMovies
        ]);
    }

    public function show($movie_id)
    {
        $movieDetails = $this->movieService->showDetails($movie_id);
        return view('movies.show',[
            'movieDetails' => $movieDetails
        ]);
    }
}
