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

<body class="tw-bg-gray-100" id="page-top"> 

    <div class="tw-flex tw-justify-center tw-my-5">
        <x-brand-dark />
    </div>

    <h1 class="h4 text-center mb-3 text-dark tw-font-bold">Terms and Conditions</h1>

    <div class="tw-bg-gray-50 tw-p-6 tw-rounded-lg tw-shadow-md tw-text-gray-800 tw-max-w-2xl tw-mx-auto">
        <p class="tw-text-base tw-leading-6 tw-mb-4">
            By registering with <span class="tw-font-bold tw-text-blue-600">i-RENTA HUB</span>, you acknowledge acceptance of our <span class="tw-font-bold">Terms and Conditions</span>. 
            You must be at least <span class="tw-font-bold">18 years old</span> and provide accurate registration information. 
        </p>
        <ul class="tw-list-disc tw-list-inside tw-space-y-2">
            <li>You are responsible for maintaining password confidentiality.</li>
            <li>Fuel costs and returning rented vehicles in good condition are your responsibility.</li>
            <li>
                A down payment is required to secure bookings, payable via 
                <span class="tw-font-bold tw-text-green-600">GCash</span> or 
                <span class="tw-font-bold tw-text-green-600">bank transfer</span>.
            </li>
            <li>You assume liability for damages, accidents, and fines.</li>
        </ul>
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