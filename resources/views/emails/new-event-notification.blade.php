@extends('emails.layout')

@section('title', 'New Event Created - Moderation Required')

@section('header-title', 'New Event Alert')
@section('header-subtitle', 'Admin Review Required')

@section('content')
    <h2>New Event Created 📅</h2>
    
    <p>A new event has been created on Evenext and may require admin review and moderation. Please review the event details below and take appropriate action if needed.</p>
    
    <div class="warning-box">
        <h4>⏳ Review Required</h4>
        <p>Please review this event for content appropriateness, accuracy, and compliance with platform guidelines.</p>
    </div>
    
    <h3>📅 Event Information</h3>
    <div class="info-box">
        <h4>{{ $event->title }}</h4>
        <p>
            <strong>📍 Location:</strong> {{ $event->location }}<br>
            <strong>📅 Date:</strong> {{ $event->date_start->format('l, F j, Y') }}<br>
            <strong>🕐 Time:</strong> {{ $event->date_start->format('g:i A') }} - {{ $event->date_end->format('g:i A') }}<br>
            <strong>💰 Ticket Price:</strong> ${{ number_format($event->price, 2) }}<br>
            @if($event->category)
                <strong>🏷️ Category:</strong> {{ $event->category->name }}<br>
            @endif
            <strong>👁️ Visibility:</strong> {{ ucfirst($event->visibility) }}<br>
            <strong>📝 Event ID:</strong> #{{ $event->id }}<br>
            <strong>📅 Created:</strong> {{ $event->created_at->format('M j, Y \a\t g:i A') }}
        </p>
    </div>
    
    @if($event->description)
        <h3>📋 Event Description</h3>
        <div class="info-box">
            <p>{{ $event->description }}</p>
        </div>
    @endif
    
    <h3>👤 Organizer Information</h3>
    <div class="info-box">
        <h4>Organizer Details</h4>
        <p>
            <strong>Name:</strong> {{ $organizer->name }}<br>
            <strong>Email:</strong> {{ $organizer->email }}<br>
            @if($organizer->phone)
                <strong>Phone:</strong> {{ $organizer->phone }}<br>
            @endif
            <strong>Role:</strong> {{ ucfirst($organizer->role) }}<br>
            <strong>Member Since:</strong> {{ $organizer->created_at->format('M j, Y') }}<br>
            <strong>User ID:</strong> #{{ $organizer->id }}
        </p>
    </div>
    
    @php
        $organizerEvents = $organizer->events()->count();
        $totalTicketsSold = $organizer->events()->withCount(['tickets' => function($query) {
            $query->where('is_paid', true);
        }])->get()->sum('tickets_count');
    @endphp
    
    <h3>📊 Organizer History</h3>
    <div class="success-box">
        <h4>Performance Summary</h4>
        <p>
            <strong>Total Events Created:</strong> {{ $organizerEvents }} events<br>
            <strong>Total Tickets Sold:</strong> {{ $totalTicketsSold }} tickets<br>
            <strong>Account Status:</strong> {{ $organizer->hasRole('organizer') ? 'Verified Organizer' : 'Standard User' }}<br>
            <strong>Last Activity:</strong> {{ $organizer->updated_at->format('M j, Y') }}
        </p>
    </div>
    
    <h3>📋 Review Checklist</h3>
    <p>Please verify the following before approving this event:</p>
    <ul>
        <li>✅ <strong>Content Appropriateness:</strong> Event title and description are appropriate</li>
        <li>✅ <strong>Accurate Information:</strong> Event details appear accurate and complete</li>
        <li>✅ <strong>Pricing Reasonableness:</strong> Ticket pricing is reasonable for the event type</li>
        <li>✅ <strong>Location Validity:</strong> Event location exists and is appropriate</li>
        <li>✅ <strong>Date/Time Logic:</strong> Event timing is logical and not in the past</li>
        <li>✅ <strong>Organizer Credibility:</strong> Organizer has good standing on the platform</li>
        <li>✅ <strong>Guidelines Compliance:</strong> Event complies with platform guidelines</li>
    </ul>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('ticket.show', $event) }}" class="btn" style="margin-right: 10px;">
            View Event Page
        </a>
        <a href="{{ url('/admin/events/' . $event->id) }}" class="btn btn-secondary">
            Admin Review Panel
        </a>
    </div>
    
    <h3>⚙️ Available Actions</h3>
    <p>You can take the following actions for this event:</p>
    <ul>
        <li>✅ <strong>Approve:</strong> Allow the event to remain active and visible</li>
        <li>⏸️ <strong>Suspend:</strong> Temporarily hide the event pending further review</li>
        <li>❌ <strong>Remove:</strong> Remove the event if it violates guidelines</li>
        <li>📧 <strong>Contact Organizer:</strong> Reach out for clarification or changes</li>
        <li>🏷️ <strong>Update Category:</strong> Correct the event category if needed</li>
    </ul>
    
    @php
        $totalEvents = \App\Models\Events::count();
        $todayEvents = \App\Models\Events::whereDate('created_at', today())->count();
        $pendingReview = \App\Models\Events::where('status', 'pending')->count();
    @endphp
    
    <h3>📊 Platform Overview</h3>
    <div class="info-box">
        <h4>Current Statistics</h4>
        <p>
            <strong>Total Events:</strong> {{ $totalEvents }} events<br>
            <strong>Events Created Today:</strong> {{ $todayEvents }} events<br>
            <strong>Pending Review:</strong> {{ $pendingReview }} events<br>
            <strong>Platform Growth:</strong> Steady increase in event creation
        </p>
    </div>
    
    <h3>🔗 Quick Admin Links</h3>
    <ul>
        <li>📊 <a href="{{ url('/admin/dashboard') }}">Admin Dashboard</a></li>
        <li>📅 <a href="{{ url('/admin/events') }}">All Events Management</a></li>
        <li>👥 <a href="{{ url('/admin/users') }}">User Management</a></li>
        <li>📈 <a href="{{ url('/admin/analytics') }}">Platform Analytics</a></li>
        <li>⚙️ <a href="{{ url('/admin/settings') }}">Platform Settings</a></li>
    </ul>
    
    <h3>📞 Contact Options</h3>
    <p>If you need to contact the organizer or need support:</p>
    <ul>
        <li>📧 <strong>Organizer:</strong> <a href="mailto:{{ $organizer->email }}">{{ $organizer->email }}</a></li>
        <li>🛠️ <strong>Admin Support:</strong> <a href="mailto:admin@evenext.com">admin@evenext.com</a></li>
        <li>📱 <strong>Platform Support:</strong> <a href="mailto:support@evenext.com">support@evenext.com</a></li>
    </ul>
    
    <div class="warning-box">
        <h4>⚠️ Important Note</h4>
        <p>Please review this event promptly to maintain platform quality and user experience. Delayed reviews may impact organizer satisfaction and platform reputation.</p>
    </div>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/admin/events') }}" class="btn btn-secondary">Go to Events Management</a>
    </div>
    
    <p>This notification was automatically generated when the event was created.</p>
    
    <p>Best regards,<br>
    <strong>Evenext System</strong></p>
@endsection
