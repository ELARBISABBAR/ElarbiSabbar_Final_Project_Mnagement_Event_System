@extends('emails.layout')

@section('title', 'New Ticket Sale - ' . $event->title)

@section('header-title', 'New Ticket Sale!')
@section('header-subtitle', 'You just made a sale')

@section('content')
    <h2>Hello {{ $organizer->name }}! 💰</h2>
    
    <p>Congratulations! Someone just purchased tickets for your event <strong>{{ $event->title }}</strong>. Here are the details of your latest sale:</p>
    
    <div class="success-box">
        <h4>🎉 Sale Confirmed</h4>
        <p>You've received <strong>${{ number_format($ticket->total_amount, 2) }}</strong> from this ticket sale!</p>
        @if($transactionId)
            <p><strong>Transaction ID:</strong> {{ $transactionId }}</p>
        @endif
    </div>
    
    <!-- Sale Details -->
    <h3>💳 Sale Information</h3>
    <div class="info-box">
        <h4>Transaction Details</h4>
        <p>
            <strong>Sale Amount:</strong> ${{ number_format($ticket->total_amount, 2) }}<br>
            <strong>Tickets Sold:</strong> {{ $ticket->quantity }} {{ Str::plural('ticket', $ticket->quantity) }}<br>
            <strong>Price per Ticket:</strong> ${{ number_format($ticket->price, 2) }}<br>
            <strong>Payment Method:</strong> {{ ucfirst($ticket->payment_method) }}<br>
            <strong>Sale Date:</strong> {{ $ticket->purchased_at->format('M j, Y \a\t g:i A') }}<br>
            <strong>Ticket ID:</strong> #{{ $ticket->id }}
        </p>
    </div>
    
    <!-- Customer Details -->
    <h3>👤 Customer Information</h3>
    <div class="info-box">
        <h4>Attendee Details</h4>
        <p>
            <strong>Name:</strong> {{ $attendee->name }}<br>
            <strong>Email:</strong> {{ $attendee->email }}<br>
            @if($attendee->phone)
                <strong>Phone:</strong> {{ $attendee->phone }}<br>
            @endif
            <strong>Registration Date:</strong> {{ $attendee->created_at->format('M j, Y') }}
        </p>
    </div>
    
    <!-- Event Summary -->
    <h3>📅 Event Summary</h3>
    <div class="info-box">
        <h4>{{ $event->title }}</h4>
        <p>
            <strong>📍 Location:</strong> {{ $event->location }}<br>
            <strong>📅 Date:</strong> {{ $event->date_start->format('l, F j, Y') }}<br>
            <strong>🕐 Time:</strong> {{ $event->date_start->format('g:i A') }} - {{ $event->date_end->format('g:i A') }}<br>
            @if($event->category)
                <strong>🏷️ Category:</strong> {{ $event->category->name }}<br>
            @endif
        </p>
    </div>
    
    <!-- Sales Statistics -->
    @php
        $totalTicketsSold = $event->tickets->where('is_paid', true)->sum('quantity');
        $totalRevenue = $event->tickets->where('is_paid', true)->sum('total_amount');
        $totalSales = $event->tickets->where('is_paid', true)->count();
    @endphp
    
    <h3>📊 Your Event Statistics</h3>
    <div class="success-box">
        <h4>Current Performance</h4>
        <p>
            <strong>Total Tickets Sold:</strong> {{ $totalTicketsSold }} tickets<br>
            <strong>Total Revenue:</strong> ${{ number_format($totalRevenue, 2) }}<br>
            <strong>Number of Sales:</strong> {{ $totalSales }} {{ Str::plural('transaction', $totalSales) }}<br>
            <strong>Average Sale:</strong> ${{ $totalSales > 0 ? number_format($totalRevenue / $totalSales, 2) : '0.00' }}
        </p>
    </div>
    
    <!-- Action Buttons -->
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/create_events') }}" class="btn" style="margin-right: 10px;">
            Manage Event
        </a>
        <a href="{{ url('/organizer/sales') }}" class="btn btn-secondary">
            View All Sales
        </a>
    </div>
    
    <!-- Next Steps -->
    <h3>🚀 What's Next?</h3>
    <ul>
        <li><strong>Prepare for Success:</strong> More attendees might be on the way!</li>
        <li><strong>Engage Attendees:</strong> Consider sending updates about your event</li>
        <li><strong>Promote More:</strong> Share your event to reach more potential attendees</li>
        <li><strong>Plan Logistics:</strong> Ensure you're ready for the number of attendees</li>
    </ul>
    
    <div class="info-box">
        <h4>💡 Organizer Tips</h4>
        <p>
            • Keep attendees engaged with event updates and reminders<br>
            • Prepare for check-in by having the attendee list ready<br>
            • Consider creating a follow-up survey for feedback<br>
            • Promote your future events to this engaged audience
        </p>
    </div>
    
    <!-- Payment Information -->
    <h3>💰 Payment Processing</h3>
    <p>Your payment will be processed according to your payout schedule:</p>
    <ul>
        <li>💳 <strong>Payment Method:</strong> Stripe (secure processing)</li>
        <li>📅 <strong>Payout Schedule:</strong> According to your Stripe settings</li>
        <li>🧾 <strong>Transaction Fees:</strong> Standard processing fees apply</li>
        <li>📊 <strong>Detailed Reports:</strong> Available in your organizer dashboard</li>
    </ul>
    
    <!-- Contact Information -->
    <h3>📞 Need Support?</h3>
    <p>If you have questions about this sale or need help with your event:</p>
    <ul>
        <li>💰 <strong>Payment Support:</strong> <a href="mailto:payments@evenext.com">payments@evenext.com</a></li>
        <li>📧 <strong>Organizer Support:</strong> <a href="mailto:organizers@evenext.com">organizers@evenext.com</a></li>
        <li>💬 <strong>General Support:</strong> <a href="mailto:support@evenext.com">support@evenext.com</a></li>
    </ul>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/organizer/dashboard') }}" class="btn btn-secondary">Go to Dashboard</a>
    </div>
    
    <p>Keep up the great work! We're excited to see your event succeed.</p>
    
    <p>Best regards,<br>
    <strong>The Evenext Team</strong></p>
@endsection
