<x-master>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
    </div>

    <h4 class="h4">Extend Booking</h4>

    <div class="card my-4">
        <div class="card-body">
            <form action="{{ route('client.bookings.extend', $booking->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-forms.input name="booking_type" value="Vehicle" type="hidden" />
                <x-forms.input name="vehicle_id" value="{{$vehicle->id}}" type="hidden" />
                <div class="card mb-4">
                    <div class="card-header">
                        Vehicle Details
                    </div>
                    <div class="card-body small">
                        <dl class="row">
                        <dt class="col-sm-3">Brand :</dt><dd class="col-sm-9">{{$vehicle->brand}}</dd>
                        <dt class="col-sm-3">Model :</dt><dd class="col-sm-9">{{$vehicle->model}}</dd>
                        <dt class="col-sm-3">Category :</dt><dd class="col-sm-9">{{$vehicle->vehicleCategory->category_name}}</dd>
                        <dt class="col-sm-3">Owner :</dt><dd class="col-sm-9">{{$vehicle->user->organisation->org_name}}</dd>
                        <dt class="col-sm-3">Rate :</dt><dd class="col-sm-9">PHP {{$vehicle->rate}}</dd>
                        <dt class="col-sm-3">Rate w/ driver :</dt><dd class="col-sm-9">PHP {{$vehicle->rent_options == "Without Driver" ? "N/A" : $vehicle->rate_w_driver}}</dd>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="showVehicleSchedule({{ $vehicle->id }})">Show Schedule</button>
                        </dl>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        Booking Details
                    </div>
                    <div class="card-body small">
                        <dl class="row">
                            <dt class="col-sm-3">Transaction # :</dt><dd class="col-sm-9">{{ $booking->transaction_number }}</dd>
                            <dt class="col-sm-3">Created By :</dt><dd class="col-sm-9">{{ $booking->user->name }}</dd>
                            <dt class="col-sm-3">Created At :</dt><dd class="col-sm-9">{{ $booking->created_at->diffForHumans() }}</dd>
                            <dt class="col-sm-3">Client Name :</dt><dd class="col-sm-9">{{ $booking->name }}</dd>
                            <dt class="col-sm-3">Client Contact # :</dt><dd class="col-sm-9">{{ $booking->contact_number }}</dd>
                            <dt class="col-sm-3">Start Date :</dt><dd class="col-sm-9">{{ $booking->bookingDetail->start_datetime->format('F j, Y, g:i A') }} </dd>
                            <dt class="col-sm-3"></dt>
                            <dd class="col-sm-9">({{ $booking->bookingDetail->start_datetime->diffForHumans() }})</dd>
                            <dt class="col-sm-3">Computed Price :</dt><dd class="col-sm-9">PHP {{ number_format($booking->computed_price, 2) }}</dd>
                            <dt class="col-sm-3">Status :</dt><dd class="col-sm-9">{{ $booking->status }}</dd>
                        </dl>
                    </div>
                </div>
    
                <div class="form-group">
                    <x-forms.input type="number" min="1" name="extend_days" label="How many days?" placeholder="Enter the number of days" required />
                </div>

                <hr>

                <div class="tw-flex tw-justify-end">
                <div class="py-4 ">
                    <h1 class="h5">Computed Additional Price</h1>
                    <p class="h4 mb-0 text-primary tw-font-bold" id="computed_price">Php 0.00</p>
                </div>
                </div>
                <button type="submit" class="btn btn-primary tw-block ml-auto mr-0">Extend</button>
            </form>
        </div>
    </div>

    <x-vehicle-bookings-modal />

    <script>
        $(document).ready(function() {
          $extendDays = $('#extend_days');
          $computedPrice = $('#computed_price');
      
          $extendDays.on('input', function(e) {
            computePrice();
          });
      
          computePrice();
      
          function computePrice() {
              // Fetch rates dynamically
      
              const numberOfDays = parseInt($extendDays.val() || 0); // Handle empty value
              
              let rate = 0;
              if ({{ $booking->bookingDetail->with_driver }} === 1) {
                  rate = parseInt("{{$vehicle->rate_w_driver}}");
              } else {
                  rate = parseInt("{{$vehicle->rate}}");
              }
      
              const computedPrice = (numberOfDays * rate);
              $computedPrice.text(`Php ${computedPrice.toLocaleString()}`); // Add locale formatting
          }
      
          @if($errors->any())
              console.log("Has Errors");
              $extendDays.change();
          @endif
      
        });
      </script>

</x-master>