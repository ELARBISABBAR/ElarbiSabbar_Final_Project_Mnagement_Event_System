@extends('layouts.index')

@section('content')
<div class="min-h-screen bg-secondary-50 py-8">
    <div class="container-custom">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-secondary-900">My Ticket Orders</h1>
                    <p class="text-secondary-600 mt-2">View and manage your event tickets</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-secondary-600">
                        Total Orders: <span class="font-semibold text-secondary-900">{{ $tickets->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            @php
                $totalSpent = $tickets->where('is_paid', true)->sum(function($ticket) {
                    return $ticket->price * $ticket->quantity;
                });
                $paidOrders = $tickets->where('is_paid', true)->count();
                $pendingOrders = $tickets->where('is_paid', false)->count();
                $totalTickets = $tickets->sum('quantity');
            @endphp

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="p-3 bg-primary-100 rounded-lg">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Total Tickets</p>
                            <p class="text-2xl font-bold text-secondary-900">{{ $totalTickets }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="p-3 bg-success-100 rounded-lg">
                            <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Paid Orders</p>
                            <p class="text-2xl font-bold text-secondary-900">{{ $paidOrders }}</p>
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
                            <p class="text-sm font-medium text-secondary-600">Pending</p>
                            <p class="text-2xl font-bold text-secondary-900">{{ $pendingOrders }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="p-3 bg-secondary-100 rounded-lg">
                            <svg class="w-6 h-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Total Spent</p>
                            <p class="text-2xl font-bold text-secondary-900">${{ number_format($totalSpent, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($tickets->count() > 0)
            <!-- Orders List -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-secondary-900">Your Orders</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-secondary-200">
                        <thead class="bg-secondary-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                    Order Details
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                    Event
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                    Ticket Info
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                    Total
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
                            @foreach($tickets as $ticket)
                                <tr class="hover:bg-secondary-50 transition-colors duration-200">
                                    <!-- Order Details -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-secondary-900">Order #{{ $ticket->id }}</div>
                                        <div class="text-sm text-secondary-500">{{ $ticket->created_at->format('M j, Y \a\t g:i A') }}</div>
                                    </td>

                                    <!-- Event -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($ticket->event->image && file_exists(public_path('storage/img/' . $ticket->event->image)))
                                                    <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset('storage/img/' . $ticket->event->image) }}" alt="{{ $ticket->event->title }}">
                                                @else
                                                    <div class="h-10 w-10 rounded-lg bg-gradient-primary flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-secondary-900">{{ $ticket->event->title }}</div>
                                                <div class="text-sm text-secondary-500">{{ $ticket->event->date_start->format('M j, Y') }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Ticket Info -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-secondary-900">
                                            <span class="capitalize">{{ $ticket->ticket_type }}</span> Ticket
                                        </div>
                                        <div class="text-sm text-secondary-500">
                                            Qty: {{ $ticket->quantity }} × ${{ number_format($ticket->price, 2) }}
                                        </div>
                                    </td>

                                    <!-- Total -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-secondary-900">
                                            ${{ number_format($ticket->price * $ticket->quantity, 2) }}
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($ticket->is_paid)
                                            <span class="badge-success">Paid</span>
                                        @else
                                            <span class="badge-warning">Pending</span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            @if($ticket->is_paid)
                                                <a
                                                    href="{{ route('ticket.pdf', $ticket) }}"
                                                    class="text-primary-600 hover:text-primary-900 transition-colors duration-200"
                                                    title="Download PDF"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </a>
                                            @else
                                                <a
                                                    href="{{ route('ticket.payment', $ticket) }}"
                                                    class="text-warning-600 hover:text-warning-900 transition-colors duration-200"
                                                    title="Complete Payment"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                    </svg>
                                                </a>
                                            @endif

                                            <a
                                                href="{{ route('ticket.show', $ticket->event) }}"
                                                class="text-secondary-600 hover:text-secondary-900 transition-colors duration-200"
                                                title="View Event"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach






                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="card">
                <div class="card-body text-center py-12">
                    <svg class="w-16 h-16 text-secondary-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-secondary-900 mb-2">No orders yet</h3>
                    <p class="text-secondary-500 mb-6">You haven't purchased any tickets yet. Start exploring events!</p>
                    <a href="{{ route('home') }}" class="btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Browse Events
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
