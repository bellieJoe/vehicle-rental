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
      <form action="{{ route('client.vehicles.rentStore') }}" method="POST">
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
                <dt class="col-sm-3">Plate Number :</dt><dd class="col-sm-9">{{$vehicle->plate_number}}</dd>
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
              <x-forms.select name="rent_options" label="Rent Options" placeholder="Please Select Rent Options" :options="['With Driver' => 'With Driver', 'Without Driver' => 'Without Driver']"  required></x-forms.select>
            @elseif($vehicle->rent_options == "With Driver")
              <x-forms.select name="rent_options" label="Rent Options" placeholder="Please Select Rent Options" :options="['With Driver' => 'With Driver']"  required></x-forms.select>
            @else
              <x-forms.select name="rent_options" label="Rent Options" placeholder="Please Select Rent Options" :options="['Without Driver' => 'Without Driver']"  required></x-forms.select>
            @endif
          </div>

          <div class="form-group">
            <x-forms.input name="pickup_location" label="Pickup Location" placeholder="Enter pickup location"  />
          </div>

          {{-- <div class="form-group">
            <x-forms.select name="payment_method" label="Payment Method" placeholder="Please Payment Method" :options="['Cash' => 'Cash', 'Gcash' => 'Gcash', 'Debit' => 'Debit Card']"  required />
          </div> --}}

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
</div>

<x-vehicle-bookings-modal />



<script>
  $(document).ready(function() {
    $numberOfDays = $('#number_of_days');
    $rentOptions = $('#rent_options');
    $computedPrice = $('#computed_price');

    $numberOfDays.on('input', function(e) {
      if(["With Driver"].includes($rentOptions.val())) {
        const rate = parseInt("{{$vehicle->rate_w_driver}}");
        $computedPrice.text(`Php ${$numberOfDays.val() * rate}`);
      }
      else {
        const rate = {{$vehicle->rate}};
        $computedPrice.text(`Php ${$numberOfDays.val() * rate}`);
      }
    });
    $rentOptions.on('change', function(e) {
      if(["With Driver"].includes($rentOptions.val())) {
        const rate = parseInt("{{$vehicle->rate_w_driver}}");
        $computedPrice.text(`Php ${$numberOfDays.val() * rate}`);
        $('input[name="pickup_location"]').closest('.form-group').show();
      }
      else {
        const rate = {{$vehicle->rate}};
        $computedPrice.text(`Php ${$numberOfDays.val() * rate}`);
        $('input[name="pickup_location"]').closest('.form-group').hide();
      }
    });
  });
</script>
@endsection