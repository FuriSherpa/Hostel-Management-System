<?php
include("mainInclude/header.php");
?>

<header class="bg-dark py-5">
    <div class="container px-5">
        <div class="row gx-5 align-items-center justify-content-center">
            <div class="col-lg-8 col-xl-7 col-xxl-6">
                <div class="my-5 text-center text-xl-start">
                    <h1 class="display-5 fw-bolder text-white mb-2">Welcome to HostelStays</h1>
                    <p class="lead fw-normal text-white-50 mb-4">Relax, Explore & Connect</p>
                    <p class="lead fw-normal text-white-50 mb-4">With HostelStays, you can effortlessly manage reservations, track guest check-ins and check-outs, handle billing and payments, and much more – all from one intuitive platform. Our user-friendly interface and powerful features make it easy for you to focus on providing exceptional hospitality while we take care of the rest.</p>
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                        <a class="btn btn-primary btn-lg px-4 me-sm-3" href="#facilities">Get Started</a>
                        <a class="btn btn-outline-light btn-lg px-4" href="about.php">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center">
                <!-- Video -->
                <video controls autoplay loop muted class="img-fluid rounded-3 my-5">
                    <source src="video/learning.mp4" type="video/mp4">
                </video>
            </div>
        </div>
    </div>
</header>


<!-- Facilities section-->
<section class="py-5" id="facilities">
    <div class="container px-5 my-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-10">
                <h2 class="fw-bolder mb-5 text-center">Our Facilities</h2>
                <div class="row gx-5 row-cols-1 row-cols-md-2">
                    <div class="col mb-5 h-100">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 d-flex align-items-center justify-content-center mb-3"><i class="bi bi-shield-fill-check"></i></div>
                        <h2 class="h5 text-center">24/7 Security</h2>
                        <p class="mb-0 text-center">Ensure the safety and security of guests and their belongings through measures such as surveillance cameras, secure lockers, and security guards.</p>
                    </div>
                    <div class="col mb-5 mb-md-0 h-100">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 d-flex align-items-center justify-content-center mb-3"><i class="bi bi-building"></i></div>
                        <h2 class="h5 text-center">Friendly Environment</h2>
                        <p class="mb-0 text-center">Offer more than just a place to rest. Here, you can find a home away from home, where memories are made and friendships flourish.</p>
                    </div>
                    <div class="col mb-5 mb-md-0 h-100">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 d-flex align-items-center justify-content-center mb-3"><i class="bi bi-wifi"></i></div>
                        <h2 class="h5 text-center">High-Speed Internet</h2>
                        <p class="mb-0 text-center">Provide complimentary Wi-Fi access throughout the hostel premises, allowing guests to stay connected and access information online.</p>
                    </div>
                    <div class="col h-100">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 d-flex align-items-center justify-content-center mb-3"><i class="bi bi-bag-fill"></i></div>
                        <h2 class="h5 text-center">Laundry</h2>
                        <p class="mb-0 text-center">Provide self-service or on-site laundry facilities where guests can wash and dry their clothes during their stay.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Testimonial section-->
<div class="py-5 bg-light">
    <div class="container px-5 my-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-10 col-xl-7">
                <div class="text-center">
                    <div class="fs-4 mb-4 fst-italic">"Welcome to our cozy hostel, where every traveler is a friend waiting to be made. From our comfortable accommodations to our inviting common areas, we strive to create a warm and inclusive environment where you can relax, connect, and create unforgettable memories. Come join us and experience the magic of hostel life firsthand!"</div>
                    <div class="d-flex align-items-center justify-content-center">
                        <img class="rounded-circle me-3" src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." />
                        <div class="fw-bold">
                            Basudeo N. Shrestha
                            <span class="fw-bold text-primary mx-1">/</span>
                            CEO, HostelStays
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container px-5 my-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="text-center">
                    <h2 class="fw-bolder">User Feedback</h2>
                    <p class="lead fw-normal text-muted mb-5">Read what our users are saying about us</p>
                </div>
            </div>
        </div>
        <div class="row gx-5">
            <div class="col-lg-4 mb-5">
                <div class="card h-100 shadow border-0">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <div class="fw-bold">Ankit Bogati</div>
                            <div class="text-muted">Rated: <span class="text-warning">★★★★★</span></div>
                        </div>
                        <p class="card-text mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                        <div class="text-muted">March 12, 2023</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card h-100 shadow border-0">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <div class="fw-bold">Pujan Pant</div>
                            <div class="text-muted">Rated: <span class="text-warning">★★★☆☆</span></div>
                        </div>
                        <p class="card-text mb-4">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                        <div class="text-muted">April 3, 2023</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card h-100 shadow border-0">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <div class="fw-bold">Raksha Khadka</div>
                            <div class="text-muted">Rated: <span class="text-warning">★★★★☆</span></div>
                        </div>
                        <p class="card-text mb-4">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores.</p>
                        <div class="text-muted">April 15, 2023</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
include("mainInclude/footer.php");
?>