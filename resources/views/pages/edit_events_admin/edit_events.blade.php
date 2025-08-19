@extends('layouts.admin_organizer')

@section('content2')
<div class="min-h-screen bg-secondary-50 py-8">
    <div class="container-custom">        <div class="mb-8">
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

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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
                            <p class="text-2xl font-bold text-secondary-900">{{ $stats['total_events'] }}</p>
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
                            <p class="text-sm font-medium text-secondary-600">Pending Approval</p>
                            <p class="text-2xl font-bold text-secondary-900">{{ $stats['pending_events'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="p-3 bg-success-100 rounded-lg">
                            <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Approved</p>
                            <p class="text-2xl font-bold text-secondary-900">{{ $stats['approved_events'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="p-3 bg-danger-100 rounded-lg">
                            <svg class="w-6 h-6 text-danger-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Rejected</p>
                            <p class="text-2xl font-bold text-secondary-900">{{ $stats['rejected_events'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-secondary-900">{{ $event->date_start->format('M j, Y') }}</div>
                                    <div class="text-sm text-secondary-500">{{ $event->date_start->format('g:i A') }}</div>
                                    <div class="text-sm text-secondary-500 mt-1">{{ Str::limit($event->location, 30) }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-secondary-900">${{ number_format($event->price, 2) }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($event->status === 'approved')
                                        <span class="badge-success">Approved</span>
                                        @if($event->approved_at)
                                            <div class="text-xs text-secondary-500 mt-1">
                                                {{ $event->approved_at->format('M j, Y') }}
                                            </div>
                                        @endif
                                    @elseif($event->status === 'rejected')
                                        <span class="badge-danger">Rejected</span>
                                        @if($event->rejection_reason)
                                            <div class="text-xs text-secondary-500 mt-1" title="{{ $event->rejection_reason }}">
                                                {{ Str::limit($event->rejection_reason, 30) }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="badge-warning">Pending</span>
                                        <div class="text-xs text-secondary-500 mt-1">
                                            Awaiting approval
                                        </div>
                                    @endif
                                </td>

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

                                        @if($event->status === 'pending')
                                            <form method="POST" action="{{ route('event_admin.approve', $event) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button
                                                    type="submit"
                                                    class="text-success-600 hover:text-success-900 transition-colors duration-200"
                                                    title="Approve Event"
                                                    onclick="return confirm('Are you sure you want to approve this event?')"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                            </form>

                                            <button
                                                onclick="showRejectModal({{ $event->id }}, '{{ $event->title }}')"
                                                class="text-warning-600 hover:text-warning-900 transition-colors duration-200"
                                                title="Reject Event"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        @endif

                                        <form method="POST" action="{{ route('event_admin.delete', $event) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="text-danger-600 hover:text-danger-900 transition-colors duration-200"
                                                title="Delete Event"
                                                onclick="return confirm('Are you sure you want to delete this event? This action cannot be undone.')"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
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

<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-medium text-secondary-900 mb-4">Reject Event</h3>
                <p class="text-secondary-600 mb-4">Please provide a reason for rejecting this event:</p>

                <form id="rejectForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <textarea
                        name="rejection_reason"
                        rows="4"
                        class="form-input w-full mb-4"
                        placeholder="Enter rejection reason..."
                        required
                    ></textarea>

                    <div class="flex justify-end space-x-3">
                        <button
                            type="button"
                            onclick="hideRejectModal()"
                            class="btn-outline"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="btn-danger"
                        >
                            Reject Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showRejectModal(eventId, eventTitle) {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        form.action = `/events/${eventId}/reject`;
        modal.classList.remove('hidden');
    }

    function hideRejectModal() {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        form.reset();
        modal.classList.add('hidden');
    }

    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideRejectModal();
        }
    });
</script>
@endsection
