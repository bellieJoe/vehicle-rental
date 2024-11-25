
<div style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; font-family: Arial, sans-serif; color: #333;">
    <!-- Header -->
    <header style="text-align: center; margin-bottom: 20px;">
        <h1 style="font-size: 24px; font-weight: bold; margin: 0; color: #444;">Payment Receipt</h1>
        <p style="font-size: 14px; color: #666; margin: 5px 0 0;">Thank you for your payment!</p>
    </header>

    <!-- Receipt Info -->
    <div style="background-color: #f9f9f9; border: 1px solid #eee; border-radius: 5px; padding: 15px; margin-bottom: 20px;">
        <p style="margin: 5px 0;"><strong>Receipt ID:</strong> #{{ $payment->id }}</p>
        <p style="margin: 5px 0;"><strong>Date Issued:</strong> {{ $payment->created_at->format('F j, Y, g:i a') }}</p>
        <p style="margin: 5px 0;">
            <strong>Status:</strong> 
            <span style="padding: 5px 10px; border-radius: 4px; color: #fff; background-color: {{ $payment->payment_status == 'Completed' ? '#28a745' : '#ffc107' }};">
                {{ $payment->payment_status }}
            </span>
        </p>
    </div>

    <!-- Payment Details -->
    <section style="margin-bottom: 20px;">
        <h2 style="font-size: 18px; font-weight: bold; border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-bottom: 15px;">Payment Details</h2>
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <tbody>
                <tr>
                    <th style="background-color: #f0f0f0; text-align: left; padding: 8px; border: 1px solid #ddd;">Payment Method:</th>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $payment->payment_method }}</td>
                </tr>
                <tr>
                    <th style="background-color: #f0f0f0; text-align: left; padding: 8px; border: 1px solid #ddd;">Booking Transaction #:</th>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $payment->booking->transaction_number }}</td>
                </tr>
                <tr>
                    <th style="background-color: #f0f0f0; text-align: left; padding: 8px; border: 1px solid #ddd;">Booking Type:</th>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $payment->booking->booking_type }}</td>
                </tr>
                <tr>
                    <th style="background-color: #f0f0f0; text-align: left; padding: 8px; border: 1px solid #ddd;">Client Name:</th>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $payment->booking->name }}</td>
                </tr>
                <tr>
                    <th style="background-color: #f0f0f0; text-align: left; padding: 8px; border: 1px solid #ddd;">Client Contact #:</th>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $payment->booking->contact_number }}</td>
                </tr>
                <tr>
                    <th style="background-color: #f0f0f0; text-align: left; padding: 8px; border: 1px solid #ddd;">Amount Paid:</th>
                    <td style="padding: 8px; border: 1px solid #ddd;">PHP {{ number_format($payment->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </section>

    <!-- Footer -->
    <footer style="text-align: center; margin-top: 20px;">
        <p style="font-size: 12px; color: #666;">All Rights reserve iRENTA HUB </p>
    </footer>
</div>
