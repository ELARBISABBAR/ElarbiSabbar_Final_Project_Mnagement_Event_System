<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Evenext')</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #374151;
            background-color: #f9fafb;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            padding: 40px 30px;
            text-align: center;
        }
        
        .email-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .email-header p {
            color: #dbeafe;
            font-size: 16px;
        }
        
        .email-body {
            padding: 40px 30px;
        }
        
        .email-content h2 {
            color: #1f2937;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        
        .email-content h3 {
            color: #374151;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 12px;
            margin-top: 24px;
        }
        
        .email-content p {
            margin-bottom: 16px;
            font-size: 16px;
            line-height: 1.7;
        }
        
        .email-content ul {
            margin-bottom: 16px;
            padding-left: 20px;
        }
        
        .email-content li {
            margin-bottom: 8px;
            font-size: 16px;
        }
        
        .btn {
            display: inline-block;
            padding: 14px 28px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(59, 130, 246, 0.3);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        }
        
        .info-box {
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .info-box h4 {
            color: #0369a1;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .info-box p {
            color: #0c4a6e;
            margin-bottom: 0;
        }
        
        .warning-box {
            background-color: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .warning-box h4 {
            color: #d97706;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .success-box {
            background-color: #dcfce7;
            border: 1px solid #86efac;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .success-box h4 {
            color: #16a34a;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .email-footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .email-footer p {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .email-footer a {
            color: #3b82f6;
            text-decoration: none;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #6b7280;
            text-decoration: none;
        }
        
        /* Mobile responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .email-header,
            .email-body,
            .email-footer {
                padding: 20px;
            }
            
            .email-header h1 {
                font-size: 24px;
            }
            
            .email-content h2 {
                font-size: 20px;
            }
            
            .btn {
                display: block;
                text-align: center;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>@yield('header-title', 'Evenext')</h1>
            <p>@yield('header-subtitle', 'Your Event Management Platform')</p>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <div class="email-content">
                @yield('content')
            </div>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <p><strong>Evenext</strong> - Connecting People Through Amazing Events</p>
            <p>© {{ date('Y') }} Evenext. All rights reserved.</p>
            
            <div class="social-links">
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">LinkedIn</a>
                <a href="#">Instagram</a>
            </div>
            
            <p>
                <a href="{{ url('/') }}">Visit our website</a> | 
                <a href="#">Unsubscribe</a> | 
                <a href="#">Contact Support</a>
            </p>
            
            <p style="margin-top: 20px; font-size: 12px; color: #9ca3af;">
                This email was sent to you because you have an account with Evenext. 
                If you received this email by mistake, please ignore it.
            </p>
        </div>
    </div>
</body>
</html>
