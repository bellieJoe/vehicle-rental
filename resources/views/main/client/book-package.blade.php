@extends('main.layouts.master')

@section('content')
<x-alerts></x-alerts>
<div class="container-fluid">
  <div class="d-flex justify-content-between mb-4">
    <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-chevron-left mr-2"></i>Back</a>
  </div>
  <h1 class="h4">Book Package</h1>

  <div class="card my-4">
    <div class="card-body">
      <form action="{{ route('client.vehicles.bookStore') }}" method="POST">
          @csrf
          <x-forms.input name="booking_type" value="Package" type="hidden" />
          <x-forms.input name="package_id" value="{{$package->id}}" type="hidden" />
          <div class="card mb-4">
            <div class="card-header">
              Package Details
            </div>
            <div class="card-body">
              <dl class="row">
                <dt class="col-sm-3">Package :</dt><dd class="col-sm-9">{{$package->package_name}}</dd>
                <dt class="col-sm-3">Minimum Pax :</dt><dd class="col-sm-9">{{$package->minimum_pax}}</dd>
                <dt class="col-sm-3">Price per Pax :</dt><dd class="col-sm-9">PHP {{number_format($package->price_per_person, 2)}}</dd>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="showPackageSchedule({{ $package->id }})">Show Schedule</button>
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

          <div class="form-group">
            <x-forms.input name="start_date" label="Start Date" type="date" required /> 
          </div>

          <div class="form-group">
            <x-forms.input name="number_of_person" min="0" label="How many person?" type="number" min="{{$package->minimum_pax}}" required /> 
          </div>

          <div class="form-group">
            <x-forms.input name="pickup_location" label="Pickup Location" placeholder="Enter pickup location"  />
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
</div>

<x-package-bookings-modal />



<script>
  $(document).ready(function() {
    $('#number_of_person').on('input', function() {
      let number_of_person = $(this).val();
      let price_per_person = {{ $package->price_per_person }};
      let computed_price = number_of_person * price_per_person;
      $('#computed_price').text('Php ' + computed_price.toFixed(2));
    });
  });
</script>
@endsection