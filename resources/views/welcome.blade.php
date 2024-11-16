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

        <!-- Custom styles for this template -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
        <!-- responsive style -->
        <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" />

        <title>Veihicle Rental</title>
 
    </head>
    <body >
    <div class="hero_area">
        
        @include('landing.header')

        <!-- slider section -->
        <section class="slider_section ">
        <div class="slider_bg_box">
            <img src="{{ asset('assets/images/vehicle.jpg') }}" alt="">
        </div>
        <div id="customCarousel1" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container ">
                    <div class="row">
                        <div class="col-md-7 ">
                        <div class="detail-box">
                            <h1>
                            Experience the Best Way to Explore 
                            <!-- <br> -->
                            Marinduque with iRENTA HUB
                            </h1>
                            <p>
                            iRENTA HUB offers a wide range of vehicles for rent, with experienced and professional drivers who know Marinduque's roads. We also provide airport transfers, city tours, and outdoor activities to make your trip more enjoyable.
                            </p>
                            <div class="btn-box">
                            <a href="" class="btn1">
                                Book Now
                            </a>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        </section>
        <!-- end slider section -->
    </div>

    <!-- service section -->
    <section class="service_section layout_padding">
        <div class="service_container">
        <div class="container ">
            <div class="heading_container">
            <h2>
                Our <span>Services</span>
            </h2>
            <p>
                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration
            </p>
            </div>
            <div class="row">
            <div class="col-md-6 ">
                <div class="box ">
                <div class="img-box">
                    <img src="{{asset('assets/images/s1.png')}}" alt="">
                </div>
                <div class="detail-box">
                    <h5>
                    Air Transport
                    </h5>
                    <p>
                    fact that a reader will be distracted by the readable content of a page when looking at its layout.
                    The
                    point of using
                    </p>
                    <a href="">
                    Read More
                    </a>
                </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="box ">
                <div class="img-box">
                    <img src="{{asset('assets/images/s2.png')}}" alt="">
                </div>
                <div class="detail-box">
                    <h5>
                    Cargo Transport
                    </h5>
                    <p>
                    fact that a reader will be distracted by the readable content of a page when looking at its layout.
                    The
                    point of using
                    </p>
                    <a href="">
                    Read More
                    </a>
                </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="box ">
                <div class="img-box">
                    <img src="{{asset('assets/images/s3.png')}}" alt="">
                </div>
                <div class="detail-box">
                    <h5>
                    Trucks Transport
                    </h5>
                    <p>
                    fact that a reader will be distracted by the readable content of a page when looking at its layout.
                    The
                    point of using
                    </p>
                    <a href="">
                    Read More
                    </a>
                </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="box ">
                <div class="img-box">
                    <img src="{{asset('assets/images/s4.png')}}" alt="">
                </div>
                <div class="detail-box">
                    <h5>
                    Train Transport
                    </h5>
                    <p>
                    fact that a reader will be distracted by the readable content of a page when looking at its layout.
                    The
                    point of using
                    </p>
                    <a href="">
                    Read More
                    </a>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>

    <!-- end service section -->


    <!-- about section -->

    <section class="about_section layout_padding-bottom">
        <div class="container  ">
        <div class="row">
            <div class="col-md-6">
            <div class="detail-box">
                <div class="heading_container">
                <h2>
                    About <span>Us</span>
                </h2>
                </div>
                <p>
                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration
                in some form, by injected humour, or randomised words which don't look even slightly believable. If you
                are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in
                the middle of text. All
                </p>
                <a href="">
                Read More
                </a>
            </div>
            </div>
            <div class="col-md-6 ">
            <div class="img-box">
                <img src="{{asset('assets/images/about-img.png')}}" alt="">
            </div>
            </div>

        </div>
        </div>
    </section>

    <!-- end about section -->

    <!-- track section -->

    <section class="track_section layout_padding">
        <div class="track_bg_box">
        <img src="{{asset('assets/images/track-bg.jpg')}}" alt="">
        </div>
        <div class="container">
        <div class="row">
            <div class="col-md-6">
            <div class="heading_container">
                <h2>
                Track Your Shipment
                </h2>
            </div>
            <p>
                Iste reprehenderit maiores facilis saepe cumque molestias. Labore iusto excepturi, laborum aliquid pariatur veritatis autem, mollitia sint nesciunt hic error porro.
                Deserunt officia unde repellat beatae ipsum sed. Aperiam tempora consectetur voluptas magnam maxime asperiores quas similique repudiandae, veritatis reiciendis harum fuga atque.
            </p>
            <form action="">
                <input type="text" placeholder="Enter Your Tracking Number" />
                <button type="submit">
                Track
                </button>
            </form>
            </div>
        </div>
        </div>
    </section>

    <!-- end track section -->

    <!-- client section -->

    <section class="client_section layout_padding">
        <div class="container">
        <div class="heading_container">
            <h2>
            What Says Our <span>Client</span>
            </h2>
        </div>
        <div class="client_container">
            <div class="carousel-wrap ">
            <div class="owl-carousel">
                <div class="item">
                <div class="box">
                    <div class="detail-box">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                    </p>
                    </div>
                    <div class="client_id">
                    <div class="img-box">
                        <img src="{{asset('assets/images/client-1.png')}}" alt="" class="img-1">
                    </div>
                    <div class="name">
                        <h6>
                        Adipiscing
                        </h6>
                        <p>
                        Magna
                        </p>
                    </div>
                    </div>
                </div>
                </div>
                <div class="item">
                <div class="box">
                    <div class="detail-box">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                    </p>
                    </div>
                    <div class="client_id">
                    <div class="img-box">
                        <img src="{{asset('assets/images/client-2.png')}}" alt="" class="img-1">
                    </div>
                    <div class="name">
                        <h6>
                        Adipiscing
                        </h6>
                        <p>
                        Magna
                        </p>
                    </div>
                    </div>
                </div>
                </div>
                <div class="item">
                <div class="box">
                    <div class="detail-box">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                    </p>
                    </div>
                    <div class="client_id">
                    <div class="img-box">
                        <img src="{{asset('assets/images/client-1.png')}}" alt="" class="img-1">
                    </div>
                    <div class="name">
                        <h6>
                        Adipiscing
                        </h6>
                        <p>
                        Magna
                        </p>
                    </div>
                    </div>
                </div>
                </div>
                <div class="item">
                <div class="box">
                    <div class="detail-box">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                    </p>
                    </div>
                    <div class="client_id">
                    <div class="img-box">
                        <img src="{{asset('assets/images/client-2.png')}}" alt="" class="img-1">
                    </div>
                    <div class="name">
                        <h6>
                        Adipiscing
                        </h6>
                        <p>
                        Magna
                        </p>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>

    <!-- end client section -->

    <!-- contact section -->
    <section class="contact_section">
        <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-5 offset-md-1">
            <div class="heading_container">
                <h2>
                Contact Us
                </h2>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-5 offset-md-1">
            <div class="form_container contact-form">
                <form action="">
                <div>
                    <input type="text" placeholder="Your Name" />
                </div>
                <div>
                    <input type="text" placeholder="Phone Number" />
                </div>
                <div>
                    <input type="email" placeholder="Email" />
                </div>
                <div>
                    <input type="text" class="message-box" placeholder="Message" />
                </div>
                <div class="btn_box">
                    <button>
                    SEND
                    </button>
                </div>
                </form>
            </div>
            </div>
            <div class="col-lg-7 col-md-6 px-0">
            <div class="map_container">
                <div class="map">
                <div >
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d248420.9647039206!2d121.9490304886287!3d13.376522378746706!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sph!4v1731753995308!5m2!1sen!2sph" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
    <!-- end contact section -->

    <!-- info section -->

    <section class="info_section layout_padding2">
        <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-3 info_col">
            <div class="info_contact">
                <h4>
                Address
                </h4>
                <div class="contact_link_box">
                <a href="">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <span>
                    Location
                    </span>
                </a>
                <a href="">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    <span>
                    Call +01 1234567890
                    </span>
                </a>
                <a href="">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    <span>
                    demo@gmail.com
                    </span>
                </a>
                </div>
            </div>
            <div class="info_social">
                <a href="">
                <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
                <a href="">
                <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
                <a href="">
                <i class="fa fa-linkedin" aria-hidden="true"></i>
                </a>
                <a href="">
                <i class="fa fa-instagram" aria-hidden="true"></i>
                </a>
            </div>
            </div>
            <div class="col-md-6 col-lg-3 info_col">
            <div class="info_detail">
                <h4>
                Info
                </h4>
                <p>
                necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful
                </p>
            </div>
            </div>
            <div class="col-md-6 col-lg-2 mx-auto info_col">
            <div class="info_link_box">
                <h4>
                Links
                </h4>
                <div class="info_links">
                <a class="active" href="index.html">
                    <img src="{{asset('assets/images/nav-bullet.png')}}" alt="">
                    Home
                </a>
                <a class="" href="about.html">
                    <img src="{{asset('assets/images/nav-bullet.png')}}" alt="">
                    About
                </a>
                <a class="" href="service.html">
                    <img src="{{asset('assets/images/nav-bullet.png')}}" alt="">
                    Services
                </a>
                <a class="" href="contact.html">
                    <img src="{{asset('assets/images/nav-bullet.png')}}" alt="">
                    Contact Us
                </a>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
t
    <!-- end info section -->

    <!-- footer section -->
    <section class="footer_section">
        <div class="container">
        <p>
            &copy; <span id="displayYear"></span> All Rights Reserved By
            <a href="https://html.design/">Free Html Templates</a>
        </p>
        </div>
    </section>
    <!-- footer section -->

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
    </body>
</html>
