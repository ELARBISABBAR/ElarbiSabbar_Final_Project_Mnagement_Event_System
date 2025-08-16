@extends('layouts.index')

@section('content')
    <div class="min-h-screen bg-secondary-50 py-8">
        <div id="eventManagementView" class="container-custom">
            <!-- Page Header -->
            <div class="mb-8">


                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-secondary-900">Event Management</h1>
                        <p class="text-secondary-600 mt-2">Create and manage your events</p>
                    </div>
                    <button onclick="openEventModal()" class="btn-primary flex items-center space-x-2" type="button">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Add Event</span>
                    </button>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="alert-success mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-danger mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Information Banner -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-blue-800 font-medium">Your Event Management Dashboard</p>
                        <p class="text-blue-700 text-sm">This page shows only YOUR events. You currently have <strong>{{ $events->count() }}</strong> events total.</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="p-3 bg-primary-100 rounded-lg">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-secondary-600">Total Events</p>
                                <p class="text-2xl font-bold text-secondary-900">{{ $events->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="p-3 bg-success-100 rounded-lg">
                                <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-secondary-600">Tickets Sold</p>
                                <p class="text-2xl font-bold text-secondary-900">
                                    {{ $events->sum(function ($event) {return $event->tickets->where('is_paid', true)->sum('quantity');}) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center">
                            <div class="p-3 bg-warning-100 rounded-lg">
                                <svg class="w-6 h-6 text-warning-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-secondary-600">Total Revenue</p>
                                <p class="text-2xl font-bold text-secondary-900">
                                    ${{ number_format(
                                        $events->sum(function ($event) {
                                            return $event->tickets->where('is_paid', true)->sum(function ($ticket) {
                                                return $ticket->price * $ticket->quantity;
                                            });
                                        }),
                                        2,
                                    ) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Events Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-secondary-900">Your Events</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-secondary-200">
                        <thead class="bg-secondary-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                    Event
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                    Date & Location
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                    Category
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                    Tickets Sold
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-secondary-200">

                            @forelse ($events as $event)
                                <tr class="hover:bg-secondary-50 transition-colors duration-200">
                                    <!-- Event Info -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                @if ($event->image && file_exists(public_path('storage/img/' . $event->image)))
                                                    <img class="h-12 w-12 rounded-lg object-cover"
                                                        src="{{ asset('storage/img/' . $event->image) }}"
                                                        alt="{{ $event->title }}">
                                                @else
                                                    <div
                                                        class="h-12 w-12 rounded-lg bg-gradient-primary flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-secondary-900">{{ $event->title }}
                                                </div>
                                                <div class="text-sm text-secondary-500 line-clamp-1">
                                                    {{ Str::limit($event->description, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Date & Location -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-secondary-900">{{ $event->date_start->format('M j, Y') }}
                                        </div>
                                        <div class="text-sm text-secondary-500">{{ $event->date_start->format('g:i A') }}
                                        </div>
                                        <div class="text-sm text-secondary-500 mt-1">
                                            {{ Str::limit($event->location, 30) }}</div>
                                    </td>

                                    <!-- Price -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-secondary-900">
                                            ${{ number_format($event->price, 2) }}</div>
                                    </td>

                                    <!-- Category -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-secondary-900">
                                                @if($event->category)
                                                    @if($event->category->name == 'Conference') 🎤
                                                    @elseif($event->category->name == 'Workshop') 🛠️
                                                    @elseif($event->category->name == 'Networking') 🤝
                                                    @elseif($event->category->name == 'Entertainment') 🎉
                                                    @else 📅
                                                    @endif
                                                    {{ $event->category->name }}
                                                @else
                                                    <span class="text-gray-400">No category</span>
                                                @endif
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Tickets Sold -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $ticketsSold = $event->tickets->where('is_paid', true)->sum('quantity');
                                            $totalTickets = $event->tickets->sum('quantity');
                                        @endphp
                                        <div class="text-sm font-medium text-secondary-900">{{ $ticketsSold }}</div>
                                        <div class="text-sm text-secondary-500">of {{ $totalTickets }} total</div>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col space-y-1">
                                            <!-- Approval Status -->
                                            @if ($event->status === 'approved')
                                                <span class="badge-success">Approved</span>
                                            @elseif($event->status === 'rejected')
                                                <span class="badge-danger">Rejected</span>
                                            @else
                                                <span class="badge-warning">Pending Approval</span>
                                            @endif

                                            <!-- Visibility Status -->
                                            @if ($event->visibility === 'public')
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    🌍 Public
                                                </span>
                                            @elseif($event->visibility === 'private')
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    🔒 Private
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    👥 Members Only
                                                </span>
                                            @endif

                                            <!-- Event Date Status -->
                                            @if ($event->status === 'approved')
                                                @if ($event->date_start->isPast())
                                                    <span class="text-xs text-secondary-500">Completed</span>
                                                @elseif($event->date_start->isToday())
                                                    <span class="text-xs text-warning-600">Today</span>
                                                @else
                                                    <span class="text-xs text-success-600">Upcoming</span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <button onclick="editEvent({{ $event->id }})"
                                                class="text-primary-600 hover:text-primary-900 transition-colors duration-200"
                                                title="Edit Event">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <a href="{{ route('ticket.show', $event) }}"
                                                class="text-secondary-600 hover:text-secondary-900 transition-colors duration-200"
                                                title="View Event">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <button onclick="deleteEvent({{ $event->id }}, '{{ $event->title }}')"
                                                class="text-danger-600 hover:text-danger-900 transition-colors duration-200"
                                                title="Delete Event">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-secondary-400 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-secondary-900 mb-2">No events yet</h3>
                                            <p class="text-secondary-500 mb-4">Get started by creating your first event.
                                            </p>
                                            <button onclick="openEventModal()" class="btn-primary" type="button">
                                                Add Event
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar View Section -->
    <div id="calendarView" class="hidden">
        <div class="container-custom">
            <div class="bg-white rounded-xl shadow-soft overflow-hidden">
                <div class="p-6 border-b border-secondary-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-secondary-900">add Event and make something amazing !</h2>
                            <button onclick="hideCalendar()"
                                class="text-secondary-600 hover:text-secondary-800 text-sm mt-1">
                                ← Back to Event Management
                            </button>
                        </div>
                        <button onclick="hideCalendar()" class="text-secondary-400 hover:text-secondary-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>



    <!-- Create Event Modal -->
    <div id="eventModal"
        style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 99999; display: none; align-items: center; justify-content: center; padding: 20px;">
        <div
            style="background: white; border-radius: 20px; width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
            <form action="{{ route('event.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-8 py-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-medium text-gray-800">Add Event</h3>
                        <button type="button" onclick="closeEventModal()"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-8 py-6 space-y-6">
                    <!-- Event Title -->
                    <div>
                        <label class="block text-base font-normal text-gray-700 mb-3">Title</label>
                        <input type="text" name="title" id="create_title" required
                            class="w-full px-4 py-4 border-2 border-black rounded-2xl focus:border-black focus:outline-none transition-colors text-gray-700 text-base"
                            placeholder="insert event title">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Event Description -->
                    <div>
                        <label class="block text-base font-normal text-gray-700 mb-3">Description</label>
                        <textarea name="description" id="create_description" required rows="4"
                            class="w-full px-4 py-4 border-2 border-black rounded-2xl focus:border-black focus:outline-none transition-colors text-gray-700 resize-none text-base"
                            placeholder="add description ..."></textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date and Time -->
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-base font-normal text-gray-700 mb-3">start date</label>
                            <input type="datetime-local" name="date_start" id="create_date_start" required
                                class="w-full px-4 py-4 border-2 border-black rounded-2xl focus:border-black focus:outline-none transition-colors text-gray-700 text-base">
                            @error('date_start')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-base font-normal text-gray-700 mb-3">end date</label>
                            <input type="datetime-local" name="date_end" id="create_date_end" required
                                class="w-full px-4 py-4 border-2 border-black rounded-2xl focus:border-black focus:outline-none transition-colors text-gray-700 text-base">
                            @error('date_end')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Price and Location -->
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-base font-normal text-gray-700 mb-3">Price</label>
                            <input type="number" name="price" id="create_price" required step="0.01" min="0"
                                class="w-full px-4 py-4 border-2 border-black rounded-2xl focus:border-black focus:outline-none transition-colors text-gray-700 text-base"
                                placeholder="Price">
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-base font-normal text-gray-700 mb-3">location</label>
                            <input type="text" name="location" id="create_location" required
                                class="w-full px-4 py-4 border-2 border-black rounded-2xl focus:border-black focus:outline-none transition-colors text-gray-700 text-base"
                                placeholder="location">
                            @error('location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Event Visibility -->
                    <div>
                        <label class="block text-base font-normal text-gray-700 mb-3">Event Visibility</label>
                        <select name="visibility" id="create_visibility" required
                            class="w-full px-4 py-4 border-2 border-black rounded-2xl focus:border-black focus:outline-none transition-colors text-gray-700 text-base">
                            <option value="public">🌍 Public - Visible to everyone</option>
                            <option value="private">🔒 Private - Only logged-in users</option>
                            <option value="members_only">👥 Members Only - Invited users only</option>
                        </select>
                        @error('visibility')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Event Image -->
                    <div>
                        <label class="block text-base font-normal text-gray-700 mb-3">Add picture</label>
                        <div class="relative">
                            <input type="file" name="image" accept="image/*" id="imageInput" class="hidden">
                            <div onclick="document.getElementById('imageInput').click()"
                                class="w-full px-4 py-6 border-2 border-black rounded-2xl cursor-pointer hover:border-gray-600 transition-colors flex items-center justify-between">
                                <div class="flex items-center">
                                    <button type="button"
                                        class="px-4 py-2 border border-gray-400 rounded-lg text-gray-600 text-sm mr-4">
                                        Choisir un fichier
                                    </button>
                                    <span class="text-gray-500 text-base">Aucun fichier choisi</span>
                                </div>
                            </div>
                        </div>
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Event Category -->
                    <div>
                        <label class="block text-base font-normal text-gray-700 mb-3">Event Category *</label>
                        <select name="category_id" id="create_category_id" required
                            class="w-full px-4 py-4 border-2 border-black rounded-2xl focus:border-black focus:outline-none transition-colors text-gray-700 text-base">
                            <option value="">🏷️ Select a category...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    @if($category->name == 'Conference') 🎤
                                    @elseif($category->name == 'Workshop') 🛠️
                                    @elseif($category->name == 'Networking') 🤝
                                    @elseif($category->name == 'Entertainment') 🎉
                                    @else 📅
                                    @endif
                                    {{ $category->name }} - {{ $category->description }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="px-8 py-6">
                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-4 px-6 rounded-2xl transition-colors text-lg">
                        save
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <!-- Edit Event Modal -->
    <div id="editEventModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-large max-w-2xl w-full max-h-screen overflow-y-auto">
                <form id="editEventForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="px-6 py-4 border-b border-secondary-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-secondary-900">Edit Event</h3>
                            <button type="button" onclick="closeEditModal()"
                                class="text-secondary-400 hover:text-secondary-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="px-6 py-4 space-y-6">
                        <!-- Event Title -->
                        <div>
                            <label class="form-label">Event Title *</label>
                            <input type="text" name="title" id="edit_title" required class="form-input">
                        </div>

                        <!-- Event Description -->
                        <div>
                            <label class="form-label">Description *</label>
                            <textarea name="description" id="edit_description" required rows="4" class="form-input"></textarea>
                        </div>



                        <!-- Date and Time -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Start Date & Time *</label>
                                <input type="datetime-local" name="date_start" id="edit_date_start" required
                                    class="form-input">
                            </div>
                            <div>
                                <label class="form-label">End Date & Time *</label>
                                <input type="datetime-local" name="date_end" id="edit_date_end" required
                                    class="form-input">
                            </div>
                        </div>

                        <!-- Location and Price -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Location *</label>
                                <input type="text" name="location" id="edit_location" required class="form-input">
                            </div>
                            <div>
                                <label class="form-label">Price ($) *</label>
                                <input type="number" name="price" id="edit_price" required step="0.01"
                                    min="0" class="form-input">
                            </div>
                        </div>

                        <!-- Event Visibility -->
                        <div>
                            <label class="form-label">Event Visibility *</label>
                            <select name="visibility" id="edit_visibility" required class="form-input">
                                <option value="public">🌍 Public - Visible to everyone</option>
                                <option value="private">🔒 Private - Only logged-in users</option>
                                <option value="members_only">👥 Members Only - Invited users only</option>
                            </select>
                        </div>

                        <!-- Event Category -->
                        <div>
                            <label class="form-label">Event Category *</label>
                            <select name="category_id" id="edit_category_id" required class="form-input">
                                <option value="">🏷️ Select a category...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        @if($category->name == 'Conference') 🎤
                                        @elseif($category->name == 'Workshop') 🛠️
                                        @elseif($category->name == 'Networking') 🤝
                                        @elseif($category->name == 'Entertainment') 🎉
                                        @else 📅
                                        @endif
                                        {{ $category->name }} - {{ $category->description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Event Image -->
                        <div>
                            <label class="form-label">Event Image</label>
                            <input type="file" name="image" accept="image/*" class="form-input">
                            <p class="form-help">Upload a new image to replace the current one (optional)</p>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t border-secondary-200 flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" class="btn-outline-secondary">
                            Cancel
                        </button>
                        <button type="submit" class="btn-primary">
                            Update Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Simple and reliable modal functions
        function openEventModal() {
            const modal = document.getElementById('eventModal');
            if (modal) {
                // Clear the form when opening to prevent conflicts
                document.getElementById('create_title').value = '';
                document.getElementById('create_description').value = '';
                document.getElementById('create_date_start').value = '';
                document.getElementById('create_date_end').value = '';
                document.getElementById('create_price').value = '';
                document.getElementById('create_location').value = '';
                document.getElementById('create_visibility').value = 'public';
                document.getElementById('create_category_id').value = '';

                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

        function closeEventModal() {
            const modal = document.getElementById('eventModal');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        // Initialize modal functionality when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Handle escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeEventModal();
                }
            });

            // Handle click outside modal
            const modal = document.getElementById('eventModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeEventModal();
                    }
                });
            }
        });

        // Legacy function for backward compatibility
        function closeCreateModal() {
            // This will be handled by Alpine.js
            if (window.Alpine && window.Alpine.store) {
                // Use Alpine.js if available
            }
        }

        function openEditModal() {
            document.getElementById('editEventModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('editEventModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Edit event function
        function editEvent(eventId) {
            // Find the event data from the table or make an AJAX request
            fetch(`/event/${eventId}/edit`)
                .then(response => response.json())
                .then(event => {
                    document.getElementById('edit_title').value = event.title;
                    document.getElementById('edit_description').value = event.description;
                    document.getElementById('edit_date_start').value = event.date_start.slice(0, 16);
                    document.getElementById('edit_date_end').value = event.date_end.slice(0, 16);
                    document.getElementById('edit_location').value = event.location;
                    document.getElementById('edit_price').value = event.price;
                    document.getElementById('edit_visibility').value = event.visibility;
                    document.getElementById('edit_category_id').value = event.category_id;

                    document.getElementById('editEventForm').action = `/event/${eventId}`;
                    openEditModal();
                })
                .catch(error => {
                    console.error('Error fetching event data:', error);
                    alert('Error loading event data. Please try again.');
                });
        }

        // Delete event function
        function deleteEvent(eventId, eventTitle) {
            if (confirm(`Are you sure you want to delete "${eventTitle}"? This action cannot be undone.`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/event/${eventId}`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            const createModal = document.getElementById('createEventModal');
            const editModal = document.getElementById('editEventModal');

            if (event.target === createModal) {
                closeCreateModal();
            }
            if (event.target === editModal) {
                closeEditModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeCreateModal();
                closeEditModal();
                hideCalendar();
            }
        });

        // Calendar functions
        function showCalendar() {
            console.log('showCalendar called');
            const calendarView = document.getElementById('calendarView');
            const eventManagementView = document.getElementById('eventManagementView');

            if (calendarView && eventManagementView) {
                calendarView.classList.remove('hidden');
                eventManagementView.classList.add('hidden');
                initializeCalendar();
                console.log('Calendar view shown successfully');
            } else {
                console.error('Calendar view or event management view not found');
            }
        }

        function hideCalendar() {
            console.log('hideCalendar called');
            const calendarView = document.getElementById('calendarView');
            const eventManagementView = document.getElementById('eventManagementView');

            if (calendarView && eventManagementView) {
                calendarView.classList.add('hidden');
                eventManagementView.classList.remove('hidden');
                console.log('Calendar view hidden successfully');
            } else {
                console.error('Calendar view or event management view not found');
            }
        }

        // Initialize FullCalendar
        function initializeCalendar() {
            console.log('initializeCalendar called');
            const calendarEl = document.getElementById('calendar');
            console.log('Calendar element:', calendarEl);

            if (calendarEl && !calendarEl.hasChildNodes()) {
                console.log('Initializing FullCalendar...');

                if (typeof FullCalendar === 'undefined') {
                    console.error('FullCalendar is not loaded!');
                    return;
                }

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    views: {
                        dayGridMonth: {
                            buttonText: 'Month Events',
                        },
                        timeGridWeek: {
                            buttonText: 'Week Events'
                        },
                        timeGridDay: {
                            buttonText: 'Day Events',
                        },
                    },
                    initialView: "timeGridWeek",
                    slotMinTime: "09:00:00",
                    slotMaxTime: "18:00:00",
                    nowIndicator: true,
                    selectable: true,
                    selectMirror: true,
                    selectOverlap: true,
                    weekends: true,
                    events: [
                        @foreach ($events as $event)
                            {
                                title: '{{ $event->title }}',
                                start: '{{ $event->date_start->toISOString() }}',
                                end: '{{ $event->date_end->toISOString() }}',
                                backgroundColor: '{{ $event->category ? $event->category->color : '#3B82F6' }}',
                                borderColor: '{{ $event->category ? $event->category->color : '#3B82F6' }}',
                            },
                        @endforeach
                    ],
                    selectAllow: (info) => {
                        return info.start > new Date();
                    },
                    select: (info) => {
                        console.log('Calendar date selected:', info);

                        // Set the selected dates in the modal
                        const startDate = new Date(info.start);
                        const endDate = new Date(info.end);

                        // Format dates for datetime-local input
                        const formatForInput = (date) => {
                            const year = date.getFullYear();
                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const day = String(date.getDate()).padStart(2, '0');
                            const hours = String(date.getHours()).padStart(2, '0');
                            const minutes = String(date.getMinutes()).padStart(2, '0');
                            return `${year}-${month}-${day}T${hours}:${minutes}`;
                        };

                        // Set the form values - target the create modal specifically
                        const startInput = document.getElementById('create_date_start');
                        const endInput = document.getElementById('create_date_end');

                        if (startInput && endInput) {
                            startInput.value = formatForInput(startDate);
                            endInput.value = formatForInput(endDate);
                            console.log('Form dates set:', startInput.value, endInput.value);
                        } else {
                            console.error('Date input fields not found');
                        }

                        // Open the create modal
                        openCreateModal();
                        calendar.unselect();
                    }
                });

                calendar.render();
                console.log('FullCalendar rendered successfully');
            } else if (calendarEl && calendarEl.hasChildNodes()) {
                console.log('Calendar already initialized');
            } else {
                console.error('Calendar element not found');
            }
        }

        
    </script>
    </div>
@endsection
