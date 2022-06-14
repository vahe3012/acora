@if ($paginator->hasPages())
    <div class="pagination-box text-center">
        <ul>
            @if (!$paginator->onFirstPage())
            <li class="arrow left">
                <a class="" href="{{ $paginator->previousPageUrl() }}">
                    <i class='fas fa-angle-left'></i>
                </a>
            </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}


                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)

                        <li>
                            <a class="{{$page == $paginator->currentPage() ? 'active' : ''}}" href="{{$url}}">{{ $page }}</a>
                        </li>
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
            <li class="arrow right">
                <a href="{{ $paginator->nextPageUrl() }}">
                    <i class='fas fa-angle-right'></i>
                </a>
            </li>
                @endif
        </ul>
    </div>
@endif
