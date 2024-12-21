@extends('layouts.main')
@section('content')
    <div class="tv-info border-b border-gray-800">
        <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
            <div class="flex-none">
                <img class="" src="{{ $tvshow->posterPath }}" alt="Abdullah" class="w-54 md:w-96" style="width: 24rem">
            </div>
            <div class="md:ml-24">
                <h2 class="text-4xl font-semibold">{{ $tvshow->name }}</h2>
                <div class="flex flex-wrap items-center text-gray-400 text-sm">
                    <svg class="fill-current text-orange-500 w-4" viewBox="0 0 24 24">
                        <g data-name="Layer 2">
                            <path
                                d="M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z"
                                data-name="star" />
                        </g>
                    </svg>
                    <span class="ml-1">{{ $tvshow->voteAverage . '%' }}</span>
                    <span class="mx-2">|</span>
                    <span>{{ $tvshow->firstAirDate }}</span>
                    <span class="mx-2">|</span>
                    <span>
                        @foreach ($tvshow->genres as $genre)
                            {{ $genre }}@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </span>

                </div>
                <p class="text-gray-300 mt-8">
                    {{ $tvshow->overview }}
                </p>

                <div class="mt-12">
                    <div class="flex mt-4">
                        @foreach ($tvshow->creators as $creator)
                            <div class="mr-8">
                                <div>{{ $creator->name }}</div>
                                <div class="text-gray-400 text-sm">Creator</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div x-data="{ isOpen: false }">
                    <div class="mt-12">
                        @if ($tvshow->youtube_video_id)
                            <button @click="isOpen = true"
                                href="https://youtube.com/watch?v={{ $tvshow->youtube_video_id }}"
                                class="inline-flex bg-orange-500 text-gray-900 rounded font-semibold px-5 py-4 hover:bg-orange-600 transition ease-in-out duration-150">
                                <svg class="w-6 fill-current" viewBox="0 0 24 24">
                                    <path d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M10 16.5l6-4.5-6-4.5v9zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
                                </svg>
                                <span class="ml-2">Play Trailer</span>
                            </button>
                        @endif
                    </div>
                    <div style="background-color: rgba(0, 0, 0, .5);"
                        class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                        x-show.transition.opacity="isOpen">
                        <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                            <div class="bg-gray-900 rounded">
                                <div class="flex justify-end pr-4 pt-2">
                                    <button @click="isOpen = false"
                                        class="text-3xl leading-none hover:text-gray-300">&times;
                                    </button>
                                </div>
                                <div class="modal-body px-8 py-8">
                                    <div class="responsive-container overflow-hidden relative" style="padding-top: 56.25%">
                                        <iframe class="responsive-iframe absolute top-0 left-0 w-full h-full"
                                            src="https://youtube.com/embed/{{ $tvshow->youtube_video_id }}"
                                            style="border:0;" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="movie-cast border-b border-gray-800">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-4xl font-semibold">Cast</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-16">
                @foreach ($tvshow->casts as $cast)
                    <div class="mt-8">
                        <a href="{{ route('actors.show', $cast['id']) }}" target="_blank">
                            <img src="{{ $cast['profile_path'] }}" alt="{{ $cast['name'] }}"
                                class="hover:opacity-75 transition ease-in-out duration-150" />
                        </a>

                        <div class="mt-2">
                            <a href="{{ route('actors.show', $cast['id']) }}" class="text-lg mt-2 hover:text-gray:300"
                                target="_blank">{{ $cast['name'] }}</a>
                            <div class="text-sm text-gray-400">
                                {{ $cast['character'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="movie-images" x-data="{ isOpen: false, image: '' }">
                <div class="container mx-auto px-4 py-16">
                    <h2 class="text-4xl font-semibold">Images</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                        @foreach ($tvshow->images as $image)
                            <div class="mt-8">
                                <a @click.prevent="isOpen = true; image = '{{ $image['original'] }}'" href="#">
                                    <img src="{{ $image['path'] }}" alt="{{ $tvshow->name }}"
                                        class="hover:opacity-75 transition ease-in-out duration-150" />
                                </a>
                            </div>
                        @endforeach

                    </div>
                    <div style="background-color: rgba(0, 0, 0, .5);"
                        class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                        x-show.transition.opacity="isOpen">
                        <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                            <div class="bg-gray-900 rounded">
                                <div class="flex justify-end pr-4 pt-2">
                                    <button @click="isOpen = false" @keydown.escape.window="isOpen = false"
                                        class="text-3xl leading-none hover:text-gray-300">&times;
                                    </button>
                                </div>
                                <div class="modal-body px-8 py-8">
                                    <img :src="image" alt="poster">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection