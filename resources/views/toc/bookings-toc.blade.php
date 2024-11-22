<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script src="https://kit.fontawesome.com/2a90b2a25f.js" crossorigin="anonymous"></script>

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ mix('assets/css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ mix('assets/css/sb-admin-2.min.css') }}" rel="stylesheet"> --}}
    
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- full calendar --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>


    <title>iRENTA HUB</title>
</head>

<body id="page-top" class="tw-bg-gray-100">

    <div class="tw-flex tw-justify-center tw-my-5">
        <x-brand-dark />
    </div>

    <h1 class="h4 text-center mb-3 text-dark tw-font-bold">Terms and Conditions</h1>

    <div class="tw-container tw-mx-auto tw-max-w-4xl tw-px-6 tw-py-16 bg-white">
        <div class="tw-w-full">
            <ul class="tw-list-disc tw-list-inside tw-space-y-2">
                <li>
                    If a customer cancels three times of his/her bookings, the organization reserves the
                    right to ban them from using our services.
                </li>
                <li>
                    If a customer cancels their booking after preparation of the vehicle and within one hour
                    of the pickup time, <span class="tw-font-bold">5% of the down payment</span> will be forfeited to the company.
                </li>
                <li>
                    If a customer books a vehicle with a driver and fails to show up at the agreed-upon
                    location, the driver will only wait for <span class="tw-font-bold">30 minutes</span>.
                </li>
                <li>
                    If the customer fails to respond to the driver's call or show up after 30 minutes, the
                    booking will be automatically canceled, and <span class="tw-font-bold">5% of the down payment</span> will be forfeited to the company.
                </li>
                <li>
                    If a customer returns a rented vehicle with damage caused by their fault, they are liable
                    to pay for the damages, depending on the extent of the damage.
                </li>
                <li>
                    Vehicles must be returned on the agreed-upon date and time.
                </li>
                <li>
                    Failure to return the vehicle without prior notice or permission may result in
                    <span class="tw-font-bold">legal consequences</span>.
                </li>
                <li>
                    Vehicles are rented with a <span class="tw-font-bold">full tank of gasoline</span>.
                </li>
                <li>
                    Customers are expected to return the vehicle with the same amount of fuel.
                </li>
                <li>
                    Customers are responsible for any <span class="tw-font-bold">traffic violations or fines</span> incurred during the rental period.
                </li>
                <li>
                    Vehicles are subject to availability and may be substituted with similar models.
                </li>
            </ul>
        </div>
    </div>
    
    

    <!-- Bootstrap core JavaScript-->
    {{-- <script src="{{ asset('sb-admin-vendor/jquery/jquery.min.js')}}"></script> --}}
    <script src="{{ asset('sb-admin-vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sb-admin-vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>

</body>
</html>