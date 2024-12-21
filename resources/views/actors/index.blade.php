@extends('layouts.main')
@section('content')
    <div class="container mx-auto px-4 py-16">
        <div class="popular-actors">
            <h2 class="uppercase tracking-wider text-orange-400 text-lg font-semibold">
                popular actors
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-16">
                @foreach ($actors as $actor)
                    <div class="actor mt-8">
                        <a href="{{ route('actors.show', $actor->id) }}" target="_blank">
                            <img src="{{ $actor->profilePath }}" alt="profile image"
                                class="hover:opacity-75 transition ease-in-out duration-150">
                        </a>
                        <div class="mt-2">
                            <a href="{{ route('actors.show', $actor->id) }}" target="_blank"
                                class="text-lg hover:text-gray-300">{{ $actor->name }}</a>
                            <div class="text-sm truncate text-gray-400">{{ $actor->knownFor }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="page-load-status my-8">
            <div class="flex justify-center">
                <div class="infinite-scroll-request spinner my-8 text-4xl">&nbsp;</div>
            </div>
            <p class="infinite-scroll-last">End of content</p>
            <p class="infinite-scroll-error">Error</p>
        </div>
        {{-- <div class="flex justify-between mt-16">
            @if ($previousPage)
                <a href="/actors/page/{{ $previousPage }}">Previous</a>
            @else
                <div></div>
            @endif
            @if ($nextPage)
                <a href="/actors/page/{{ $nextPage }}">Next</a>
            @else
                <div></div>
            @endif
        </div> --}}
    @endsection
    @section('scripts')
        <script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>
        <script>
            let elem = document.querySelector('.grid');
            let infScroll = new InfiniteScroll(elem, {
                path: function() {
                    return `/actors/page/${this.pageIndex + 1}`;
                },
                append: '.actor',
                status: '.page-load-status'
            });
        </script>
    @endsection
