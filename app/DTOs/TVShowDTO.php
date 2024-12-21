<?php
namespace App\DTOs;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class TVShowDTO
{
  public function __construct(
    public array $genres,
    public string $overview,
    public string $posterPath,
    public string $firstAirDate,
    public string $name,
    public float $voteAverage,
    public Collection $creators,
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
       Carbon::parse($data['first_air_date'])->format('M d, Y'),
       $data['name'],
       $data['vote_average'] * 10,
        self::getCreators($data['created_by']),
       count($data['videos']['results']) ? $data['videos']['results'][0]['key'] : '',
       self::getFirstFiveCasts($data['credits']['cast']),
       self::getFirstSixmages($data['images']['backdrops']),
    );
}

public static function getGenreNames($genres)
{
    return array_map(fn($genere) => $genere['name'], $genres);
}

public static function getCreators($creators)
{
    return collect($creators)->map(fn($creator) => 
   (object) [
        'name' =>  $creator['name'] ,
   ]);
}


public static function getFirstFiveCasts($casts)
{
    return array_map(fn($crew) =>[
        'id' => $crew['id'],
        'name' =>  $crew['name'] ,
        'character' => $crew['character'],
        'profile_path' => "https://image.tmdb.org/t/p/w300/" . $crew['profile_path']
    ],array_slice($casts,0,5));
}

public static function getFirstSixmages($images)
{
    return array_map(fn($image) =>[
        'path' => "https://image.tmdb.org/t/p/w500" . $image['file_path'],
        'original' =>  "https://image.tmdb.org/t/p/original" . $image['file_path'] 
    ],array_slice($images,0,9));
}
}