@extends('emails.layout')

@section('title', 'Event Created Successfully - ' . $event->title)

@section('header-title', 'Event Created!')
@section('header-subtitle', 'Your event is now live')

@section('content')
    <h2>Hello {{ $event->user->name }}! 🎉</h2>
    
    <p>Congratulations! Your event <strong>{{ $event->title }}</strong> has been successfully created and is now live on Evenext. People can start discovering and purchasing tickets for your event right away!</p>
    
    <div class="success-box">
        <h4>✅ Event Published Successfully</h4>
        <p>Your event is now visible to attendees and ready for ticket sales!</p>
    </div>
    
    <h3>📅 Your Event Details</h3>
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
            <strong>📝 Event ID:</strong> #{{ $event->id }}
        </p>
    </div>
    
    @if($event->description)
        <h3>📋 Event Description</h3>
        <div class="info-box">
            <p>{{ $event->description }}</p>
        </div>
    @endif
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('ticket.show', $event) }}" class="btn" style="margin-right: 10px;">
            View Your Event
        </a>
        <a href="{{ url('/create_events') }}" class="btn btn-secondary">
            Manage Events
        </a>
    </div>
    
    <h3>🚀 What's Next?</h3>
    <ul>
        <li><strong>📢 Promote Your Event:</strong> Share your event link on social media and with your network</li>
        <li><strong>📊 Monitor Sales:</strong> Keep track of ticket sales through your organizer dashboard</li>
        <li><strong>📧 Engage Attendees:</strong> Send updates and reminders to keep attendees excited</li>
        <li><strong>📋 Prepare Logistics:</strong> Plan for check-in, venue setup, and event execution</li>
        <li><strong>📱 Stay Connected:</strong> You'll receive notifications when people buy tickets</li>
    </ul>
    
    <div class="info-box">
        <h4>💡 Success Tips</h4>
        <p>
            • <strong>High-Quality Images:</strong> Add compelling event images to attract more attendees<br>
            • <strong>Detailed Descriptions:</strong> Provide clear information about what attendees can expect<br>
            • <strong>Early Bird Pricing:</strong> Consider promotional pricing to boost early sales<br>
            • <strong>Social Proof:</strong> Encourage early attendees to share and invite friends
        </p>
    </div>
    
    <h3>📊 Current Status</h3>
    <div class="success-box">
        <h4>Event Performance</h4>
        <p>
            <strong>Tickets Sold:</strong> 0 tickets<br>
            <strong>Revenue Generated:</strong> $0.00<br>
            <strong>Event Views:</strong> Starting to track...<br>
            <strong>Status:</strong> Active and accepting registrations
        </p>
    </div>
    
    <h3>📢 Promotion Ideas</h3>
    <ul>
        <li>🔗 <strong>Share Event Link:</strong> {{ route('ticket.show', $event) }}</li>
        <li>📱 <strong>Social Media:</strong> Post on Facebook, Twitter, LinkedIn, Instagram</li>
        <li>📧 <strong>Email Marketing:</strong> Send to your email list and contacts</li>
        <li>🤝 <strong>Network:</strong> Ask colleagues and friends to share</li>
        <li>📰 <strong>Local Media:</strong> Reach out to local blogs and news outlets</li>
        <li>🎯 <strong>Targeted Ads:</strong> Consider social media advertising for broader reach</li>
    </ul>
    
    <h3>📞 Need Help?</h3>
    <p>We're here to help you make your event successful:</p>
    <ul>
        <li>📧 <strong>Organizer Support:</strong> <a href="mailto:organizers@evenext.com">organizers@evenext.com</a></li>
        <li>📚 <strong>Organizer Guide:</strong> <a href="{{ url('/organizer-guide') }}">Best Practices & Tips</a></li>
        <li>💬 <strong>Community Forum:</strong> <a href="#">Connect with other organizers</a></li>
        <li>📱 <strong>General Support:</strong> <a href="mailto:support@evenext.com">support@evenext.com</a></li>
    </ul>
    
    <div class="warning-box">
        <h4>📋 Important Reminders</h4>
        <p>
            • Keep your event information updated if anything changes<br>
            • Respond promptly to attendee questions and inquiries<br>
            • Prepare for event check-in with attendee lists<br>
            • Follow up with attendees after the event for feedback
        </p>
    </div>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/organizer/dashboard') }}" class="btn btn-secondary">Go to Organizer Dashboard</a>
    </div>
    
    <p>We're excited to see your event succeed and help you create an amazing experience for your attendees!</p>
    
    <p>Best regards,<br>
    <strong>The Evenext Team</strong></p>
@endsection
