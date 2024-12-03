<?php
namespace App\DTOs;

use Carbon\Carbon;

class MovieDTO
{
  public function __construct(
    public array $genres,
    public string $overview,
    public string $posterPath,
    public string $releaseDate,
    public string $title,
    public float $voteAverage,
    public array $crews,
    public string $youtube_video_id,
    public array $casts,
    public array $images,
) {}


public static function fromArray(array $data): self
{
    return new self(
       self::getGenreNames($data['genres']),
       $data['overview'],
       "https://image.tmdb.org/t/p/w500/" . $data['poster_path'] ,
       Carbon::parse($data['release_date'])->format('M d, Y'),
       $data['title'],
       $data['vote_average'] * 10,
       self::getFirstTwoCrews($data['credits']['crew']),
       count($data['videos']['results']) ? $data['videos']['results'][0]['key'] : '',
       self::getFirstFiveCasts($data['credits']['cast']),
       self::getFirstSixmages($data['images']['backdrops']),
    );
}

public static function getGenreNames($genres)
{
    return array_map(fn($genere) => $genere['name'], $genres);
}

public static function getFirstTwoCrews($crews)
{
    return array_map(fn($crew) =>['name' =>  $crew['name'] ,'job' => $crew['job'] ],array_slice($crews,0,2));
}

public static function getFirstFiveCasts($casts)
{
    return array_map(fn($crew) =>[
        'name' =>  $crew['name'] ,
        'character' => $crew['character'],
        'profile_path' => "https://image.tmdb.org/t/p/w300/" . $crew['profile_path']
    ],array_slice($casts,0,5));
}

public static function getFirstSixmages($images)
{
    return array_map(fn($image) =>[
        'path' => "https://image.tmdb.org/t/p/w500/" . $image['file_path']
    ],array_slice($images,0,9));
}
}