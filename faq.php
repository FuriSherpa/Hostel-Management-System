<?php
include("mainInclude/header.php");
?>
<!-- Page Content-->
<section class="py-5">
    <div class="container px-5 my-5">
        <div class="text-center mb-5">
            <h1 class="fw-bolder">Frequently Asked Questions</h1>
            <p class="lead fw-normal text-muted mb-0">How can we help you?</p>
        </div>
        <div class="row gx-5">
            <div class="col-xl-8">
                <!-- FAQ Accordion 1-->
                <h2 class="fw-bolder mb-3">Account &amp; Billing</h2>
                <div class="accordion mb-5" id="accordionExample">
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingOne"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Account Setup</button></h3>
                        <div class="accordion-collapse collapse show" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>This section covers setting up your account and managing billing information.</strong>
                                Explore details about account creation, subscription plans, and updating payment details.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingTwo"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Payment Issues</button></h3>
                        <div class="accordion-collapse collapse" id="collapseTwo" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>Troubleshooting Payment</strong>
                                Get assistance on resolving payment-related queries or errors encountered during transactions.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingThree"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Subscription Plans</button></h3>
                        <div class="accordion-collapse collapse" id="collapseThree" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>Understanding Subscription</strong>
                                Learn about different subscription tiers, their features, and how to upgrade or downgrade your plan.
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FAQ Accordion 2-->
                <h2 class="fw-bolder mb-3">Website Issues</h2>
                <div class="accordion mb-5 mb-xl-0" id="accordionExample2">
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingFour"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">Login Problems</button></h3>
                        <div class="accordion-collapse collapse show" id="collapseFour" aria-labelledby="headingFour" data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                <strong>Troubleshooting Login Issues</strong>
                                Find solutions for login difficulties such as forgotten passwords or account lockouts.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingFive"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Website Errors</button></h3>
                        <div class="accordion-collapse collapse" id="collapseFive" aria-labelledby="headingFive" data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                <strong>Resolving Website Glitches</strong>
                                Learn how to troubleshoot and fix common errors encountered while using our website.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingSix"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">Performance Issues</button></h3>
                        <div class="accordion-collapse collapse" id="collapseSix" aria-labelledby="headingSix" data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                <strong>Improving Website Performance</strong>
                                Tips and tricks to enhance website speed and optimize performance for a smoother user experience.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card border-0 bg-light mt-xl-5">
                    <div class="card-body p-4 py-lg-5">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <div class="h6 fw-bolder">Have more questions?</div>
                                <p class="text-muted mb-4">
                                    Contact us at
                                    <br />
                                    <a href="#!">support@hostelstays.com</a>
                                </p>
                                <div class="h6 fw-bolder">Follow us</div>
                                <a class="fs-5 px-2 link-dark" href="#!"><i class="bi bi-facebook"></i></a>
                                <a class="fs-5 px-2 link-dark" href="#!"><i class="bi-linkedin"></i></a>
                                <a class="fs-5 px-2 link-dark" href="#!"><i class="bi-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include("mainInclude/footer.php");
?>