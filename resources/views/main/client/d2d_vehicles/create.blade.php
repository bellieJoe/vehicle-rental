<x-master>
    <h4 class="h4">Book Door to Door</h4>
    <div class="card shadow-sm border-0">
        <div class="card-header">
            {{ $d2d_vehicle->name }}
        </div>
        <div class="card-body">
            <form id="bookD2DForm" method="POST" action="{{ route("client.d2d.store", $d2d_vehicle->id) }}">
                @csrf
                <div class="row ">
                    <div class="col-sm mb-3">
                      <x-forms.input name="name" label="Name" placeholder="Enter name" required />
                    </div>
                    <div class="col-sm mb-3">
                      <x-forms.input name="contact_number" label="Contact Number" placeholder="Enter contact number" required />
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="">Select Schedule</label>
                    <select class="form-control" name="d2d_schedule_id" id="d2d_schedule_id" required>
                        <option value="">Select Schedule</option>
                        @foreach ($schedules as $schedule)
                            <option {{ old("d2d_schedule_id") && old("d2d_schedule_id") == $schedule->id ? "selected" : "" }} value="{{ $schedule->id }}" data-rate="{{ $schedule->route->rate }}">{{ $schedule->depart_date->format("F d, Y") }} - {{ $schedule->route->from_address }} to {{ $schedule->route->to_address }}</option>
                        @endforeach
                    </select>
                    @error('drop_off_location')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Additional Option</label>
                    <select class="form-control" name="additional_rate_id" id="additional_rate_id" >
                        <option value="">(Optional) Select Additional Option</option>
                    </select>
                    @error('additional_rate_id')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <x-forms.input type="text" name="drop_off_location" label="Drop Off Location" required />
                </div>
                <div class="form-group">
                    <x-forms.select value="{{ old('payment_option') }}" name="payment_option" label="Payment Option" placeholder="Select Payment Schedule" :options="['Full' => 'Pay in full', 'Installment' => 'Pay in Installment']" />
                </div>

                <hr>

                <div class="tw-flex tw-justify-end">
                    <div class="py-4 ">
                      <h1 class="h5">Computed Price</h1>
                      <p class="h4 mb-0 text-primary tw-font-bold" id="computed_price">Php 0.00</p>
                    </div>
                  </div>
                <button type="submit" class="btn btn-primary tw-block ml-auto mr-0">Book</button>
            </form>
        </div>
    </div>

    <script>
        $(function() {
            const $bookD2DForm = $("#bookD2DForm");
            const $additional_rate = $bookD2DForm.find("#additional_rate_id");

            // Triggering on change event when d2d_schedule_id changes
            $bookD2DForm.find("#d2d_schedule_id").on("change", function(e) {
                // Get selected d2d_schedule_id
                const scheduleId = e.target.value;

                // Ensure the additional_rates are passed correctly as JSON from PHP
                const additionalRates = {!! json_encode($additional_rates->toArray()) !!};

                // Filter the additional rates based on the selected schedule ID (route_id)
                const filteredRates = additionalRates.filter(rate => rate.route_id == scheduleId);

                // Clear the existing options in the additional rate dropdown
                $additional_rate.html("");

                // Add the default option
                $additional_rate.append("<option value=''> (Optional) Select Additional Option</option>");

                // Append filtered additional rates as options
                filteredRates.forEach(function(rate) {
                    $additional_rate.append(
                        `<option value="${rate.id}" data-rate="${rate.rate}">${rate.name} - PHP ${rate.rate}</option>`
                    );
                });

                // If no additional rates are available, display a message or leave empty
                if (filteredRates.length === 0) {
                    $additional_rate.append("<option value=''>No options available</option>");
                }

                computePrice();  // Recompute the price whenever schedule is changed
            }).change(); // Trigger on initial load if there's a pre-selected schedule

            // Triggering the price computation whenever the additional rate is changed
            $additional_rate.on("change", function() {
                computePrice();  // Recompute price
            });

            // Price computation logic
            function computePrice() {
                const selectedScheduleRate = parseFloat($bookD2DForm.find("#d2d_schedule_id option:selected").data('rate')) || 0; // Fetch the route rate
                const selectedAdditionalRate = parseFloat($bookD2DForm.find("#additional_rate_id option:selected").data('rate')) || 0; // Fetch the additional rate

                // Compute the total price
                const computedPrice = selectedScheduleRate + selectedAdditionalRate;

                // Update the computed price in the HTML
                $bookD2DForm.find("#computed_price").html(`PHP ${computedPrice.toFixed(2)}`);
            }
        });

    </script>
</x-master>