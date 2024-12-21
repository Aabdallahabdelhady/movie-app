<?php
namespace App\DTOs;

use Carbon\Carbon;

class ListActorDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $profilePath,
        public string $knownFor
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['profile_path'] ? 'https://image.tmdb.org/t/p/w500/' . $data['profile_path'] : 
            'https://ui-avatars.com/api/?size=235&name='.$data['name'] ,
            self::formatKnownFor($data['known_for']),
          );
      }
  
      static function formatKnownFor($data)
      {
        $data = collect($data);
        return $data->where('media_type','movie')->pluck('title')->union(
          $data->where('media_type','movie')->pluck('name')
        )->implode(',');
      }
}
