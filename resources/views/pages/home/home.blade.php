@extends('layouts.index')

@section('content')
    <!-- Hero Section -->
    @include('pages.home.components.heroSection')

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 container-custom" role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold">Success!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 container-custom" role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold">Error!</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Search and Filter Section -->
    <section id="events" class="bg-white py-8 border-b border-secondary-200">
        <div class="container-custom">
            <form method="GET" action="{{ route('home') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Search Input -->
                    <div class="lg:col-span-2">
                        <input
                            type="text"
                            name="search"
                            id="liveSearchInput"
                            value="{{ request('search') }}"
                            placeholder="Search events, locations, or descriptions..."
                            class="form-input w-full"
                            autocomplete="off"
                        >
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <select name="category" class="form-input w-full">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location Filter -->
                    <div>
                        <select name="location" class="form-input w-full">
                            <option value="">All Locations</option>
                            @foreach($locations as $location)
                                <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                    {{ $location }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search Button -->
                    <div>
                        <button type="submit" class="btn-primary w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search Events
                        </button>
                    </div>
                </div>

                <!-- Advanced Filters (Collapsible) -->
                <div x-data="{ showFilters: false }" class="space-y-4">
                    <button
                        type="button"
                        @click="showFilters = !showFilters"
                        class="text-primary-600 hover:text-primary-700 text-sm font-medium flex items-center"
                    >
                        <span x-text="showFilters ? 'Hide Filters' : 'Show More Filters'"></span>
                        <svg class="w-4 h-4 ml-1 transform transition-transform" :class="{ 'rotate-180': showFilters }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="showFilters" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Price Range -->
                        <div>
                            <label class="form-label">Min Price</label>
                            <input
                                type="number"
                                name="min_price"
                                value="{{ request('min_price') }}"
                                placeholder="0"
                                class="form-input"
                                min="0"
                                step="0.01"
                            >
                        </div>

                        <div>
                            <label class="form-label">Max Price</label>
                            <input
                                type="number"
                                name="max_price"
                                value="{{ request('max_price') }}"
                                placeholder="1000"
                                class="form-input"
                                min="0"
                                step="0.01"
                            >
                        </div>

                        <!-- Date Range -->
                        <div>
                            <label class="form-label">From Date</label>
                            <input
                                type="date"
                                name="date_from"
                                value="{{ request('date_from') }}"
                                class="form-input"
                            >
                        </div>

                        <div>
                            <label class="form-label">To Date</label>
                            <input
                                type="date"
                                name="date_to"
                                value="{{ request('date_to') }}"
                                class="form-input"
                            >
                        </div>
                    </div>
                </div>

                <!-- Clear Filters -->
                @if(request()->hasAny(['search', 'location', 'min_price', 'max_price', 'date_from', 'date_to']))
                    <div class="flex justify-end">
                        <a href="{{ route('home') }}" class="btn-outline-secondary">
                            Clear All Filters
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </section>

    <!-- Events Section -->
    <section class="py-16 bg-gradient-to-br from-secondary-50 to-white">
        <div class="container-custom">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-100 rounded-full mb-6">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-secondary-900 mb-6">
                    @if(request()->hasAny(['search', 'location', 'min_price', 'max_price', 'date_from', 'date_to']))
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-accent-500">Search Results</span>
                    @else
                        All <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-accent-500">Events</span>
                    @endif
                </h2>


            </div>

            <!-- Events Grid -->
            @if($events->count() > 0)
                <div id="eventsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-8">
                    @foreach ($events as $event)
                        @include('pages.home.components.card')
                    @endforeach
                </div>

                <!-- Event Count Indicator - Moved below events grid -->
                <div id="eventCountIndicator" class="flex justify-center mb-8">
                    <div class="inline-flex items-center px-4 py-2 bg-white rounded-full shadow-sm border border-secondary-200">
                        <svg class="w-5 h-5 text-primary-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span id="eventCountText" class="text-sm font-medium text-secondary-700">
                            Showing {{ $events->firstItem() }}-{{ $events->lastItem() }} of {{ $events->total() }} events
                        </span>
                    </div>
                </div>

                <!-- No Results Message (Hidden by default) -->
                <div id="noResultsMessage" class="text-center py-12 hidden">
                    <svg class="w-16 h-16 text-secondary-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-secondary-900 mb-2">No events found</h3>
                    <p class="text-secondary-600 max-w-md mx-auto">
                        We couldn't find any events matching your search. Try adjusting your search terms or browse all events.
                    </p>
                    <button id="clearSearchBtn" class="mt-4 btn-primary">
                        Clear Search
                    </button>
                </div>

                <!-- Pagination - Only show when more than 4 events -->
                @if($events->total() > 4)
                    {{-- <div class="flex justify-center">
                        <div class="bg-white rounded-xl shadow-soft border border-secondary-200 p-4">
                            {{ $events->appends(request()->query())->links() }}
                        </div>
                    </div> --}}
                @endif
            @else
                <!-- No Events Found -->
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-secondary-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-secondary-900 mb-2">No Events Found</h3>
                    <p class="text-secondary-600 mb-6">
                        @if(request()->hasAny(['search', 'location', 'min_price', 'max_price', 'date_from', 'date_to']))
                            Try adjusting your search criteria or clearing the filters.
                        @else
                            There are no upcoming events at the moment. Check back soon!
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'location', 'min_price', 'max_price', 'date_from', 'date_to']))
                        <a href="{{ route('home') }}" class="btn-primary">
                            View All Events
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Additional Sections -->
    @include("pages.home.components.infos")
    @include('pages.home.components.statistic')
    @include('pages.home.components.sponsor')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('liveSearchInput');
    const eventsGrid = document.getElementById('eventsGrid');
    const eventCountIndicator = document.getElementById('eventCountIndicator');
    const eventCountText = document.getElementById('eventCountText');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const clearSearchBtn = document.getElementById('clearSearchBtn');

    let allEvents = [];
    let searchTimeout;

    // Store original event data
    if (eventsGrid) {
        allEvents = Array.from(eventsGrid.querySelectorAll('.event-card'));
    }

    // Store original count text
    const originalCountText = eventCountText ? eventCountText.textContent : '';
    const totalEvents = allEvents.length;

    // Real-time search function
    function performLiveSearch(searchTerm) {
        const query = searchTerm.toLowerCase().trim();

        // Add visual feedback for active search
        if (query !== '') {
            searchInput.classList.add('ring-2', 'ring-primary-200', 'border-primary-300');
        } else {
            searchInput.classList.remove('ring-2', 'ring-primary-200', 'border-primary-300');
        }

        if (query === '') {
            // Show all events when search is empty
            showAllEvents();
            return;
        }

        let visibleEvents = [];

        allEvents.forEach(eventCard => {
            const title = eventCard.dataset.title || '';
            const description = eventCard.dataset.description || '';
            const location = eventCard.dataset.location || '';
            const category = eventCard.dataset.category || '';
            const organizer = eventCard.dataset.organizer || '';

            // Check if search term matches any of the searchable fields
            const matches = title.includes(query) ||
                          description.includes(query) ||
                          location.includes(query) ||
                          category.includes(query) ||
                          organizer.includes(query);

            if (matches) {
                eventCard.style.display = 'block';
                eventCard.classList.remove('hidden');
                visibleEvents.push(eventCard);
            } else {
                eventCard.style.display = 'none';
                eventCard.classList.add('hidden');
            }
        });

        // Update count and show/hide no results message
        updateEventCount(visibleEvents.length, query);

        if (visibleEvents.length === 0) {
            showNoResults();
        } else {
            hideNoResults();
        }
    }

    // Show all events
    function showAllEvents() {
        allEvents.forEach(eventCard => {
            eventCard.style.display = 'block';
            eventCard.classList.remove('hidden');
        });

        // Restore original count
        if (eventCountText) {
            eventCountText.textContent = originalCountText;
        }

        hideNoResults();
    }

    // Update event count display
    function updateEventCount(visibleCount, searchTerm) {
        if (eventCountText) {
            if (searchTerm) {
                eventCountText.textContent = `Showing ${visibleCount} of ${totalEvents} events for "${searchTerm}"`;
            } else {
                eventCountText.textContent = originalCountText;
            }
        }
    }

    // Show no results message
    function showNoResults() {
        if (noResultsMessage) {
            noResultsMessage.classList.remove('hidden');
        }
        if (eventCountIndicator) {
            eventCountIndicator.classList.add('hidden');
        }
    }

    // Hide no results message
    function hideNoResults() {
        if (noResultsMessage) {
            noResultsMessage.classList.add('hidden');
        }
        if (eventCountIndicator) {
            eventCountIndicator.classList.remove('hidden');
        }
    }

    // Clear search function
    function clearSearch() {
        if (searchInput) {
            searchInput.value = '';
            searchInput.classList.remove('ring-2', 'ring-primary-200', 'border-primary-300');
            showAllEvents();
            searchInput.focus();
        }
    }

    // Event listeners
    if (searchInput) {
        // Real-time search with debouncing
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performLiveSearch(e.target.value);
            }, 150); // 150ms debounce for better performance
        });

        // Handle paste events
        searchInput.addEventListener('paste', function(e) {
            setTimeout(() => {
                performLiveSearch(e.target.value);
            }, 10);
        });

        // Handle clear button (X) in search input
        searchInput.addEventListener('search', function(e) {
            if (e.target.value === '') {
                showAllEvents();
            }
        });
    }

    // Clear search button
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', clearSearch);
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const searchParam = urlParams.get('search');
        if (searchInput && searchParam !== searchInput.value) {
            searchInput.value = searchParam || '';
            performLiveSearch(searchInput.value);
        }
    });

    // Initialize search if there's a value in the input
    if (searchInput && searchInput.value.trim() !== '') {
        performLiveSearch(searchInput.value);
    }
});
</script>
@endpush
