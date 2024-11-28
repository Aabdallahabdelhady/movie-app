<?php
namespace App\DTOs;

use App\Helpers\MovieGenereHelper;
use Carbon\Carbon;

class ListMovieDTO
{
  public function __construct(
    public array $genres,
    public int $id,
    public string $posterPath,
    public string $releaseDate,
    public string $title,
    public int $voteAverage,
) {}


public static function fromArray(array $data): self
{
    return new self(
        self::getGenreNames($data['genre_ids']) ,
        $data['id'] ,
        "https://image.tmdb.org/t/p/w500/" . $data['poster_path'] ,
        Carbon::parse($data['release_date'])->format('M d, Y'),
        $data['title'] ,
        $data['vote_average'] * 10 ,
    );
}

public static function getGenreNames($genreIds): array
{
    return array_map(fn($id) => MovieGenereHelper::getGenreName($id), $genreIds);
}

}