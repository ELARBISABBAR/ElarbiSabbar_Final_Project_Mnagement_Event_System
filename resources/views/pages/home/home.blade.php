@extends('layouts.index')

@section('content')
    <!-- Hero Section -->
    @include('pages.home.components.heroSection')

    <!-- Search and Filter Section -->
    <section class="bg-white py-8 border-b border-secondary-200">
        <div class="container-custom">
            <form method="GET" action="{{ route('home') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div class="lg:col-span-2">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search events, locations, or descriptions..."
                            class="form-input w-full"
                        >
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
    <section class="py-12 bg-secondary-50">
        <div class="container-custom">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-secondary-900 mb-4">
                    @if(request()->hasAny(['search', 'location', 'min_price', 'max_price', 'date_from', 'date_to']))
                        Search Results
                    @else
                        Upcoming Events
                    @endif
                </h2>
                <p class="text-secondary-600 max-w-2xl mx-auto">
                    Discover amazing events happening near you. From conferences to concerts, find your next great experience.
                </p>

                @if($events->total() > 0)
                    <p class="text-sm text-secondary-500 mt-2">
                        Showing {{ $events->firstItem() }}-{{ $events->lastItem() }} of {{ $events->total() }} events
                    </p>
                @endif
            </div>

            <!-- Events Grid -->
            @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
                    @foreach ($events as $event)
                        @include('pages.home.components.card')
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $events->appends(request()->query())->links() }}
                </div>
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
