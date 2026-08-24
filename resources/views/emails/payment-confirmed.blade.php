<div style="font-family: 'Sora', sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden;">
    <div style="background-color: #4f46e5; padding: 32px; text-align: center; color: white;">
        <h1 style="margin: 0; font-size: 24px; font-weight: 800;">Payment Confirmed</h1>
        <p style="margin: 8px 0 0; opacity: 0.8;">Thank you for your payment!</p>
    </div>

    <div style="padding: 32px; color: #374151;">
        <p style="font-size: 16px; margin-bottom: 24px;">Hello,</p>
        <p style="font-size: 14px; line-height: 1.6; margin-bottom: 24px;">
            We have successfully verified your payment for shipment <strong>{{ $shipment->tracking_number }}</strong>.
        </p>

        <div style="background-color: #f9fafb; border-radius: 12px; padding: 24px; margin-bottom: 24px; border: 1px solid #e5e7eb;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #6b7280; font-size: 14px;">Invoice Number:</span>
                <span style="font-weight: 600; font-size: 14px;">#{{ $payment->invoice->invoice_number }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #6b7280; font-size: 14px;">Amount Paid:</span>
                <span style="font-weight: 600; font-size: 14px;">{{ $payment->invoice->currency }} {{ number_format($payment->amount, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #6b7280; font-size: 14px;">Remaining Balance:</span>
                <span style="font-weight: 600; font-size: 14px;">{{ $payment->invoice->currency }} {{ number_format($payment->invoice->total - $payment->amount, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #6b7280; font-size: 14px;">Receipt Number:</span>
                <span style="font-weight: 600; font-size: 14px;">{{ $payment->receipt->receipt_number ?? 'Generating...' }}</span>
            </div>
        </div>

        <div style="text-align: center; margin-bottom: 24px;">
            @if($payment->receipt)
                <a href="{{ route('track.receipt', $payment->receipt->receipt_number) }}"
                   style="background-color: #4f46e5; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-block;">
                    View Official Receipt
                </a>
            @endif
        </div>

        <p style="font-size: 14px; color: #6b7280; text-align: center; margin-bottom: 0;">
            If you have any questions, please contact our support team.
        </p>
    </div>
</div>
