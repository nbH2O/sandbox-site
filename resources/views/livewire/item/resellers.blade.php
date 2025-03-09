<div>
    <div class="flex gap-2 justify-between">
        <h4>{{ __('Resellers') }}</h4>
        @if (Auth::user())
            <x-button wire:loading.attr="data-busy" size="sm">
                {{ __('List copy') }}
            </x-button>
        @else
            <x-button x-on:click="window.location = '/auth/login';" wire:loading.attr="data-busy" size="sm">
                {{ __('List copy') }}
            </x-button>
        @endif
    </div>
    <div class="">
        @if ($tabbed)
            @if (!$resellers->isEmpty())
                <div class="flex flex-col mt-3">
                    @foreach ($resellers as $reseller)
                        <div class="flex items-center justify-between border-t-2 border-border-light dark:border-border-dark">
                            <div class="flex gap-3 items-center">
                                <a href="{{ route('user.profile', ['id' => $reseller->user->id]) }}">
                                    <img class="size-28" src="{{ $reseller->user->getRender() }}" />
                                </a>
                                <div class="flex flex-col gap-1">

                                    <a href="{{ route('user.profile', ['id' => $reseller->user->id]) }}">
                                        <h6>{{ $reseller->user->getName() }}</h6>
                                    </a>
                                    <p class="{{ $reseller->serial == 1 ? 'text-gold' : ($reseller->serial == 2 ? 'text-silver' : ($reseller->serial == 3 ? 'text-bronze' : 'text-muted-2')) }} text-sm">#{{ $reseller->serial }}</p>
                                    
                                </div>
                            </div>
                            <div class="flex gap-4 items-center">
                                @if ($reseller->is_for_trade == true)
                                    <a href="{{ route('user.trade', ['id' => $reseller->user->id]) }}" data-tooltip="{{ $reseller->user->getName() }} {{ __("has marked this item 'For Trade'") }}">
                                        @svg('ri-swap-2-fill', [
                                            'class' => 'size-6 text-green'
                                        ])
                                    </a>
                                @endif
                                <x-button size="sm" color="primary">
                                    @svg(config('site.currency_icon'), [
                                        'class' => 'size-4 -ms-1 me-2'
                                    ])
                                    {{ Number::format($reseller->resale_price) }}
                                </x-button>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $resellers->links(data: ['scrollTo' => false]) }}
            @else
                <x-one-off.header.bid-no-results
                    icon="ri-store-3-fill"
                    message="{{ __('Nobody is reselling this item right now') }}"
                />
            @endif
        @endif
    </div>
</div>
