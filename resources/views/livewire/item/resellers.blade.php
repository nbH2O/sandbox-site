<div>
    <div class="flex gap-2 justify-between">
        <h4>{{ __('Resellers') }}</h4>
        <x-button wire:loading.attr="data-busy" size="sm">
            {{ __('List copy') }}
        </x-button>
    </div>
    <div class="">
        @if ($tabbed)
            @if (!$resellers->isEmpty())
                <div class="flex flex-col mt-3">
                    @foreach ($resellers as $reseller)
                        <div class="flex items-center justify-between border-t-2 border-border-light dark:border-border-dark">
                            <div class="flex gap-3 items-center">
                                <img class="size-28" src="{{ $reseller->user->getRender() }}" />
                                <div class="flex flex-col gap-1">
                                    <h6>{{ $reseller->user->getName() }}</h6>
                                    <p class="text-muted text-sm">#{{ $reseller->serial }}</p>
                                </div>
                            </div>
                            <x-button size="sm" color="primary">
                                @svg(config('site.currency_icon'), [
                                    'class' => 'size-4 -ms-1 me-2'
                                ])
                                {{ Number::format($reseller->resale_price) }}
                            </x-button>
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
