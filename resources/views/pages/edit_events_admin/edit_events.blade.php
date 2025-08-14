@extends('layouts.admin_organizer')

@section('content2')
<div class="min-h-screen bg-secondary-50 py-8">
    <div class="container-custom">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-secondary-900">Event Management</h1>
                    <p class="text-secondary-600 mt-2">Manage all events across the platform</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-secondary-600">
                        Total Events: <span class="font-semibold text-secondary-900">{{ $events->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            @php
                $totalEvents = $events->count();
                $upcomingEvents = $events->where('date_start', '>', now())->count();
                $pastEvents = $events->where('date_start', '<', now())->count();
                $todayEvents = $events->where('date_start', '>=', now()->startOfDay())->where('date_start', '<=', now()->endOfDay())->count();
            @endphp

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="p-3 bg-primary-100 rounded-lg">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Total Events</p>
                            <p class="text-2xl font-bold text-secondary-900">{{ $totalEvents }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="p-3 bg-success-100 rounded-lg">
                            <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Upcoming</p>
                            <p class="text-2xl font-bold text-secondary-900">{{ $upcomingEvents }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="p-3 bg-warning-100 rounded-lg">
                            <svg class="w-6 h-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Today</p>
                            <p class="text-2xl font-bold text-secondary-900">{{ $todayEvents }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="p-3 bg-secondary-100 rounded-lg">
                            <svg class="w-6 h-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Completed</p>
                            <p class="text-2xl font-bold text-secondary-900">{{ $pastEvents }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Events Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-secondary-900">All Events</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-200">
                    <thead class="bg-secondary-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                Event Details
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                Organizer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                Date & Location
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-secondary-200">
                        @forelse($events as $event)
                            <tr class="hover:bg-secondary-50 transition-colors duration-200">
                                <!-- Event Details -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            @if($event->image && file_exists(public_path('storage/img/' . $event->image)))
                                                <img class="h-12 w-12 rounded-lg object-cover" src="{{ asset('storage/img/' . $event->image) }}" alt="{{ $event->title }}">
                                            @else
                                                <div class="h-12 w-12 rounded-lg bg-gradient-primary flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-secondary-900">{{ $event->title }}</div>
                                            <div class="text-sm text-secondary-500">ID: {{ $event->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Organizer -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-primary-600">{{ substr($event->user->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-secondary-900">{{ $event->user->name }}</div>
                                            <div class="text-sm text-secondary-500">{{ $event->user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Date & Location -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-secondary-900">{{ $event->date_start->format('M j, Y') }}</div>
                                    <div class="text-sm text-secondary-500">{{ $event->date_start->format('g:i A') }}</div>
                                    <div class="text-sm text-secondary-500 mt-1">{{ Str::limit($event->location, 30) }}</div>
                                </td>

                                <!-- Price -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-secondary-900">${{ number_format($event->price, 2) }}</div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($event->date_start->isPast())
                                        <span class="badge-secondary">Completed</span>
                                    @elseif($event->date_start->isToday())
                                        <span class="badge-warning">Today</span>
                                    @else
                                        <span class="badge-success">Upcoming</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a
                                            href="{{ route('ticket.show', $event) }}"
                                            class="text-secondary-600 hover:text-secondary-900 transition-colors duration-200"
                                            title="View Event"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>

                                        <button
                                            onclick="editEvent({{ $event->id }})"
                                            class="text-primary-600 hover:text-primary-900 transition-colors duration-200"
                                            title="Edit Event"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>

                                        <button
                                            onclick="deleteEvent({{ $event->id }}, '{{ $event->title }}')"
                                            class="text-danger-600 hover:text-danger-900 transition-colors duration-200"
                                            title="Delete Event"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-secondary-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <h3 class="text-lg font-medium text-secondary-900 mb-2">No events found</h3>
                                        <p class="text-secondary-500">No events have been created yet.</p>
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

<script>
    // Edit event function
    function editEvent(eventId) {
        // Redirect to edit page or open modal
        window.location.href = `/event/${eventId}/edit`;
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
</script>
@endsection
