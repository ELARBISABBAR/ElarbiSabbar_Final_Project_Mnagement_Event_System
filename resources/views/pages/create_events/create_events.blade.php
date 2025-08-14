@extends('layouts.index')

@section('content')
<div class="min-h-screen bg-secondary-50 py-8">
    <div class="container-custom">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-secondary-900">Event Management</h1>
                    <p class="text-secondary-600 mt-2">Create and manage your events</p>
                </div>
                <button
                    onclick="openCreateModal()"
                    class="btn-primary flex items-center space-x-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Create New Event</span>
                </button>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert-success mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-danger mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
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
                            <p class="text-2xl font-bold text-secondary-900">{{ $events->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="p-3 bg-success-100 rounded-lg">
                            <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Tickets Sold</p>
                            <p class="text-2xl font-bold text-secondary-900">
                                {{ $events->sum(function($event) { return $event->tickets->where('is_paid', true)->sum('quantity'); }) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="p-3 bg-warning-100 rounded-lg">
                            <svg class="w-6 h-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Total Revenue</p>
                            <p class="text-2xl font-bold text-secondary-900">
                                ${{ number_format($events->sum(function($event) {
                                    return $event->tickets->where('is_paid', true)->sum(function($ticket) {
                                        return $ticket->price * $ticket->quantity;
                                    });
                                }), 2) }}
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                Event
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                Date & Location
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                Tickets Sold
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

                        @forelse ($events as $event)
                            <tr class="hover:bg-secondary-50 transition-colors duration-200">
                                <!-- Event Info -->
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
                                            <div class="text-sm text-secondary-500 line-clamp-1">{{ Str::limit($event->description, 50) }}</div>
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
                                        <button
                                            onclick="editEvent({{ $event->id }})"
                                            class="text-primary-600 hover:text-primary-900 transition-colors duration-200"
                                            title="Edit Event"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
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
                                        <h3 class="text-lg font-medium text-secondary-900 mb-2">No events yet</h3>
                                        <p class="text-secondary-500 mb-4">Get started by creating your first event.</p>
                                        <button onclick="openCreateModal()" class="btn-primary">
                                            Create Your First Event
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




<!-- Create Event Modal -->
<div id="createEventModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-large max-w-2xl w-full max-h-screen overflow-y-auto">
            <form action="{{ route('event.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-6 py-4 border-b border-secondary-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-secondary-900">Create New Event</h3>
                        <button type="button" onclick="closeCreateModal()" class="text-secondary-400 hover:text-secondary-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-6 py-4 space-y-6">
                    <!-- Event Title -->
                    <div>
                        <label class="form-label">Event Title *</label>
                        <input type="text" name="title" required class="form-input" placeholder="Enter event title">
                        @error('title')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Event Description -->
                    <div>
                        <label class="form-label">Description *</label>
                        <textarea name="description" required rows="4" class="form-input" placeholder="Describe your event..."></textarea>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date and Time -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Start Date & Time *</label>
                            <input type="datetime-local" name="date_start" required class="form-input">
                            @error('date_start')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">End Date & Time *</label>
                            <input type="datetime-local" name="date_end" required class="form-input">
                            @error('date_end')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Location and Price -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Location *</label>
                            <input type="text" name="location" required class="form-input" placeholder="Event location">
                            @error('location')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">Price ($) *</label>
                            <input type="number" name="price" required step="0.01" min="0" class="form-input" placeholder="0.00">
                            @error('price')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Event Image -->
                    <div>
                        <label class="form-label">Event Image</label>
                        <input type="file" name="image" accept="image/*" class="form-input">
                        <p class="form-help">Upload an image for your event (optional)</p>
                        @error('image')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-secondary-200 flex justify-end space-x-3">
                    <button type="button" onclick="closeCreateModal()" class="btn-outline-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="btn-primary">
                        Create Event
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
                        <button type="button" onclick="closeEditModal()" class="text-secondary-400 hover:text-secondary-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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
                            <input type="datetime-local" name="date_start" id="edit_date_start" required class="form-input">
                        </div>
                        <div>
                            <label class="form-label">End Date & Time *</label>
                            <input type="datetime-local" name="date_end" id="edit_date_end" required class="form-input">
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
                            <input type="number" name="price" id="edit_price" required step="0.01" min="0" class="form-input">
                        </div>
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
    // Modal functions
    function openCreateModal() {
        console.log('Opening create event modal...');
        const modal = document.getElementById('createEventModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            console.log('Create event modal opened successfully');
        } else {
            console.error('Create event modal element not found!');
        }
    }

    function closeCreateModal() {
        document.getElementById('createEventModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
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
        }
    });
                            buttonText: 'Day Events',
                        },
                        listWeek: { // Customize the name for listWeek
                            buttonText: 'Week Events'
                        },
                        listMonth: { // Customize the name for listMonth
                            buttonText: 'Month Events'
                        },
                        timeGridWeek: {
                            buttonText: 'Week', // Customize the button text
                        },
                        timeGridDay: {
                            buttonText: "Day",
                        },
                        dayGridMonth: {
                            buttonText: "Month",
                        },
                    },
                    initialView: "timeGridWeek",
                    slotMinTime: "09:00:00", // min  time  appear in the calendar
                    slotMaxTime: "18:00:00",
                    nowIndicator: true,
                    selectable: true,
                    selectMirror: true,
                    selectOverlap: true,
                    weekends: true,
                    // editable: true,
                    events: data,
                    selectAllow: (info) => {
                        let instant = new Date()
                        return info.start > instant
                    },
                    select: (info) => {
                        let start = info.start
                        let end = info.end
                        console.log(info);
                        // if (end.getDate()-start.getDate() >=1 && !info.allDay) {
                        //     alert('khditi bzaf dial lwa9t')
                        //     calendar.unselect()
                        //     return
                        // }
                        // fblast matkhdam b hadi :
                        // document.getElementById('buttonModal ').click()
                        // khdam bhadi la bghity  :
                        buttonModal.click()
                        document.getElementById('start-Date').value = formatDate(start)
                        document.getElementById('end-Date').value = formatDate(end)
                    }
                });
                calendar.render();

                function formatDate(date) {
                    let year = String(date.getFullYear())
                    let month = String(date.getMonth() + 1).padStart(2, 0)
                    let day = String(date.getDate()).padStart(2, 0)
                    let hour = String(date.getHours()).padStart(2, 0)
                    let min = String(date.getMinutes()).padStart(2, 0)
                    let sec = String(date.getSeconds()).padStart(2, 0)
                    return `${year}-${month}-${day} ${hour}:${min}:${sec}`
                }
            });
        </script>
    </div>
@endsection
