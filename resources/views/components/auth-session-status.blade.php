@props ([
    'status' => null,
])

@if ($status)
    <div {{ $attributes->merge(['class' => 'mb-4']) }}>
        <flux:text class="text-green-300"> {{ $status }} </flux:text>
    </div>
@endif
