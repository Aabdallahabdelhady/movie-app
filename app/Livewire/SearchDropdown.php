<?php

namespace App\Livewire;

use App\Services\MovieService;
use Livewire\Component;

class SearchDropdown extends Component
{
    public $search = '';
    protected $movieService;
    public function render()
    {
        $movies = collect([]);
        if($this->search)
        {
            $movies = app(MovieService::class)->searchMovies($this->search);
        }
        return view('livewire.search-dropdown',[
            'movies' => $movies
        ]);
    }
}
