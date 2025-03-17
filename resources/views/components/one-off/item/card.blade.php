@props([
    'item' => null,
    'badges' => true,
    'info' => true
])

<div {{ $attributes->merge(['class' => 'flex flex-col relative']) }}>
    <div class="relative">
        <!-- Little bar thing on tha bottom -->
        <div class="absolute bottom-0 h-2 w-full {{ $item->is_special ? 'bg-[#f4ca47]/50' : 'bg-[rgba(79,_86,_96,_.50)]' }}"></div>
        <div class="bg-gradient-to-t border-[2px] {{ $item->is_special ? 'from-[#f4ca47]/30 border-[#efe5cc] dark:border-[#39352a]' : 'from-[rgba(79,_86,_96,_.50)] border-border-light dark:border-border-dark' }} to-transparent">
            <img class="w-full aspect-square" src="{{ $item->getRender() }}" />
            <a class="absolute top-0 left-0 w-full h-full" href="{{ route('item.profile', ['id' => $item->id]) }}"></a>
            <div class="absolute m-2 top-0 left-0 flex gap-2">
                @if ($badges == true)
                    @if (($item->isMaxCopies() && !$item->isSoldOut()) || $item->isScheduled())
                        @if ($item->isScheduled())
                            <x-one-off.item.timer-badge
                                :from="$item->available_from"
                                :to="$item->available_to"
                            />
                        @elseif ($item->isMaxCopies() && !$item->isSoldOut() && !$item->available_from?->isFuture())
                            <x-badge color="red" innerClass="flex items-center gap-1.5">
                                @svg('ri-shopping-bag-3-fill', [
                                    'class' => 'size-3.5'
                                ])
                                {{ Number::format($item->max_copies - $item->getCopies()) }} {{ __('left') }}
                            </x-badge>
                        @endif
                    @endif
                    @if (!$item->is_public)
                        <x-badge color="gray">
                            {{ __('Private') }}
                        </x-badge>
                    @endif
                @endif
            </div>
            <div class="absolute p-2 mb-2 bottom-0 left-0 flex gap-2 w-full justify-between">
            @if ($badges == true)
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
                    <x-badge color="special">
                        <span class="font-bold">Special</span>
                    </x-badge>
                @endif
            @endif
            </div>
        </div>
    </div>
    @if ($info == true)
        <a class="text-h5" href="{{ route('item.profile', ['id' => $item->id]) }}">{{ $item->getName() }}</a>
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
    @endif

</div>