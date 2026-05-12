<flux:card
    class="flex-1 h-12 -mt-px -ml-px flex items-center justify-center bg-zinc-50 dark:bg-zinc-900"
>
    <flux:text
        class="text-[10px] font-semibold uppercase tracking-[0.14em] sm:text-xs text-zinc-600 dark:text-zinc-300"
    >
        {{ $day->format('l') }}
    </flux:text>
</flux:card>
