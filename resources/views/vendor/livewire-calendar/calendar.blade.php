<div
    @if ($pollMillis !== null && $pollAction !== null)
        wire:poll.{{ $pollMillis }}ms="{{ $pollAction }}"
    @elseif ($pollMillis !== null)
        wire:poll.{{ $pollMillis }}ms
    @endif
>
    <!-- Top slot (controls / header) -->
    <div class="mb-4">
        @includeIf ($beforeCalendarView)
    </div>

    <!-- Calendar Container -->
    <flux:card class="p-0 overflow-hidden rounded-3xl">
        <div class="overflow-x-auto w-full">
            <div class="inline-block min-w-full overflow-hidden">
                <!-- Day names -->
                <div
                    class="flex w-full border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900"
                >
                    @foreach ($monthGrid->first() as $day)
                        @include ($dayOfWeekView, ['day' => $day])
                    @endforeach
                </div>

                <!-- Weeks -->
                @foreach ($monthGrid as $week)
                    <div
                        class="flex w-full border-b border-zinc-200 dark:border-zinc-800 last:border-b-0"
                    >
                        @foreach ($week as $day)
                            @include ($dayView, [
                                'componentId' => $componentId,
                                'day' => $day,
                                'dayInMonth' => $day->isSameMonth($startsAt),
                                'isToday' => $day->isToday(),
                                'events' => $getEventsForDay($day, $events),
                            ])
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </flux:card>

    <!-- Bottom slot -->
    <div class="mt-4">
        @includeIf ($afterCalendarView)
    </div>
</div>
