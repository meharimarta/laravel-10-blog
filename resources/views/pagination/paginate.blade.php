@if ($paginator->hasPages())
    <div class="paginate-wrapper">
        <div class="paginate">
            {{-- previous psage url --}}
            @if($paginator->onFirstPage())
                <a href="" id="disabeld" disabled class="previous"><i class="fa fa-arrow-left"></i></a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="previous"><i class="fa fa-arrow-left"></i></a>
            @endif
                <p>
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="page-link">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-link">{{ $page }}</span>
                        @else
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
            </p>
            {{-- next page url --}}
            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="next"><i class="fa fa-arrow-right"></i></a>
            @else
                <a class="next" disabled id="disabeld"><i class="fa fa-arrow-right"></i></a>
            @endif
        </div>
    </div>
@endif