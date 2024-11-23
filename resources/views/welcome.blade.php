<x-landing.master>

    <div class="hero_area">

        <!-- slider section -->
        <section class="slider_section ">
        <div class="slider_bg_box">
            <img src="{{ asset('assets/images/hero.jpg') }}" alt="">
        </div>
        {{-- <div id="customCarousel1" class="carousel slide" data-ride="carousel">
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
                            <a href="{{ route('client.vehicles')}}" class="btn1">
                                Book Now
                            </a>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div> --}}

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
            <div class="row ">
                <div class="col-md-6 d-flex align-items-stretch mb-4">
                    <div class="box h-100">
                        <div class="img-box">
                            <i class="fa-solid fa-car" style="font-size: 64px; color: #4e73df;"></i>
                        </div>
                        <div class="detail-box">
                            <h5>
                                Wide Range of Vehicles & Tour Packages
                            </h5>
                            <p>
                                We offer a range of vehicles and tour packages from trusted partners. From short trips to long-term rentals and guided tours, we've got you covered. Our vehicles are regularly maintained for your safety and comfort.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-stretch mb-4">
                    <div class="box h-100">
                        <div class="img-box">
                            <i class="fa-solid fa-laptop" style="font-size: 64px; color: #4e73df;"></i>
                        </div>
                        <div class="detail-box">
                            <h5>
                                User-Friendly Booking
                            </h5>
                            <p>
                                Book easily and conveniently on our platform. Browse and select vehicles or tours from our partners, and experience hassle-free bookings.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-stretch mb-4">
                    <div class="box h-100">
                        <div class="img-box">
                            <i class="fa-solid fa-calendar-days" style="font-size: 64px; color: #4e73df;"></i>
                        </div>
                        <div class="detail-box">
                            <h5>
                                Flexible Rental Plans
                            </h5>
                            <p>
                                We offer customizable rental plans from our partners, that fit your schedule and budget. Choose daily, weekly, or monthly plans and adjust based on your travel needs. Enjoy full control over your rental experience.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end service section -->


    <!-- about section -->

    <section class="about_section layout_padding-bottom">
        <div class="container  py-5">
        <div class="row">
            <div class="col-md-6">
            <div class="detail-box py-5">
                <div class="heading_container">
                <h2>
                    About <span>Us</span>
                </h2>
                </div>
                <p>
                iRENTA HUB is a car rental and tour platform that provides a convenient and hassle-free experience for
                travelers visiting Marinduque. We offer a wide range of vehicles and tour packages from trusted partners.
                Our vehicles are regularly maintained for your safety and comfort. We also provide airport transfers and
                city tours to make your trip more enjoyable. With iRENTA HUB, you can easily book and customize your rental
                experience to fit your schedule and budget.
                </p>
                {{-- <a href="">
                Read More
                </a> --}}
            </div>
            </div>
            <div class="col-md-6 ">
                <div class="">
                    <img class="img-fluid rounded-circle" src="{{asset('assets/images/irenta_hub_logo.png')}}" alt="">
                    {{-- <img src="{{asset('assets/images/about-img.png')}}" alt=""> --}}
                </div>
            </div>

        </div>
        </div>
    </section>

    <!-- end about section -->


    <!-- client section -->

    {{-- <section class="client_section layout_padding">
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
    </section> --}}

    <!-- end client section -->

    <x-landing.contact-us />

    
</x-landing.master>