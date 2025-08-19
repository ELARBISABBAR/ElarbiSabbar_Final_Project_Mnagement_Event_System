@extends('layouts.index')

@section('content')

<style>
#ticketModal {
    backdrop-filter: blur(8px);
    background: rgba(0, 0, 0, 0.6);
}

#ticketModal .modal-container {
    animation: modalFadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1);
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: scale(0.9) translateY(-20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.modal-container {
    max-height: 90vh;
}

button:hover {
    transition: all 0.2s ease;
}

@media (max-height: 600px) {
    #ticketModal .modal-container {
        max-height: 95vh;
        margin: 0.5rem auto;
    }
}

@media (max-width: 640px) {
    #ticketModal .modal-container {
        max-width: 95vw;
        margin: 1rem auto;
        max-height: 90vh;
    }

    #ticketModal .modal-content {
        padding: 1rem;
    }

    #ticketModal .px-6 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

@media (max-height: 500px) {
    #ticketModal .modal-container {
        max-height: 98vh;
        margin: 0.25rem auto;
    }
}

#ticketModal .modal-content::-webkit-scrollbar {
    width: 6px;
}

#ticketModal .modal-content::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

#ticketModal .modal-content::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

#ticketModal .modal-content::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
<div class="min-h-screen bg-secondary-50 py-8">
    <div class="container-custom">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
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
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
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

        @if(session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg class="fill-current h-6 w-6 text-blue-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Info</p>
                        <p class="text-sm">{{ session('info') }}</p>
                    </div>
                </div>
            </div>
        @endif

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

        <div class="bg-white rounded-xl shadow-soft overflow-hidden mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
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

                <div class="p-6 lg:p-8">
                    <h1 class="text-3xl lg:text-4xl font-bold text-secondary-900 mb-4">{{ $event->title }}</h1>

                    <div class="space-y-4 mb-6">
                        <div class="flex items-center text-secondary-600">
                            <svg class="w-5 h-5 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="font-medium">{{ $event->date_start->format('l, F j, Y') }}</p>
                                <p class="text-sm">{{ $event->date_start->format('g:i A') }} - {{ $event->date_end->format('g:i A') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center text-secondary-600">
                            <svg class="w-5 h-5 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p>{{ $event->location }}</p>
                        </div>

                        <div class="flex items-center text-secondary-600">
                            <svg class="w-5 h-5 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <p>Organized by <span class="font-medium">{{ $event->user->name }}</span></p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-sm text-secondary-600 mb-1">Starting from</p>
                        <p class="text-3xl font-bold text-primary-600">${{ number_format($event->price, 2) }}</p>
                    </div>

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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
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

            <div class="lg:col-span-1">
                <div class="card sticky top-8">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-secondary-900">Ticket Information</h3>
                    </div>
                    <div class="card-body space-y-4">
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

<div class="container-custom mb-8">
    @include('pages.tickets.components.reviews')
</div>

@auth
<div id="ticketModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full">
            <form action="{{ route('stripe.checkout', $event) }}" method="POST" id="ticketForm">
                @csrf
                <input type="hidden" name="ticketType" id="ticketType" value="standard">
                <input type="hidden" name="selectedPrice" id="selectedPrice" value="{{ $event->price }}">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Purchase Tickets</h3>
                        <button type="button" onclick="closeTicketModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    @if(session('error'))
                        <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-3">
                            <p class="text-sm text-red-600">{{ session('error') }}</p>
                        </div>
                    @endif

                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-3">{{ $event->title }}</h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p>📅 {{ $event->date_start->format('M j, Y \a\t g:i A') }}</p>
                            <p>📍 {{ $event->location }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-gray-700">Ticket Price:</span>
                            <span class="text-xl font-bold text-blue-600">${{ number_format($event->price, 2) }}</span>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-gray-700">Quantity:</span>
                            <div class="flex items-center space-x-3">
                                <button type="button" onclick="decreaseQuantity()" class="w-8 h-8 rounded border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="10" required
                                       class="w-16 text-center border border-gray-300 rounded px-2 py-1" onchange="updateTotal()" oninput="updateTotal()" readonly>
                                <button type="button" onclick="increaseQuantity()" class="w-8 h-8 rounded border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        @error('quantity')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total:</span>
                            <span id="totalPrice" class="text-2xl font-bold text-blue-600">${{ number_format($event->price, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500">🔒 Secured by Stripe</p>
                        <div class="flex space-x-3">
                            <button type="button" onclick="closeTicketModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg" id="purchaseBtn">
                                <span id="purchaseText">Pay Now</span>
                                <div class="hidden animate-spin rounded-full h-4 w-4 border-b-2 border-white ml-2" id="loadingSpinner"></div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

<script>
    function openTicketModal() {
        console.log('Opening ticket modal...');
        const modal = document.getElementById('ticketModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            document.body.style.paddingRight = getScrollbarWidth() + 'px'; // Prevent layout shift

            updateTotal();

            const firstFocusable = modal.querySelector('button, input, select, textarea');
            if (firstFocusable) {
                setTimeout(() => firstFocusable.focus(), 100);
            }

            console.log('Modal opened successfully');
        } else {
            console.error('Modal element not found!');
        }
    }

    function closeTicketModal() {
        console.log('Closing ticket modal...');
        const modal = document.getElementById('ticketModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            console.log('Modal closed successfully');
        } else {
            console.error('Modal element not found!');
        }
    }

    function getScrollbarWidth() {
        const outer = document.createElement('div');
        outer.style.visibility = 'hidden';
        outer.style.overflow = 'scroll';
        outer.style.msOverflowStyle = 'scrollbar';
        document.body.appendChild(outer);

        const inner = document.createElement('div');
        outer.appendChild(inner);

        const scrollbarWidth = outer.offsetWidth - inner.offsetWidth;
        outer.parentNode.removeChild(outer);

        return scrollbarWidth;
    }

    function debugElements() {
        const elements = {
            modal: document.getElementById('ticketModal'),
            form: document.getElementById('ticketForm'),
            quantity: document.getElementById('quantity'),
            quantityDisplay: document.getElementById('quantityDisplay'),
            totalPrice: document.getElementById('totalPrice'),
            purchaseBtn: document.getElementById('purchaseBtn')
        };

        console.log('Modal elements check:', elements);

        Object.keys(elements).forEach(key => {
            if (!elements[key]) {
                console.error(`Element not found: ${key}`);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        debugElements();

        const modal = document.getElementById('ticketModal');
        const form = document.getElementById('ticketForm');
        const purchaseBtn = document.getElementById('purchaseBtn');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const purchaseText = document.getElementById('purchaseText');

        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeTicketModal();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeTicketModal();
                }
            });
        }

        if (form && purchaseBtn) {
            form.addEventListener('submit', function(e) {
                const quantity = parseInt(document.getElementById('quantity').value);
                if (!quantity || quantity < 1 || quantity > 10) {
                    e.preventDefault();
                    alert('Please select a valid quantity (1-10 tickets)');
                    return false;
                }

                console.log('Form submitting with quantity:', quantity);

                purchaseBtn.disabled = true;
                purchaseBtn.classList.add('opacity-75', 'cursor-not-allowed');
                if (loadingSpinner) loadingSpinner.classList.remove('hidden');
                if (purchaseText) purchaseText.textContent = 'Processing...';

                setTimeout(() => {
                }, 300);
            });
        }

        const errorAlert = document.querySelector('.bg-red-50');
        if (errorAlert) {
            setTimeout(() => {
                errorAlert.style.transition = 'opacity 0.5s ease-out';
                errorAlert.style.opacity = '0';
                setTimeout(() => {
                    errorAlert.remove();
                }, 500);
            }, 10000);
        }
    });

    function increaseQuantity() {
        console.log('Increase quantity clicked');
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value) || 1;
        if (currentValue < 10) {
            quantityInput.value = currentValue + 1;
            updateTotal();
            console.log('Quantity increased to:', quantityInput.value);
        } else {
            console.log('Maximum quantity reached');
        }
    }

    function decreaseQuantity() {
        console.log('Decrease quantity clicked');
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value) || 1;
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            updateTotal();
            console.log('Quantity decreased to:', quantityInput.value);
        } else {
            console.log('Minimum quantity reached');
        }
    }



    function updateTotal() {
        const basePrice = {{ $event->price }};
        const quantity = parseInt(document.getElementById('quantity').value) || 1;
        const total = basePrice * quantity;

        const totalPriceElement = document.getElementById('totalPrice');
        if (totalPriceElement) {
            totalPriceElement.style.transition = 'color 0.3s ease';
            totalPriceElement.style.color = '#059669'; 
            totalPriceElement.textContent = '$' + total.toFixed(2);

            setTimeout(() => {
                totalPriceElement.style.color = '#2563eb';
            }, 300);
        }

        const selectedPriceElement = document.getElementById('selectedPrice');
        if (selectedPriceElement) {
            selectedPriceElement.value = total.toFixed(2);
        }

        console.log('Price updated:', { basePrice, quantity, total }); 
    }

    function shareEvent() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $event->title }}',
                text: 'Check out this amazing event!',
                url: window.location.href
            });
        } else {
          navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Event URL copied to clipboard!');
            });
        }
    }

    document.addEventListener('click', function(event) {
        const modal = document.getElementById('ticketModal');
        if (event.target === modal) {
            closeTicketModal();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeTicketModal();
        }
    });

    document.getElementById('ticketForm').addEventListener('submit', function(e) {
        console.log('Form submission started...');

        const ticketType = document.getElementById('ticketType').value;
        const quantity = document.getElementById('quantity').value;
        const price = document.getElementById('selectedPrice').value;

        console.log('Form values:', { ticketType, quantity, price });

        if (!ticketType) {
            alert('Please select a ticket type.');
            e.preventDefault();
            return;
        }

        if (!quantity || quantity < 1) {
            alert('Please select a valid quantity.');
            e.preventDefault();
            return;
        }

        if (!price || price <= 0) {
            alert('Invalid ticket price.');
            e.preventDefault();
            return;
        }

        console.log('Form validation passed, submitting...');

        const purchaseBtn = document.getElementById('purchaseBtn');
        const purchaseText = document.getElementById('purchaseText');
        const purchaseIcon = document.getElementById('purchaseIcon');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const cancelBtn = document.getElementById('cancelBtn');

        purchaseBtn.disabled = true;
        cancelBtn.disabled = true;
        purchaseText.textContent = 'Processing...';
        purchaseIcon.classList.add('hidden');
        loadingSpinner.classList.remove('hidden');
        purchaseBtn.classList.add('opacity-75');
    });

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('cancelled') === '1') {
        alert('Payment was cancelled. You can try again anytime.');
        window.history.replaceState({}, document.title, window.location.pathname);
    }
</script>
@endsection
