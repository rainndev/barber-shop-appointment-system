<div
    ondragenter="onLivewireCalendarEventDragEnter(event, '{{ $componentId }}', '{{ $day }}', '{{ $dragAndDropClasses }}');"
    ondragleave="onLivewireCalendarEventDragLeave(event, '{{ $componentId }}', '{{ $day }}', '{{ $dragAndDropClasses }}');"
    ondragover="onLivewireCalendarEventDragOver(event)"
    ondrop="onLivewireCalendarEventDrop(event, '{{ $componentId }}', '{{ $day }}', {{ $day->year }}, {{ $day->month }}, {{ $day->day }}, '{{ $dragAndDropClasses }}');"
    class="flex-1 min-h-32 sm:h-40 lg:h-48 -mt-px -ml-px border border-zinc-200 dark:border-zinc-800"
    style="min-width: 0"
>
    <div
        class="w-full h-full flex flex-col p-2 sm:p-2
        {{ $dayInMonth ? ($isToday ? 'bg-red-50 dark:bg-red-950/20' : 'bg-white dark:bg-zinc-900') : 'bg-zinc-100/60 dark:bg-zinc-800/40' }}"
        id="{{ $componentId }}-{{ $day }}"
    >
        <!-- Header -->
        <div
            class="flex items-center justify-between gap-2 border-b border-zinc-100 dark:border-zinc-800 pb-1.5"
        >
            <flux:text
                class="text-xs sm:text-sm font-semibold {{ $dayInMonth ? 'text-zinc-900 dark:text-zinc-100' : 'text-zinc-400' }}"
            >
                {{ $day->format('j') }}
            </flux:text>

            @if ($events->isNotEmpty())
                <flux:badge
                    color="red"
                    size="sm"
                    icon:trailing="document-text"
                    class="**:data-flux-icon:size-3"
                >
                    {{ $events->count() }} {{ Str::plural('event', $events->count()) }}
                </flux:badge>
            @endif
        </div>

        <!-- Events -->
        <div class="my-2 flex-1 overflow-y-auto hide-scrollbar">
            <div class="grid gap-2">
                @foreach ($events as $event)
                    <div
                        @if ($dragAndDropEnabled)
                            draggable="true"
                        @endif
                        ondragstart="onLivewireCalendarEventDragStart(event, '{{ $event['id'] }}')"
                    >
                        @include ($eventView, ['event' => $event])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
