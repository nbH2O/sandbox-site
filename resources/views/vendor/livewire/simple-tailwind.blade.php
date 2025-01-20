@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<nav class="flex justify-center gap-2 items-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            @svg('ri-arrow-left-s-line', [
                'class' => 'size-5 text-muted-2'
            ])
        @else
            <span class="cursor-pointer" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}">
                @svg('ri-arrow-left-s-line', [
                    'class' => 'size-5 text-muted'
                ])
            </span>
        @endif

        <p class="text-muted">{{ __('Page') }} {{ $paginator->currentPage() }}</p>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <span class="cursor-pointer" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}">
                @svg('ri-arrow-right-s-line', [
                    'class' => 'size-5 text-muted'
                ])
            </span>
        @else
            @svg('ri-arrow-right-s-line', [
                'class' => 'size-5 text-muted-2'
            ])
        @endif
</nav>

