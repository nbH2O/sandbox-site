@if ($paginator->hasPages())
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        @svg('ri-arrow-left-s-line', [
            'class' => 'size-5 text-muted-2'
        ])
    @else
        <a href="{{ $paginator->previousPageUrl() }}">
            @svg('ri-arrow-left-s-line', [
                'class' => 'size-5'
            ])
        </a>
    @endif

    <p class="text-muted">{{ __('Page') }} {{ $paginator->currentPage() }}</p>

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}">
            @svg('ri-arrow-left-s-line', [
                'class' => 'size-5'
            ])
        </a>
    @else
        @svg('ri-arrow-right-s-line', [
            'class' => 'size-5 text-muted-2'
        ])
    @endif
@endif
