@extends('main.layouts.master')

@section('content')
<x-alerts></x-alerts>
<div class="container-fluid">
  <div class="d-flex justify-content-between mb-4">
    <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
  </div>
  <h1 class="h4">Rent Vehicle</h1>

  <div class="card my-4">
    <div class="card-body">
      <form action="{{ route('client.vehicles.rentStore') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <x-forms.input name="booking_type" value="Vehicle" type="hidden" />
          <x-forms.input name="vehicle_id" value="{{$vehicle->id}}" type="hidden" />
          <div class="card mb-4">
            <div class="card-header">
              Vehicle Details
            </div>
            <div class="card-body">
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
  
          <div class="row ">
            <div class="col-sm mb-3">
              <x-forms.input name="name" label="Name" placeholder="Enter name" required />
            </div>
            <div class="col-sm mb-3">
              <x-forms.input name="contact_number" label="Contact Number" placeholder="Enter contact number" required />
            </div>
          </div>

          <div class="row  align-items-center">
            <div class="col-sm mb-3">
              <x-forms.input name="start_date" label="Start Date" type="datetime-local" required /> 
            </div>
            <div class="col-sm mb-3">
              <x-forms.input name="number_of_days" label="How many days?" placeholder="Enter number of days" type="number" required></x-forms.input>
            </div>
          </div>

          <div class="form-group">
            @if($vehicle->rent_options == "Both")
              <x-forms.select name="rent_options" label="Rent Options" placeholder="Please Select Rent Options" :options="['With Driver' => 'With Driver', 'Without Driver' => 'Without Driver']" value="{{ old('rent_options') }}"  required></x-forms.select>
            @elseif($vehicle->rent_options == "With Driver")
              <x-forms.select name="rent_options" label="Rent Options" placeholder="Please Select Rent Options" :options="['With Driver' => 'With Driver']" value="{{ old('rent_options') }}"  required></x-forms.select>
            @else
              <x-forms.select name="rent_options" label="Rent Options" placeholder="Please Select Rent Options" :options="['Without Driver' => 'Without Driver']" value="{{ old('rent_options') }}"  required></x-forms.select>
            @endif
          </div>

          
          <div id="driver_details">
            <hr>
            <div class="form-group">
              <x-forms.input name="license_no" label="Driver's License Number" placeholder="Enter driver's license number" />
            </div>
            <div class="form-group">
              <x-forms.input name="valid_until" label="Valid Until" type="date" placeholder="Enter driver's license valid until date" />
            </div>
            <div class="form-group">
              <x-forms.input name="front_id" type="file" accept=".jpg, .jpeg, .png" label="Driver License Front Picture" />
            </div>
            <div class="form-group">
              <x-forms.input name="back_id" type="file" accept=".jpg, .jpeg, .png" label="Driver License Back Picture" />
            </div>
            <hr>
          </div>


          <div class="form-group">
            <x-forms.select value="{{ old('payment_option') }}" name="payment_option" label="Payment Option" placeholder="Select Payment Schedule" :options="['Full' => 'Pay in full', 'Installment' => 'Pay in Installment']" />
          </div>

          <div class="form-group">
            <label for="additional_rate">Additional Rate</label>
            <select name="additional_rate" class="form-control" id="additional_rate">
              <option value="">No Additional Rate</option>
              @foreach ($additional_rates as $additionalRate)
                <option {{ old('additional_rate') == $additionalRate->id ? 'selected' : ''}} value="{{$additionalRate->id}}">{{$additionalRate->name}} (Php {{$additionalRate->rate}})</option>
              @endforeach
            </select>
            @error('additional_rate')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>

          <hr>

          
          <div class="form-group">
            <x-forms.input name="pickup_location" label="Pickup Location or Landmark" placeholder="Enter pickup location"  />
          </div>

          <div id="rent_out_options">
            <h5>Rent Out/Release Option</h5>
            <div class="row">
              <div class="col-sm mb-3">
                <x-forms.input name="rent_out_time" label="Rent Out Time/Date" type="datetime-local" placeholder="Enter rent out datetime" />
              </div>
              <div class="col-sm mb-3">
                <x-forms.input name="return_in_time" label="Return In Time/Date" type="datetime-local" placeholder="Enter return in datetime" />
              </div>
            </div>
            <div class="form-group">
              <x-forms.input name="rent_out_location" label="Location" type="text" placeholder="Enter Location" />
            </div>
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
</div>

<x-vehicle-bookings-modal />



<script>
  $(document).ready(function() {
    $numberOfDays = $('#number_of_days');
    $rentOptions = $('#rent_options');
    $computedPrice = $('#computed_price');
    $additionalRate = $('#additional_rate');

    $numberOfDays.on('input', function(e) {
      computePrice();
    });
    $rentOptions.on('change', function(e) {
      computePrice();
      console.log(e.target.value);
      if (e.target.value === "Without Driver") {
        $('#driver_details').show();
        $('#pickup_location').closest('.form-group').hide();
        $('#rent_out_options').show();
      }
      else {
        $('#driver_details').hide();
        $('#pickup_location').closest('.form-group').show();
        $('#rent_out_options').hide();
      }
    });
    $rentOptions.change();
    $additionalRate.on('change', function(e) {
      computePrice();
    });

    computePrice();

    function computePrice() {
        // Fetch rates dynamically
        const additionalRates = @json($additional_rates->pluck('rate', 'id'));

        const addRate = parseInt(additionalRates[$additionalRate.val()] ?? 0); // Fetch additional rate dynamically
        const numberOfDays = parseInt($numberOfDays.val() || 0); // Handle empty value
        
        let rate = 0;
        if ($rentOptions.val() === "With Driver") {
            rate = parseInt("{{$vehicle->rate_w_driver}}");
        } else {
            rate = parseInt("{{$vehicle->rate}}");
        }

        const computedPrice = (numberOfDays * rate) + addRate;
        $computedPrice.text(`Php ${computedPrice.toLocaleString()}`); // Add locale formatting
    }

    @if($errors->any())
        console.log("Has Errors");
        $rentOptions.change();
    @endif

  });
</script>
@endsection