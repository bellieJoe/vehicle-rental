<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Site Metas -->
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="shortcut icon" href="images/fevicon.png" type="">

        <title> iRENTA HUB </title>

        
        <!-- bootstrap core css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css')}}" />
        
         {{-- JQuery --}}
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

        <!-- font awesome style -->
        <script src="https://kit.fontawesome.com/2a90b2a25f.js" crossorigin="anonymous"></script>
        
        <link href="{{ mix('assets/css/app.css') }}" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="{{ mix('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

        <link href="{{ mix('assets/css/app.css') }}" rel="stylesheet">


        <title>iRENTA HUB</title>
 
    </head>
<body class="bg-gradient-primary">
    <div class="container">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Bootstrap core JavaScript-->
    {{-- <script src="{{ asset('sb-admin-vendor/jquery/jquery.min.js')}}"></script> --}}
    <script src="{{ asset('sb-admin-vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sb-admin-vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
</body>
</html>