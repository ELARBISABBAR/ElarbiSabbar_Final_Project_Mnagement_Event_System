@extends('emails.layout')

@section('title', 'New Organizer Registration - Action Required')

@section('header-title', 'New Organizer Registration')
@section('header-subtitle', 'Admin Action Required')

@section('content')
    <h2>New Organizer Registration Alert 🚨</h2>
    
    <p>A new user has registered as an event organizer on Evenext and requires admin approval before they can start creating events.</p>
    
    <div class="warning-box">
        <h4>⏳ Action Required</h4>
        <p>Please review this organizer registration and approve or reject their account within 48 hours.</p>
    </div>
    
    <h3>Organizer Details:</h3>
    <div class="info-box">
        <h4>👤 User Information</h4>
        <p>
            <strong>Name:</strong> {{ $organizer->name }}<br>
            <strong>Email:</strong> {{ $organizer->email }}<br>
            <strong>Registration Date:</strong> {{ $organizer->created_at->format('M j, Y \a\t g:i A') }}<br>
            <strong>User ID:</strong> #{{ $organizer->id }}<br>
            <strong>Role:</strong> {{ ucfirst($organizer->role) }}
        </p>
    </div>
    
    <h3>Review Checklist:</h3>
    <p>Please verify the following before approving this organizer:</p>
    <ul>
        <li>✅ <strong>Email Verification:</strong> Ensure the email address is valid and verified</li>
        <li>✅ <strong>Profile Completeness:</strong> Check if the user has provided adequate information</li>
        <li>✅ <strong>Background Check:</strong> Verify the organizer's credibility if necessary</li>
        <li>✅ <strong>Terms Compliance:</strong> Ensure they agree to organizer terms and conditions</li>
        <li>✅ <strong>Previous History:</strong> Check for any previous account issues or violations</li>
    </ul>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/admin/organizers/' . $organizer->id . '/approve') }}" class="btn" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); margin-right: 10px;">
            ✅ Approve Organizer
        </a>
        <a href="{{ url('/admin/organizers/' . $organizer->id . '/reject') }}" class="btn" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);">
            ❌ Reject Application
        </a>
    </div>
    
    <h3>Organizer Capabilities:</h3>
    <p>Once approved, this organizer will be able to:</p>
    <ul>
        <li>📅 Create and manage events</li>
        <li>🎫 Set up ticket sales and pricing</li>
        <li>💰 Receive payments through Stripe integration</li>
        <li>📊 Access event analytics and reports</li>
        <li>📧 Send notifications to event attendees</li>
        <li>⭐ Build their organizer reputation through reviews</li>
    </ul>
    
    <div class="info-box">
        <h4>📋 Admin Notes</h4>
        <p>
            • New organizers are automatically notified of approval/rejection decisions<br>
            • Approved organizers receive welcome email with getting started guide<br>
            • Rejected applications can be reconsidered if circumstances change<br>
            • All organizer activities are logged for audit purposes
        </p>
    </div>
    
    <h3>Quick Actions:</h3>
    <p>You can also manage this organizer through the admin panel:</p>
    <ul>
        <li>🔍 <a href="{{ url('/admin/users/' . $organizer->id) }}">View Full User Profile</a></li>
        <li>📧 <a href="mailto:{{ $organizer->email }}">Contact Organizer Directly</a></li>
        <li>📊 <a href="{{ url('/admin/organizers') }}">View All Pending Organizers</a></li>
        <li>⚙️ <a href="{{ url('/admin/settings/organizer-approval') }}">Manage Approval Settings</a></li>
    </ul>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary">Go to Admin Dashboard</a>
    </div>
    
    <div class="warning-box">
        <h4>⚠️ Important Reminder</h4>
        <p>Please process this organizer application promptly. Delayed approvals can impact user experience and platform growth.</p>
    </div>
    
    <p>This notification was automatically generated when user <strong>{{ $organizer->name }}</strong> registered as an organizer.</p>
    
    <p>Best regards,<br>
    <strong>Evenext System</strong></p>
@endsection
