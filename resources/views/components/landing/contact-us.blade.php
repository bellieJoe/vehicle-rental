<!-- contact section -->
<section class="contact_section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-5 offset-md-1">
            <div class="heading_container">
                <h2>
                    Explore Marinduque <br> with Us
                </h2>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-5 offset-md-1">
            <div class="form_container contact-form">
                <form action="{{ route('inquiry.store') }}" method="POST">
                    @csrf
                    <div>
                        <input name="name" type="text" placeholder="Your Name" />
                        @error('name', 'inquiry_create')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <input name="email" type="email" placeholder="Email" />
                        @error('email', 'inquiry_create')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <input name="message" type="text" class="message-box" placeholder="Message" />
                        @error('message', 'inquiry_create')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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
</section>
<!-- end contact section -->