<?php
namespace App\Services;

use App\DTOs\ActorDTO;
use App\DTOs\ListActorDTO;
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
    return MovieDTO::fromArray($movieDetails);
  }


  public function searchMovies($search)
  {
    $searchResults = Http::withToken($this->token)->get($this->url. "search/movie?query=$search")->json();
    if(isset($searchResults['results']))
    {
      return collect(array_slice($searchResults['results'],0,7))->map(fn($movie) => ListMovieDTO::fromArray($movie));
    }
    return [];
  }


  public function getPopularActors($page = 1)
  {
    $popularActors = Http::withToken($this->token)->get($this->url . "person/popular?language=en-US&page=$page")->json();
    if(isset($popularActors['results']))
    {
      return collect($popularActors['results'])->map(fn($actor) => ListActorDTO::fromArray($actor));
    }
    return [];
  }


  public function showActor($id)
  {
    $actor = Http::withToken($this->token)->get($this->url . "person/$id?append_to_response=external_ids,combined_credits")->json();
    return ActorDTO::fromArray($actor);
  }
}