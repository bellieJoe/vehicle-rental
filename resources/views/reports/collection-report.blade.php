<x-master>
    <h4 class="h4">Payment Collections Report</h4>
    <div class="card">
        <div class="card-body">
            <div class="card mb-4">
                <div class="card-header">Filter</div>
                <div class="card-body">
                    <form action="" method="GET" class="mb-0">
                        <div class="row align-items-end" style="width: 100%">
                            <div class="form-group col-md-6">
                                <label for="report_type" class="font-weight-bold">Filter By :</label>
                                <select name="filter" id="report_type" class="form-control" onchange="showHideDateInput(this.value)">
                                    <option value="monthly" {{ $filter == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="weekly" {{ $filter == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="daily" {{ $filter == 'daily' ? 'selected' : '' }}>Daily</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="date_input">
                                <label for="date" class="font-weight-bold">Date:</label>
                                <input type="date" name="date" id="date" value="{{ request()->query('date') }}" class="form-control">
                            </div>
                            <div class="form-group col-md-6" id="month_input">
                                <label for="month" class="font-weight-bold">Month:</label>
                                <input type="month" name="month" id="month" value="{{ request()->query('month') }}" class="form-control">
                            </div>
                            <div class="form-group col-md-6" id="week_input">
                                <label for="week" class="font-weight-bold">Week:</label>
                                <input type="week" name="week" id="week" value="{{ request()->query('week') }}" class="form-control">
                            </div>
                            <div class="form-group col-md-6 col-lg-5 tw-max-w-[150px] mb-0">
                                <button type="submit" class="btn btn-primary btn-block mb-0">Apply Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('#report_type').on('change', function() {
                        showHideDateInput(this.value);
                    })
                    $('#report_type').trigger('change');
                })
                function showHideDateInput(reportType) {
                    const dateInput = document.getElementById('date_input');
                    const monthInput = document.getElementById('month_input');
                    const weekInput = document.getElementById('week_input');

                    if (reportType === 'monthly') {
                        dateInput.style.display = 'none';
                        monthInput.style.display = 'block';
                        weekInput.style.display = 'none';
                    } else if (reportType === 'weekly') {
                        dateInput.style.display = 'none';
                        monthInput.style.display = 'none';
                        weekInput.style.display = 'block';
                    } else {
                        dateInput.style.display = 'block';
                        monthInput.style.display = 'none';
                        weekInput.style.display = 'none';
                    }
                }
            </script>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <button onclick="printReport()" class="btn btn-primary">Print Report</button>
            </div>

            <div class="printable">
                <h4 class="h4 text-center">
                    Payment Collections Report - 
                    @if ($filter === 'monthly')
                        {{ \Carbon\Carbon::parse(request('month'))->format('F Y') }}
                    @elseif ($filter === 'weekly')
                        {{ \Carbon\Carbon::parse(request('week'))->startOfWeek()->format('M d, Y') }} 
                        - 
                        {{ \Carbon\Carbon::parse(request('week'))->endOfWeek()->format('M d, Y') }}
                    @elseif ($filter === 'daily')
                        {{ \Carbon\Carbon::parse(request('date'))->format('M d, Y') }}
                    @else
                        All Time
                    @endif
                </h4>

                <div class="d-flex justify-content-end align-items-center bg-light p-2 rounded">
                    <strong class="mr-2">Total Amount:</strong>
                    <span class="font-weight-bold text-primary">PHP {{ number_format($totalCollections, 2) }}</span>
                </div>

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
            </div>
        </div>
    </div>

    <script>
        function printReport() {
            const printableContent = document.querySelector('.printable').outerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Print Report</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                margin: 20px;
                            }
                            .table {
                                width: 100%;
                                border-collapse: collapse;
                            }
                            .table th, .table td {
                                border: 1px solid #ddd;
                                padding: 8px;
                                text-align: left;
                            }
                            .table th {
                                background-color: #f2f2f2;
                                font-weight: bold;
                            }
                            .h4 {
                                margin: 0;
                                margin-bottom: 20px;
                                text-align: center;
                            }
                        </style>
                    </head>
                    <body>${printableContent}</body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</x-master>
