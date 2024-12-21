<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    private $movieService;
    public function __construct()
    {
        $this->movieService = new MovieService();
    }
   
    public function index($page = 1)
    {
        abort_if($page > 500 , 204);
        $actors = $this->movieService->getPopularActors($page);
        return view('actors.index',[
            'actors' => $actors,
        ]);
    }

    public function show($id)
    {
        $actor = $this->movieService->showActor($id);
        return view('actors.show',[
            'actor' => $actor,
        ]);
    }

}
