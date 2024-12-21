<?php
namespace Tests\Feature;


use Tests\TestCase;

class ViewMovieTest extends TestCase
{
    public function test_the_main_page_show_correct_info() :void
    {
        $response = $this->get(route('movie.index'));
        $response->assertSuccessful();
        $response->assertSee('popular movies');
    }
}
