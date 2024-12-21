<?php
namespace App\DTOs;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class ActorDTO
{
    public function __construct(
        public string $biography,
        public string $birthday,
        public int $age,
        public string $homePage,
        public int $id,
        public string $name,
        public string $placeOfBirth,
        public string $profilePath,
        public object $social,
        public Collection $knowForMovies, 
        public Collection $credits,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['biography'],
            $data['birthday'] ? Carbon::parse($data['birthday'])->format('M d, Y') : '',
            Carbon::parse($data['birthday'])->age,
            $data['homepage'] ?? '',
            $data['id'],
            $data['name'],
            $data['place_of_birth']?? '',
            "https://image.tmdb.org/t/p/w500/" . $data['profile_path'],
            self::getSocialMedia($data['external_ids']),
            self::getKnownForTitle(($data['combined_credits'])),
            self::credits($data['combined_credits']),
        );
    }


    static function getSocialMedia($data)
    {
        return (object)[
            'twitter' => $data['twitter_id']  ? 'https://twitter.com/' . $data['twitter_id'] : '',
            'instagram' => $data['instagram_id']  ? 'https://www.instagram.com/'. $data['instagram_id'] : '',
            'facebook' => $data['facebook_id']  ? 'https://www.facebook.com/'. $data['facebook_id'] : '',
        ];
    }

    static function getKnownForTitle($data)
    {
        $castMovies =  collect($data)->get('cast');
        return collect($castMovies)->where('media_type','movie')
                                   ->sortByDesc('popularity')
                                   ->take(5)
                                   ->map(fn($movie) => 
                                   (object)[
                                    'id' => $movie['id'],
                                    'posterPath' => $movie['poster_path'] ?
                                    "https://image.tmdb.org/t/p/w185" . $movie['poster_path']: 'https://via.placeholder.com/185x278' , 
                                    'title' => isset($movie['title']) ? $movie['title'] : 'untitled'
                                   ] 
                                );
    }


    static function credits($data)
    {
        $castMovies =  collect($data)->get('cast');
        return collect($castMovies)->where('media_type','movie')
                                   ->sortByDesc('release_date')
                                   ->map(function($movie){
                                    $releasDate = self::getCreditReleaseDate($movie);
                                    $name = self::getCreditName($movie);
                                   return  (object)[
                                        'releaseYear' => $releasDate ? Carbon::parse($releasDate)->format('Y') : 'Future',
                                        'title' => $name,
                                        'character' => isset($movie['character']) ? $movie['character'] : '',
                                       ] ;
                                   } 
                                 
                                );
    }

    public static function getCreditReleaseDate($data)
    {
        return match (true) {
            isset($data['release_date']) => $data['release_date'],
            isset($data['first_air_date']) => $data['first_air_date'],
            default => '',
        };
    }

    public static function getCreditName($data)
    {
        return match (true) {
            isset($data['title']) => $data['title'],
            isset($data['name']) => $data['name'],
            default => 'Untitled',
        };
    }
}
