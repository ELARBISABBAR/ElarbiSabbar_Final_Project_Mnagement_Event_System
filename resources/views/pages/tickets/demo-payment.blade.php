@extends('layouts.index')

@section('content')
<div class="min-h-screen bg-secondary-50 py-8">
    <div class="container-custom">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-secondary-900">Demo Payment</h1>
            <p class="text-secondary-600 mt-2">Complete your ticket purchase</p>
        </div>

        <!-- Demo Notice -->
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6" role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-blue-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold">Demo Mode</p>
                    <p class="text-sm">This is a demonstration payment. No real payment will be processed. Click "Complete Payment" to simulate a successful transaction.</p>
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-soft overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white">Payment Summary</h2>
                </div>

                <!-- Event Details -->
                <div class="p-6">
                    <div class="flex items-start space-x-4 mb-6">
                        @if($event->image && file_exists(public_path('storage/img/' . $event->image)))
                            <img
                                src="{{ asset('storage/img/' . $event->image) }}"
                                alt="{{ $event->title }}"
                                class="w-20 h-20 object-cover rounded-lg"
                            >
                        @else
                            <div class="w-20 h-20 bg-gradient-primary rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif

                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-secondary-900">{{ $event->title }}</h3>
                            <p class="text-secondary-600 text-sm">{{ $event->date_start->format('M j, Y \a\t g:i A') }}</p>
                            <p class="text-secondary-600 text-sm">{{ $event->location }}</p>
                        </div>
                    </div>

                    <!-- Ticket Details -->
                    <div class="bg-secondary-50 rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-secondary-900 mb-3">Ticket Details</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-secondary-600">Ticket Type:</span>
                                <span class="font-medium">{{ ucfirst($ticket->ticket_type) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-secondary-600">Quantity:</span>
                                <span class="font-medium">{{ $ticket->quantity }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-secondary-600">Price per Ticket:</span>
                                <span class="font-medium">${{ number_format($ticket->price, 2) }}</span>
                            </div>
                            <div class="border-t border-secondary-200 pt-2 mt-2">
                                <div class="flex justify-between">
                                    <span class="font-semibold text-secondary-900">Total Amount:</span>
                                    <span class="font-bold text-primary-600 text-lg">${{ number_format($ticket->price * $ticket->quantity, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Demo Payment Form -->
                    <form action="{{ route('demo.payment.process', $ticket) }}" method="POST" id="demoPaymentForm">
                        @csrf
                        
                        <!-- Fake Payment Method -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-secondary-900 mb-3">Payment Method</h4>
                            <div class="border border-secondary-200 rounded-lg p-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-8 bg-blue-600 rounded flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">DEMO</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-secondary-900">Demo Credit Card</p>
                                        <p class="text-sm text-secondary-600">**** **** **** 4242</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('ticket.show', $event) }}" class="btn-outline-secondary flex-1 text-center">
                                Cancel
                            </a>
                            <button type="submit" class="btn-primary flex-1" id="paymentBtn">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="paymentIcon">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <span id="paymentText">Complete Payment</span>
                                <div class="hidden animate-spin rounded-full h-4 w-4 border-b-2 border-white ml-2" id="paymentSpinner"></div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Add loading state to payment form
    document.getElementById('demoPaymentForm').addEventListener('submit', function(e) {
        const paymentBtn = document.getElementById('paymentBtn');
        const paymentText = document.getElementById('paymentText');
        const paymentIcon = document.getElementById('paymentIcon');
        const paymentSpinner = document.getElementById('paymentSpinner');

        paymentBtn.disabled = true;
        paymentText.textContent = 'Processing...';
        paymentIcon.classList.add('hidden');
        paymentSpinner.classList.remove('hidden');
        paymentBtn.classList.add('opacity-75');
    });
</script>
@endsection
