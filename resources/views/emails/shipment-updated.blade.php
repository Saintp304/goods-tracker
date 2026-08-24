<div style="font-family: 'Sora', sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden;">
    <div style="background-color: #4f46e5; padding: 32px; text-align: center; color: white;">
        <h1 style="margin: 0; font-size: 24px; font-weight: 800;">Shipment Update</h1>
        <p style="margin: 8px 0 0; opacity: 0.8;">Your shipment is on the move!</p>
    </div>

    <div style="padding: 32px; color: #374151;">
        <p style="font-size: 16px; margin-bottom: 24px;">Hello,</p>
        <p style="font-size: 14px; line-height: 1.6; margin-bottom: 24px;">
            Your shipment <strong style="color: #4f46e5;">{{ $shipment->tracking_number }}</strong> has been updated.
        </p>

        <div style="background-color: #f9fafb; border-radius: 12px; padding: 24px; margin-bottom: 24px; border: 1px solid #e5e7eb;">
            <div style="margin-bottom: 12px;">
                <span style="color: #6b7280; font-size: 14px; font-weight: bold; uppercase">Current Status:</span>
                <span style="font-weight: 600; font-size: 14px; margin-left: 8px;">{{ ucfirst($shipment->status) }}</span>
            </div>
            <div style="margin-bottom: 12px;">
                <span style="color: #6b7280; font-size: 14px; font-weight: bold; uppercase">Latest Location:</span>
                <span style="font-weight: 600; font-size: 14px; margin-left: 8px;">{{ $history->location }}</span>
            </div>
            <div style="margin-bottom: 12px;">
                <span style="color: #6b7280; font-size: 14px; font-weight: bold; uppercase">Update:</span>
                <span style="font-weight: 600; font-size: 14px; margin-left: 8px;">{{ $history->description }}</span>
            </div>
            @if ($shipment->eta)
                <div style="margin-bottom: 0;">
                    <span style="color: #6b7280; font-size: 14px; font-weight: bold; uppercase">Estimated Arrival:</span>
                    <span style="font-weight: 600; font-size: 14px; margin-left: 8px;">{{ $shipment->eta->format('M d, Y') }}</span>
                </div>
            @endif
        </div>

        <div style="text-align: center; margin-bottom: 24px;">
            <a href="{{ route('track', ['trackingNumber' => $shipment->tracking_number]) }}"
               style="background-color: #4f46e5; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-block;">
                Track My Shipment
            </a>
        </div>

        <p style="font-size: 14px; color: #6b7280; text-align: center; margin-bottom: 0;">
            If you have any questions, please contact our support team.
        </p>
    </div>
</div>
