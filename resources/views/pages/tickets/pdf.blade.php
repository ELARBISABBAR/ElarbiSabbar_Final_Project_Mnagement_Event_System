<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ticket - {{ $event->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .ticket {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .ticket-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .ticket-header h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: bold;
        }
        .ticket-header p {
            margin: 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .ticket-body {
            padding: 30px;
        }
        .ticket-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .info-item {
            border-left: 4px solid #667eea;
            padding-left: 15px;
        }
        .info-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }
        .ticket-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .ticket-details h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 18px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .detail-label {
            color: #666;
            font-weight: 500;
        }
        .detail-value {
            color: #333;
            font-weight: 600;
        }
        .ticket-footer {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-top: 2px dashed #ddd;
        }
        .qr-placeholder {
            width: 100px;
            height: 100px;
            background: #e9ecef;
            border: 2px dashed #adb5bd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: #6c757d;
            font-size: 12px;
        }
        .ticket-id {
            font-family: monospace;
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        .print-button {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 20px;
        }
        .print-button:hover {
            background: #5a6fd8;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="ticket-header">
            <h1>{{ $event->title }}</h1>
            <p>Event Ticket</p>
        </div>

        <div class="ticket-body">
            <div class="ticket-info">
                <div class="info-item">
                    <div class="info-label">Date & Time</div>
                    <div class="info-value">{{ $event->date_start->format('M j, Y') }}</div>
                    <div class="info-value">{{ $event->date_start->format('g:i A') }} - {{ $event->date_end->format('g:i A') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Location</div>
                    <div class="info-value">{{ $event->location }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Organizer</div>
                    <div class="info-value">{{ $event->user->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Attendee</div>
                    <div class="info-value">{{ $user->name }}</div>
                </div>
            </div>

            <div class="ticket-details">
                <h3>Ticket Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Ticket Type:</span>
                    <span class="detail-value">{{ ucfirst($ticket->ticket_type) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Quantity:</span>
                    <span class="detail-value">{{ $ticket->quantity }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Price per Ticket:</span>
                    <span class="detail-value">${{ number_format($ticket->price, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Amount:</span>
                    <span class="detail-value">${{ number_format($ticket->price * $ticket->quantity, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Purchase Date:</span>
                    <span class="detail-value">{{ $ticket->created_at->format('M j, Y g:i A') }}</span>
                </div>
            </div>

            @if($event->description)
            <div class="ticket-details">
                <h3>Event Description</h3>
                <p style="margin: 0; color: #666; line-height: 1.5;">{{ $event->description }}</p>
            </div>
            @endif
        </div>

        <div class="ticket-footer">
            <div class="qr-placeholder">
                QR Code
            </div>
            <div class="ticket-id">Ticket ID: #{{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) }}</div>
            <p style="margin: 0; font-size: 12px; color: #666;">
                Please present this ticket at the event entrance
            </p>
            <button class="print-button" onclick="window.print()">Print Ticket</button>
        </div>
    </div>

    <script>
    </script>
</body>
</html>
