<?php

namespace App\Http\Controllers;

use App\Services\MovieService;

class TVController extends Controller
{

    private $movieService;

    public function __construct()
    {
        $this->movieService = new MovieService();
    }
    
    public function index()
    {
        $popularTVShows = $this->movieService->getPopularTvShows();
        $topRatedTVShows = $this->movieService->getTopRatedTvShows();
        return view('tv.index',[
            'popularTVShows' => $popularTVShows,
            'topRatedTVShows' => $topRatedTVShows,
        ]);
    }

    public function show($id)
    {
        $tvShow = $this->movieService->showTVDetails($id);
        return view('tv.show',[
            'tvshow' => $tvShow,
        ]);
    }
}
