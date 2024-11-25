<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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

        <!-- fonts style -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

        <!--owl slider stylesheet -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

        <!-- font awesome style -->
        <script src="https://kit.fontawesome.com/2a90b2a25f.js" crossorigin="anonymous"></script>
        
        <!-- Custom styles for this template-->
        <link href="{{ mix('assets/css/tailwind.css') }}" rel="stylesheet"> 

        <!-- Custom styles for this template -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

        <!-- responsive style -->
        <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" />
        

        <title>Veihicle Rental</title>
 
    </head>
    <body >

        {{$slot}}


        <!-- jQery -->
        <script type="text/javascript" src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>
        <!-- popper js -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
        <!-- bootstrap js -->
        <script type="text/javascript" src="{{asset('assets/js/bootstrap.js')}}"></script>
        <!-- owl slider -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
        </script>
        <!-- custom js -->
        <script type="text/javascript" src="{{asset('assets/js/custom.js')}}"></script>
        <!-- Google Map -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
        </script>
        <!-- End Google Map -->

        <!-- Bootstrap core JavaScript-->
        {{-- <script src="{{ asset('sb-admin-vendor/jquery/jquery.min.js')}}"></script> --}}
        <script src="{{ asset('sb-admin-vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    </body>
</html>
