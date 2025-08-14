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
            @php
                // Smart image selection based on event title and type
                $eventTitle = strtolower($event->title);
                $eventDescription = strtolower($event->description);

                // Define image categories with high-quality Unsplash images
                $imageCategories = [
                    'tech' => [
                        'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&h=400&fit=crop&crop=center', // Tech conference
                        'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800&h=400&fit=crop&crop=center', // Programming
                        'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=800&h=400&fit=crop&crop=center', // Innovation
                        'https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=800&h=400&fit=crop&crop=center', // Technology
                    ],
                    'music' => [
                        'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=400&fit=crop&crop=center', // Concert
                        'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&h=400&fit=crop&crop=center', // Music festival
                        'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=800&h=400&fit=crop&crop=center', // Live music
                        'https://images.unsplash.com/photo-1493676304819-0d7a8d026dcf?w=800&h=400&fit=crop&crop=center', // DJ/Electronic
                    ],
                    'business' => [
                        'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&h=400&fit=crop&crop=center', // Business meeting
                        'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=400&fit=crop&crop=center', // Conference room
                        'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=400&fit=crop&crop=center', // Presentation
                        'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&h=400&fit=crop&crop=center', // Team meeting
                    ],
                    'art' => [
                        'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&h=400&fit=crop&crop=center', // Art gallery
                        'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=800&h=400&fit=crop&crop=center', // Art exhibition
                        'https://images.unsplash.com/photo-1536924940846-227afb31e2a5?w=800&h=400&fit=crop&crop=center', // Creative workshop
                        'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=400&fit=crop&crop=center', // Art studio
                    ],
                    'food' => [
                        'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&h=400&fit=crop&crop=center', // Fine dining
                        'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=800&h=400&fit=crop&crop=center', // Wine tasting
                        'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800&h=400&fit=crop&crop=center', // Food festival
                        'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800&h=400&fit=crop&crop=center', // Cooking
                    ],
                    'fitness' => [
                        'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=400&fit=crop&crop=center', // Fitness class
                        'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=800&h=400&fit=crop&crop=center', // Yoga
                        'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=800&h=400&fit=crop&crop=center', // Gym workout
                        'https://images.unsplash.com/photo-1506629905607-d9c297d3d45f?w=800&h=400&fit=crop&crop=center', // Wellness
                    ],
                    'education' => [
                        'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800&h=400&fit=crop&crop=center', // Workshop
                        'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&h=400&fit=crop&crop=center', // Learning
                        'https://images.unsplash.com/photo-1513258496099-48168024aec0?w=800&h=400&fit=crop&crop=center', // Classroom
                        'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=400&fit=crop&crop=center', // Study group
                    ],
                    'networking' => [
                        'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=800&h=400&fit=crop&crop=center', // Networking event
                        'https://images.unsplash.com/photo-1528605248644-14dd04022da1?w=800&h=400&fit=crop&crop=center', // Social gathering
                        'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800&h=400&fit=crop&crop=center', // Professional meetup
                        'https://images.unsplash.com/photo-1506157786151-b8491531f063?w=800&h=400&fit=crop&crop=center', // Community event
                    ]
                ];

                // Determine category based on event title and description
                $selectedCategory = 'networking'; // default

                if (str_contains($eventTitle, 'tech') || str_contains($eventTitle, 'conference') ||
                    str_contains($eventTitle, 'innovation') || str_contains($eventTitle, 'digital') ||
                    str_contains($eventDescription, 'technology') || str_contains($eventDescription, 'programming')) {
                    $selectedCategory = 'tech';
                } elseif (str_contains($eventTitle, 'music') || str_contains($eventTitle, 'concert') ||
                         str_contains($eventTitle, 'festival') || str_contains($eventTitle, 'jazz') ||
                         str_contains($eventDescription, 'music') || str_contains($eventDescription, 'concert')) {
                    $selectedCategory = 'music';
                } elseif (str_contains($eventTitle, 'business') || str_contains($eventTitle, 'leadership') ||
                         str_contains($eventTitle, 'summit') || str_contains($eventTitle, 'startup') ||
                         str_contains($eventDescription, 'business') || str_contains($eventDescription, 'entrepreneur')) {
                    $selectedCategory = 'business';
                } elseif (str_contains($eventTitle, 'art') || str_contains($eventTitle, 'design') ||
                         str_contains($eventTitle, 'gallery') || str_contains($eventTitle, 'exhibition') ||
                         str_contains($eventDescription, 'art') || str_contains($eventDescription, 'creative')) {
                    $selectedCategory = 'art';
                } elseif (str_contains($eventTitle, 'food') || str_contains($eventTitle, 'wine') ||
                         str_contains($eventTitle, 'tasting') || str_contains($eventTitle, 'culinary') ||
                         str_contains($eventDescription, 'food') || str_contains($eventDescription, 'wine')) {
                    $selectedCategory = 'food';
                } elseif (str_contains($eventTitle, 'fitness') || str_contains($eventTitle, 'wellness') ||
                         str_contains($eventTitle, 'health') || str_contains($eventTitle, 'yoga') ||
                         str_contains($eventDescription, 'fitness') || str_contains($eventDescription, 'wellness')) {
                    $selectedCategory = 'fitness';
                } elseif (str_contains($eventTitle, 'workshop') || str_contains($eventTitle, 'masterclass') ||
                         str_contains($eventTitle, 'training') || str_contains($eventTitle, 'education') ||
                         str_contains($eventDescription, 'learn') || str_contains($eventDescription, 'workshop')) {
                    $selectedCategory = 'education';
                }

                // Select image based on event ID for consistency
                $images = $imageCategories[$selectedCategory];
                $imageIndex = $event->id % count($images);
                $selectedImage = $images[$imageIndex];
            @endphp
            <img
                src="{{ $selectedImage }}"
                alt="{{ $event->title }}"
                class="event-card-image group-hover:scale-105 transition-transform duration-300"
                loading="lazy"
            >
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


