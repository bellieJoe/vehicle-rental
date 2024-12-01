<x-master>
    <h4 class="h4">Payment Collections Report</h4>
    <div class="card">
        <div class="card-body">
            <form action="" method="GET" class="mb-4">
                <div class="row align-items-end" style="width: 100%">
                    <div class="form-group col-md-6">
                        <label for="report_type" class="font-weight-bold">Filter :</label>
                        <select name="filter" id="report_type" class="form-control">
                            <option value="monthly" {{ $filter == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="weekly" {{ $filter == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="daily" {{ $filter == 'daily' ? 'selected' : '' }}>Daily</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-lg-5 tw-max-w-[150px]">
                        <button type="submit" class="btn btn-primary btn-block">Apply Filter</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table border">
                    <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Paid By</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ $payment->date_paid ? $payment->date_paid->format('M d, Y h:i A') : 'N/A' }}</td>
                                <td>PHP {{ number_format($payment->amount, 2) }}</td>
                                <td>{{ $payment->payment_method }}</td>
                                <td>{{ $payment->booking->user->name }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">No Payments</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $payments->links() }}

            <div class="d-flex justify-content-end align-items-center bg-light p-2 rounded">
                <strong class="mr-2">Total Amount:</strong>
                <span class="font-weight-bold text-primary">PHP {{ number_format($totalCollections, 2) }}</span>
            </div>
        </div>
    </div>
</x-master>