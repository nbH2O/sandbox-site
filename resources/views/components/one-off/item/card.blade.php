@props([
    'item' => null
])

<div class="flex flex-col relative">
    <x-card class="!p-0 relative">
        <img class="w-full bg-glow aspect-square" src="{{ $item->getRender() }}" />
        <a class="absolute top-0 left-0 w-full h-full" href="{{ '/$'.$item->id }}"></a>
        <div class="absolute m-2 top-0 left-0 flex gap-2">
            @if (($item->isMaxCopies() && !$item->isSoldOut()) || $item->isScheduled())
                @if ($item->isMaxCopies() && !$item->isSoldOut() && !$item->available_from?->isFuture())
                    <x-badge color="red" innerClass="flex items-center gap-1.5">
                        @svg('ri-shopping-bag-3-fill', [
                            'class' => 'size-3.5'
                        ])
                        {{ Number::format($item->max_copies - $item->getCopies()) }} {{ __('left') }}
                    </x-badge>
                @elseif ($item->isScheduled())
                    <x-one-off.item.timer-badge
                        :from="$item->available_from"
                        :to="$item->available_to"
                    />
                @endif
            @endif
        </div>
        <div class="absolute p-2 bottom-0 left-0 flex gap-2 w-full justify-between">
        @if ($item->isPurchasable())
            <x-badge color="primary" innerClass="flex items-center gap-1.5">
                @svg('ri-vip-diamond-fill', [
                    'class' => 'size-3.5'
                ])
                {{ $item->price > 0 ? Number::format($item->price) : __('Free') }}
            </x-badge>
        @elseif ($item->isTradeable())
            @if ($item->with('cheapestReseller') && $item->cheapestReseller)
                <x-badge color="primary" innerClass="flex items-center gap-1.5">
                    @svg('ri-vip-diamond-fill', [
                        'class' => 'size-3.5'
                    ])
                    {{ $item->cheapestReseller->resale_price > 0 ? $item->cheapestReseller->resale_price : __('Free') }}
                </x-badge>
            @endif
        @else
            <div>
            </div>
        @endif
        @if ($item->is_special)
            <x-badge color="special" innerClass="flex items-center gap-1.5">
                @svg('ri-bard-fill', [
                    'class' => 'size-3.5'
                ])
            </x-badge>
        @endif
        </div>
    </x-card>
    <a class="text-h5" href="{{ '/$'.$item->id }}">{{ $item->getName() }}</a>
    <p class="flex gap-1 text-muted -mt-1 text-sm items-center">
        by 
        @if ($item->creator->id === config('site.main_account_id'))
                @svg('ri-planet-fill', [
                    'class' => 'text-primary size-4'
                ])
            @endif
        <a class="z-50" href="{{ $item->creator->getLink() }}">
            {{ $item->creator->getName() }}
        </a>
    </p>

</div>