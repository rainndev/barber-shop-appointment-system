<div
    @if ($eventClickEnabled)
        wire:click.stop="onEventClick('{{ $event['id'] }}')"
    @endif
    class="cursor-pointer rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-3 py-2 shadow-sm transition hover:shadow-md"
>
    <flux:text
        class="text-xs font-semibold uppercase tracking-wider text-zinc-500"
    >
        {{ $event['description'] ?? 'No description' }}
    </flux:text>

    <flux:text
        class="mt-1 text-sm font-medium text-zinc-900 dark:text-zinc-100"
    >
        {{ $event['title'] }}
    </flux:text>
</div>
