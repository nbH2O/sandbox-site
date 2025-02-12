@php
    $sidebarLinks = [
        'Site Managements' => [
            'Banners' => '/create-item',
            'Maintenance' => '/create-item',
            'Features' => '/create-item',
        ],
        'Item Managements' => [
            'Moderate' => '/create-item',
            'Create' => '/create-item',
        ],
        'User Management' => [
            'Moderate' => '/create-item',
            'Delete' => '/create-item'
        ],
    ];
@endphp

<x-layout.app title="Admin Panele" containerClass="max-w-full w-[60rem]">
    <div class="flex gap-4 grow">
        <div class="flex border-r border-border-light dark:border-border-dark">
            <ul class="block sticky">
                @foreach ($sidebarLinks as $key => $val)
                    @if (is_array($val))
                        <div class="mb-4">
                            <p class="">{{ $key }}</p>
                            @foreach ($val as $key => $val)
                                <li class="text-muted">
                                    <span>
                                        <span class="text-muted-2 select-none">
                                            └
                                            &nbsp;
                                        </span>
                                        <a href="{{ '/admin/panel'.$val }}">
                                            {{ $key }}
                                        </a>
                                    </span>
                                </li>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </ul>
            <div class="w-4"></div>
        </div>
        <div class="grow">
            {{ $slot }}
        </div>
    </div>
</x-layout.app>