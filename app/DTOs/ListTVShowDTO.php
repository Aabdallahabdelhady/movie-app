<?php
namespace App\DTOs;

use App\Helpers\MovieGenereHelper;
use Carbon\Carbon;

class ListTVShowDTO
{
    public function __construct(
        public array $genres,
        public int $id,
        public string $posterPath,
        public string $searchPoster,
        public string $firstAirDate,
        public string $name,
        public int $voteAverage,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
        self::getGenreNames($data['genre_ids']) ,
        $data['id'] ,
        $data['poster_path'] ? 'https://image.tmdb.org/t/p/w500/' . $data['poster_path'] : '' ,
        $data['poster_path'] ? 'https://image.tmdb.org/t/p/w92/' . $data['poster_path'] : '' ,
        Carbon::parse($data['first_air_date'])->format('M d, Y'),
        $data['name'] ,
        $data['vote_average'] * 10 ,
        );
    }

    public static function getGenreNames($genreIds): array
{
    return array_map(fn($id) => MovieGenereHelper::getTVGenreName($id), $genreIds);
}
}
