@extends('emails.layout')

@section('title', 'Welcome to Evenext!')

@section('header-title', 'Welcome to Evenext!')
@section('header-subtitle', 'Start Discovering Amazing Events')

@section('content')
    <h2>Hello {{ $user->name }}! 🎉</h2>
    
    <p>Welcome to <strong>Evenext</strong> - your gateway to discovering and attending incredible events! We're thrilled to have you join our community of event enthusiasts.</p>
    
    <div class="success-box">
        <h4>🎊 Your Account is Ready!</h4>
        <p>Your attendee account has been successfully created and you can now start exploring events in your area.</p>
    </div>
    
    <h3>What You Can Do Now:</h3>
    <ul>
        <li><strong>🔍 Discover Events:</strong> Browse through hundreds of amazing events happening near you</li>
        <li><strong>🎫 Buy Tickets:</strong> Secure your spot at events with our easy ticket purchasing system</li>
        <li><strong>❤️ Save Favorites:</strong> Keep track of events you're interested in</li>
        <li><strong>📱 Get Notifications:</strong> Stay updated about new events in your favorite categories</li>
        <li><strong>⭐ Leave Reviews:</strong> Share your experience and help others discover great events</li>
    </ul>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/') }}" class="btn">Start Exploring Events</a>
    </div>
    
    <h3>Popular Event Categories:</h3>
    <p>Here are some popular categories you might be interested in:</p>
    <ul>
        <li>🎤 <strong>Conferences:</strong> Professional conferences and seminars</li>
        <li>🛠️ <strong>Workshops:</strong> Educational workshops and training sessions</li>
        <li>🤝 <strong>Networking:</strong> Networking events and meetups</li>
        <li>🎉 <strong>Entertainment:</strong> Entertainment and social events</li>
    </ul>
    
    <div class="info-box">
        <h4>💡 Pro Tip</h4>
        <p>Set up your profile preferences to receive personalized event recommendations based on your interests and location!</p>
    </div>
    
    <h3>Need Help Getting Started?</h3>
    <p>Our support team is here to help you make the most of your Evenext experience:</p>
    <ul>
        <li>📧 Email us at <a href="mailto:support@evenext.com">support@evenext.com</a></li>
        <li>💬 Check out our <a href="{{ url('/help') }}">Help Center</a></li>
        <li>📱 Follow us on social media for event updates and tips</li>
    </ul>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/profile') }}" class="btn btn-secondary">Complete Your Profile</a>
    </div>
    
    <p>Thank you for choosing Evenext. We can't wait to see you at your first event!</p>
    
    <p>Best regards,<br>
    <strong>The Evenext Team</strong></p>
@endsection
