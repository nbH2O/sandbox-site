@props([
    'code' => null,
    'title' => null,
    'message' => null
])

<x-layout.app
    containerClass="w-[40rem]"
    title="{{ $title ?? $code }}"
>
    <h1>{{ $code }}</h1>
    <h5>{{ $title }}</h5>
    <p>{{ $message }}</p>
</x-layout.app>