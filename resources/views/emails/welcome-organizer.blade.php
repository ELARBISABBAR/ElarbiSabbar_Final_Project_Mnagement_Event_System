@extends('emails.layout')

@section('title', 'Welcome to Evenext - Event Organizer!')

@section('header-title', 'Welcome to Evenext!')
@section('header-subtitle', 'Start Creating Amazing Events')

@section('content')
    <h2>Hello {{ $user->name }}! 🚀</h2>
    
    <p>Welcome to <strong>Evenext</strong> as an Event Organizer! We're excited to have you join our community of event creators and help you bring your amazing events to life.</p>
    
    <div class="success-box">
        <h4>🎯 Your Organizer Account is Ready!</h4>
        <p>Your organizer account has been successfully created. You can now start creating and managing events on our platform.</p>
    </div>
    
    <div class="warning-box">
        <h4>⏳ Account Under Review</h4>
        <p>Your organizer account is currently under review by our admin team. You'll receive a confirmation email once your account is approved and you can start creating events.</p>
    </div>
    
    <h3>What You Can Do as an Organizer:</h3>
    <ul>
        <li><strong>📅 Create Events:</strong> Design and publish your events with our intuitive event creation tools</li>
        <li><strong>🎫 Manage Tickets:</strong> Set pricing, manage inventory, and track sales</li>
        <li><strong>💰 Receive Payments:</strong> Get paid securely through our integrated Stripe payment system</li>
        <li><strong>📊 Track Analytics:</strong> Monitor event performance, ticket sales, and attendee engagement</li>
        <li><strong>📧 Communicate:</strong> Send updates and notifications to your event attendees</li>
        <li><strong>⭐ Build Reputation:</strong> Collect reviews and build your organizer profile</li>
    </ul>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/create_events') }}" class="btn">Create Your First Event</a>
    </div>
    
    <h3>Getting Started Guide:</h3>
    <p>Here's how to make the most of your organizer account:</p>
    <ul>
        <li><strong>Step 1:</strong> Complete your organizer profile with detailed information</li>
        <li><strong>Step 2:</strong> Wait for admin approval (usually within 24-48 hours)</li>
        <li><strong>Step 3:</strong> Create your first event with compelling descriptions and images</li>
        <li><strong>Step 4:</strong> Set up your payment information to receive ticket sales</li>
        <li><strong>Step 5:</strong> Promote your event and start selling tickets!</li>
    </ul>
    
    <div class="info-box">
        <h4>💡 Organizer Tips</h4>
        <p>
            • Use high-quality images to make your events stand out<br>
            • Write detailed descriptions to help attendees understand what to expect<br>
            • Set competitive pricing based on your event value<br>
            • Promote your events on social media for better reach
        </p>
    </div>
    
    <h3>Event Categories Available:</h3>
    <p>You can create events in these popular categories:</p>
    <ul>
        <li>🎤 <strong>Conferences:</strong> Professional conferences and seminars</li>
        <li>🛠️ <strong>Workshops:</strong> Educational workshops and training sessions</li>
        <li>🤝 <strong>Networking:</strong> Networking events and meetups</li>
        <li>🎉 <strong>Entertainment:</strong> Entertainment and social events</li>
    </ul>
    
    <h3>Support & Resources:</h3>
    <p>We're here to help you succeed as an event organizer:</p>
    <ul>
        <li>📧 Organizer support: <a href="mailto:organizers@evenext.com">organizers@evenext.com</a></li>
        <li>📚 <a href="{{ url('/organizer-guide') }}">Organizer Guide & Best Practices</a></li>
        <li>💬 Join our <a href="#">Organizer Community Forum</a></li>
        <li>📱 Follow us for organizer tips and platform updates</li>
    </ul>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/organizer/dashboard') }}" class="btn btn-secondary">Go to Organizer Dashboard</a>
    </div>
    
    <p>We're excited to see the amazing events you'll create on Evenext. Thank you for choosing our platform to bring your vision to life!</p>
    
    <p>Best regards,<br>
    <strong>The Evenext Team</strong></p>
@endsection
