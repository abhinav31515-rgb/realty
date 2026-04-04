<div style="font-family: 'Georgia', serif; color: #1a1c1b; padding: 40px; background: #f9f9f7; border: 1px solid #C5A059;">
  <h2 style="font-weight: normal;">Showing Request: {{ $booking->property->title }}</h2>
  <p>A new private showing has been requested by {{ $booking->customer->name }}.</p>
  <p><strong>Scheduled Date:</strong> {{ $booking->scheduled_at->format('M d, Y @ h:i A') }}</p>
  <a href="{{ url('/agent') }}" style="display: inline-block; padding: 15px 30px; background: #C5A059; color: white; text-decoration: none; font-size: 12px; text-transform: uppercase; font-weight: bold; margin-top: 20px;">Review Request</a>
</div>
