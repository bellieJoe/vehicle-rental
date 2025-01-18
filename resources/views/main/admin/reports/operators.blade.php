<x-master>
    <h4 class="h4">Operators Report</h4>
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <button onclick="printReport()" class="btn btn-primary">Print Report</button>
            </div>

            <div class="printable">

                {{-- <div class="d-flex justify-content-end align-items-center bg-light p-2 rounded">
                    <strong class="mr-2">Total Cancellations:</strong>
                    <span class="font-weight-bold text-primary">{{ $bookings->count() }}</span>
                </div> --}}

                <div class="table-responsive">
                    <label for="">{{ $operator_count }} Operators</label>
                    <table class="table border">
                        <thead>
                        <tr>
                            <th scope="col">Operator Name</th>
                            <th scope="col">Representative</th>
                            <th scope="col">Address</th>
                            <th scope="col">GCash</th>
                            <th scope="col">Email</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($operators as $operator)
                                <tr>
                                    <td>{{ $operator->org_name }}</td>
                                    <td>{{ $operator->name }}</td>
                                    <td>{{ $operator->address }}</td>
                                    <td>{{ $operator->gcash_number }}</td>
                                    <td>{{ $operator->email }}</td>
                                </tr>
                            @endforeach
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
                            .text-center {
                                text-align: center;
                            }
                            h1, h2, h3, h4, h5, h6 {
                                margin-bottom: 0px;
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
