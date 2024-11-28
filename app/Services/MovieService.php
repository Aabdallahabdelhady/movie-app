<?php
namespace App\Services;

use App\DTOs\ListMovieDTO;
use App\DTOs\MovieDTO;
use Illuminate\Support\Facades\Http;

class MovieService
{
  
  private $url;
  private $token;

  public function __construct()
  {
    $this->url = config('services.tmdb.url');
    $this->token = config('services.tmdb.token');
  }


  public function getPopularMovies($page = 1)
  {
    $popularMovies = Http::withToken($this->token)->get($this->url . "movie/popular?language=en-US&page=$page")->json();

    if(isset($popularMovies['results']))
    {
      return collect($popularMovies['results'])->map(fn($movie) => ListMovieDTO::fromArray($movie));
    }
    return [];
  }

  public function getNowPlayingMovies($page = 1)
  {
    $nowPlaying =  Http::withToken($this->token)->get($this->url . "movie/now_playing?page=$page")->json();
    if(isset($nowPlaying['results']))
    {
      return collect($nowPlaying['results'])->map(fn($movie) => ListMovieDTO::fromArray($movie));
    }
    return [];
  }


  public function showDetails($movie_id)
  {
    $movieDetails = Http::withToken($this->token)->get($this->url. "movie/$movie_id?append_to_response=credits,videos,images")->json();
    // dd($movieDetails);
    return MovieDTO::fromArray($movieDetails);
  }
}