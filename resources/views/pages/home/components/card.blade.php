<div class="event-card group">
    <!-- Event Image -->
    <div class="relative overflow-hidden">
        @if($event->image && file_exists(public_path('storage/img/' . $event->image)))
            <img
                src="{{ asset('storage/img/' . $event->image) }}"
                alt="{{ $event->title }}"
                class="event-card-image group-hover:scale-105 transition-transform duration-300"
            >
        @else
            <div class="w-full h-48 bg-gradient-primary flex items-center justify-center">
                <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif

        <!-- Price Badge -->
        <div class="absolute top-4 right-4">
            <span class="badge-primary text-lg font-bold px-3 py-1">
                ${{ number_format($event->price, 2) }}
            </span>
        </div>

        <!-- Date Badge -->
        <div class="absolute top-4 left-4">
            <div class="bg-white rounded-lg p-2 text-center shadow-soft">
                <div class="text-xs font-semibold text-secondary-600 uppercase">
                    {{ $event->date_start->format('M') }}
                </div>
                <div class="text-lg font-bold text-secondary-900">
                    {{ $event->date_start->format('d') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Event Content -->
    <div class="event-card-content">
        <!-- Event Title -->
        <h3 class="event-card-title">{{ $event->title }}</h3>

        <!-- Event Description -->
        <p class="event-card-description">{{ $event->description }}</p>

        <!-- Event Meta Information -->
        <div class="space-y-2 mb-4">
            <!-- Location -->
            <div class="event-card-meta">
                <svg class="w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="truncate">{{ $event->location }}</span>
            </div>

            <!-- Date and Time -->
            <div class="event-card-meta">
                <svg class="w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $event->date_start->format('M j, Y \a\t g:i A') }}</span>
            </div>

            <!-- Organizer -->
            <div class="event-card-meta">
                <svg class="w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>by {{ $event->user->name }}</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between">
            <!-- Ticket Count -->
            @php
                $ticketCount = $event->tickets->where('is_paid', true)->sum('quantity');
            @endphp
            <div class="text-sm text-secondary-500">
                @if($ticketCount > 0)
                    {{ $ticketCount }} {{ Str::plural('ticket', $ticketCount) }} sold
                @else
                    Be the first to book!
                @endif
            </div>

            <!-- Buy Button -->
            <form action="{{ route('ticket.show', $event) }}" method="get">
                <button type="submit" class="btn-primary btn-sm group-hover:bg-primary-700 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Buy Tickets
                </button>
            </form>
        </div>
    </div>
</div>


