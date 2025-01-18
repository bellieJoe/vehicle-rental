<x-master>
    <h4 class="h4">Services Report</h4>
    <div class="card">
        <div class="card-body">

            <div class="card mb-4">
                <div class="card-header">Filter</div>
                <div class="card-body">
                    <form action="" method="GET" class="mb-0 form-inline">
                        <div class="row align-items-end" style="width: 100%">
                            <div class="form-group">
                                <label for="report_type" class="font-weight-bold mr-2">Operator :</label>
                                <select name="user_id" id="operator" class="form-control">
                                    <option value="All" {{ !request("user_id") ? 'selected' : '' }}>All</option>
                                    @foreach ($operators as $operator)
                                        <option value="{{ $operator->user_id }}" {{ request("user_id") && request("user_id")  == $operator->user_id ? 'selected' : '' }}>{{ $operator->org_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-lg-5 tw-max-w-[150px] mb-0">
                                <button type="submit" class="btn btn-primary btn-block mb-0">Apply Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <button onclick="printReport()" class="btn btn-primary">Print Report</button>
            </div>

            <div class="printable">

                {{-- <div class="d-flex justify-content-end align-items-center bg-light p-2 rounded">
                    <strong class="mr-2">Total Cancellations:</strong>
                    <span class="font-weight-bold text-primary">{{ $bookings->count() }}</span>
                </div> --}}

                <div class="table-responsive">
                    <h5 for="">Vehicles</h5>
                    <table class="table border">
                        <thead>
                            <tr>
                                <th scope="col">Operator</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Model</th>
                                <th scope="col">Plate Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($vehicles as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->user->organisation->org_name }}</td>
                                    <td>{{ $vehicle->brand }}</td>
                                    <td>{{ $vehicle->model }}</td>
                                    <td>{{ $vehicle->plate_number }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No Vehicles</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <br>
                <hr>
                <div class="table-responsive">
                    <h5 for="">Packages</h5>
                    <table class="table border">
                        <thead>
                            <tr>
                                <th scope="col">Operator</th>
                                <th scope="col">Package Name</th>
                                <th scope="col">Minimum Pax</th>
                                <th scope="col">Price Per Person</th>
                                <th scope="col">Package Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($packages as $item)
                                <tr>
                                    <td>{{ $item->user->organisation->org_name }}</td>
                                    <td>{{ $item->package_name }}</td>
                                    <td>{{ $item->minimum_pax }} person/s</td>
                                    <td>PHP {{ number_format($item->price_per_person, 2) }}</td>
                                    <td>{{ $item->package_duration }} day/s</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Packages</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <br>
                <hr>
                <div class="table-responsive">
                    <h5 for="">Door to Doors</h5>
                    <table class="table border">
                        <thead>
                            <tr>
                                <th scope="col">Operator</th>
                                <th scope="col">Name</th>
                                <th scope="col">Max Capacity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($d2ds as $item)
                                <tr>
                                    <td>{{ $item->user->organisation->org_name }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->max_cap }} person/s</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">No Door to Door</td></tr>
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
