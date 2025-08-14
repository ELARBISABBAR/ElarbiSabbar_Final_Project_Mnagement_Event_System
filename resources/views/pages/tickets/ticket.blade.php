@extends('layouts.index')

@section('content')
<div class="min-h-screen bg-secondary-50 py-8">
    <div class="container-custom">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-secondary-600 hover:text-primary-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-secondary-500 ml-1 md:ml-2">{{ $event->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Event Header -->
        <div class="bg-white rounded-xl shadow-soft overflow-hidden mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Event Image -->
                <div class="relative">
                    @if($event->image && file_exists(public_path('storage/img/' . $event->image)))
                        <img
                            src="{{ asset('storage/img/' . $event->image) }}"
                            alt="{{ $event->title }}"
                            class="w-full h-64 lg:h-96 object-cover"
                        >
                    @else
                        <div class="w-full h-64 lg:h-96 bg-gradient-primary flex items-center justify-center">
                            <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif

                    <!-- Event Status Badge -->
                    <div class="absolute top-4 left-4">
                        @if($event->date_start->isPast())
                            <span class="badge-secondary">Event Ended</span>
                        @elseif($event->date_start->isToday())
                            <span class="badge-warning">Today</span>
                        @else
                            <span class="badge-success">Upcoming</span>
                        @endif
                    </div>
                </div>

                <!-- Event Details -->
                <div class="p-6 lg:p-8">
                    <h1 class="text-3xl lg:text-4xl font-bold text-secondary-900 mb-4">{{ $event->title }}</h1>

                    <!-- Event Meta -->
                    <div class="space-y-4 mb-6">
                        <!-- Date & Time -->
                        <div class="flex items-center text-secondary-600">
                            <svg class="w-5 h-5 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="font-medium">{{ $event->date_start->format('l, F j, Y') }}</p>
                                <p class="text-sm">{{ $event->date_start->format('g:i A') }} - {{ $event->date_end->format('g:i A') }}</p>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-center text-secondary-600">
                            <svg class="w-5 h-5 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p>{{ $event->location }}</p>
                        </div>

                        <!-- Organizer -->
                        <div class="flex items-center text-secondary-600">
                            <svg class="w-5 h-5 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <p>Organized by <span class="font-medium">{{ $event->user->name }}</span></p>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="mb-6">
                        <p class="text-sm text-secondary-600 mb-1">Starting from</p>
                        <p class="text-3xl font-bold text-primary-600">${{ number_format($event->price, 2) }}</p>
                    </div>

                    <!-- Quick Actions -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        @auth
                            @if(!$event->date_start->isPast())
                                <button onclick="openTicketModal()" class="btn-primary flex-1">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Buy Tickets
                                </button>
                            @else
                                <button disabled class="btn-secondary flex-1 opacity-50 cursor-not-allowed">
                                    Event Ended
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-primary flex-1 text-center">
                                Login to Buy Tickets
                            </a>
                        @endauth

                        <button onclick="shareEvent()" class="btn-outline-primary">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                            </svg>
                            Share
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Description -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-xl font-semibold text-secondary-900">About This Event</h2>
                    </div>
                    <div class="card-body">
                        <div class="prose max-w-none">
                            <p class="text-secondary-700 leading-relaxed">{{ $event->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Event Stats -->
                <div class="card mt-6">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-secondary-900">Event Statistics</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @php
                                $totalTickets = $event->tickets->sum('quantity');
                                $soldTickets = $event->tickets->where('is_paid', true)->sum('quantity');
                                $revenue = $event->tickets->where('is_paid', true)->sum(function($ticket) {
                                    return $ticket->price * $ticket->quantity;
                                });
                            @endphp

                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary-600">{{ $soldTickets }}</div>
                                <div class="text-sm text-secondary-600">Tickets Sold</div>
                            </div>

                            <div class="text-center">
                                <div class="text-2xl font-bold text-secondary-900">{{ $totalTickets }}</div>
                                <div class="text-sm text-secondary-600">Total Orders</div>
                            </div>

                            <div class="text-center">
                                <div class="text-2xl font-bold text-success-600">${{ number_format($revenue, 0) }}</div>
                                <div class="text-sm text-secondary-600">Revenue</div>
                            </div>

                            <div class="text-center">
                                <div class="text-2xl font-bold text-warning-600">{{ $event->date_start->diffForHumans() }}</div>
                                <div class="text-sm text-secondary-600">{{ $event->date_start->isPast() ? 'Ended' : 'Starts' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Ticket Info Card -->
                <div class="card sticky top-8">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-secondary-900">Ticket Information</h3>
                    </div>
                    <div class="card-body space-y-4">
                        <!-- Ticket Types -->
                        <div>
                            <h4 class="font-medium text-secondary-900 mb-2">Available Ticket Types</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center p-3 bg-secondary-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-secondary-900">Standard</p>
                                        <p class="text-sm text-secondary-600">General admission</p>
                                    </div>
                                    <p class="font-bold text-primary-600">${{ number_format($event->price, 2) }}</p>
                                </div>

                                <div class="flex justify-between items-center p-3 bg-secondary-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-secondary-900">VIP</p>
                                        <p class="text-sm text-secondary-600">Premium experience</p>
                                    </div>
                                    <p class="font-bold text-primary-600">${{ number_format($event->price * 1.5, 2) }}</p>
                                </div>

                                <div class="flex justify-between items-center p-3 bg-secondary-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-secondary-900">Student</p>
                                        <p class="text-sm text-secondary-600">Student discount</p>
                                    </div>
                                    <p class="font-bold text-primary-600">${{ number_format($event->price * 0.6, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Purchase Button -->
                        @auth
                            @if(!$event->date_start->isPast())
                                <button onclick="openTicketModal()" class="btn-primary w-full">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Purchase Tickets
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-primary w-full text-center">
                                Login to Purchase
                            </a>
                        @endauth

                        <!-- Event Details -->
                        <div class="pt-4 border-t border-secondary-200">
                            <h4 class="font-medium text-secondary-900 mb-3">Event Details</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-secondary-600">Duration:</span>
                                    <span class="text-secondary-900">{{ $event->date_start->diffInHours($event->date_end) }} hours</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-secondary-600">Category:</span>
                                    <span class="text-secondary-900">Conference</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-secondary-600">Language:</span>
                                    <span class="text-secondary-900">English</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ticket Purchase Modal -->
@auth
<div id="ticketModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-large max-w-md w-full">
            <form action="{{ route('ticket.post') }}" method="POST" id="ticketForm">
                @csrf
                <div class="px-6 py-4 border-b border-secondary-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-secondary-900">Purchase Tickets</h3>
                        <button type="button" onclick="closeTicketModal()" class="text-secondary-400 hover:text-secondary-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-6 py-4 space-y-4">
                    <!-- Event Info -->
                    <div class="bg-secondary-50 rounded-lg p-4">
                        <h4 class="font-medium text-secondary-900">{{ $event->title }}</h4>
                        <p class="text-sm text-secondary-600">{{ $event->date_start->format('M j, Y \a\t g:i A') }}</p>
                        <p class="text-sm text-secondary-600">{{ $event->location }}</p>
                    </div>

                    <!-- Ticket Type Selection -->
                    <div>
                        <label class="form-label">Ticket Type *</label>
                        <select name="ticket_type" id="ticketType" required class="form-input" onchange="updatePrice()">
                            <option value="">Select ticket type</option>
                            <option value="standard" data-price="{{ $event->price }}">Standard - ${{ number_format($event->price, 2) }}</option>
                            <option value="vip" data-price="{{ $event->price * 1.5 }}">VIP - ${{ number_format($event->price * 1.5, 2) }}</option>
                            <option value="student" data-price="{{ $event->price * 0.6 }}">Student - ${{ number_format($event->price * 0.6, 2) }}</option>
                        </select>
                        @error('ticket_type')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label class="form-label">Quantity *</label>
                        <div class="flex items-center space-x-3">
                            <button type="button" onclick="decreaseQuantity()" class="btn-outline-secondary w-10 h-10 flex items-center justify-center">-</button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="10" required class="form-input text-center flex-1" onchange="updateTotal()">
                            <button type="button" onclick="increaseQuantity()" class="btn-outline-secondary w-10 h-10 flex items-center justify-center">+</button>
                        </div>
                        @error('quantity')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price Summary -->
                    <div class="bg-secondary-50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-secondary-600">Price per ticket:</span>
                            <span id="pricePerTicket" class="font-medium">$0.00</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-secondary-600">Quantity:</span>
                            <span id="quantityDisplay" class="font-medium">1</span>
                        </div>
                        <div class="border-t border-secondary-200 pt-2">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-secondary-900">Total:</span>
                                <span id="totalPrice" class="font-bold text-primary-600 text-lg">$0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="eventId" value="{{ $event->id }}">
                    <input type="hidden" name="price" id="selectedPrice" value="">
                </div>

                <div class="px-6 py-4 border-t border-secondary-200 flex justify-end space-x-3">
                    <button type="button" onclick="closeTicketModal()" class="btn-outline-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Purchase Tickets
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

<script>
    // Modal functions
    function openTicketModal() {
        document.getElementById('ticketModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeTicketModal() {
        document.getElementById('ticketModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Quantity functions
    function increaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        if (currentValue < 10) {
            quantityInput.value = currentValue + 1;
            updateTotal();
        }
    }

    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            updateTotal();
        }
    }

    // Price calculation functions
    function updatePrice() {
        const ticketTypeSelect = document.getElementById('ticketType');
        const selectedOption = ticketTypeSelect.options[ticketTypeSelect.selectedIndex];
        const price = selectedOption.getAttribute('data-price');

        if (price) {
            document.getElementById('selectedPrice').value = price;
            document.getElementById('pricePerTicket').textContent = '$' + parseFloat(price).toFixed(2);
            updateTotal();
        }
    }

    function updateTotal() {
        const price = parseFloat(document.getElementById('selectedPrice').value) || 0;
        const quantity = parseInt(document.getElementById('quantity').value) || 1;
        const total = price * quantity;

        document.getElementById('quantityDisplay').textContent = quantity;
        document.getElementById('totalPrice').textContent = '$' + total.toFixed(2);
    }

    // Share function
    function shareEvent() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $event->title }}',
                text: 'Check out this amazing event!',
                url: window.location.href
            });
        } else {
            // Fallback to copying URL
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Event URL copied to clipboard!');
            });
        }
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('ticketModal');
        if (event.target === modal) {
            closeTicketModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeTicketModal();
        }
    });
</script>
@endsection
