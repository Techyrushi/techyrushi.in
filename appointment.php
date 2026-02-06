<?php include 'includes/header.php'; ?>

<!--======== Appointment Page Banner Start ========-->
<section class="rs-page-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-page-banner__content">
                    <h1 class="title">Appointment</h1>
                    <ul>
                        <li><i class="ri-home-wifi-line"></i> <a href="#">Home</a></li>
                        <li><i class="ri-arrow-right-fill"></i> Appointment</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Appointment Page Banner Ends ========-->

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!--======== Appointment Box Start ========-->
<section class="rs-appointment-box pt-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-5"></div>
            <div class="col-lg-7">
                <div class="rs-appointment-box__form">
                    <div class="rs-section-title pb-45">
                        <h2 class="title split-in-fade">Book an Appointment</h2>
                        <p>Schedule a consultation with our IT experts to discuss your business needs and technology solutions.
                        </p>
                    </div>
                    <form id="appointment-form" class="ajax-form" action="submit_appointment.php" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-box">
                                    <input type="text" id="name" name="name" placeholder="Your Name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-box">
                                    <input type="email" id="email" name="email" placeholder="Your Email" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-box">
                                    <input type="text" id="topic" name="topic" placeholder="Your Topic">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-box">
                                    <input type="text" id="phone" name="phone" placeholder="Your Phone">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-box">
                                    <input type="date" id="date" name="date" placeholder="Date" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-box">
                                    <input type="time" id="time" name="time" placeholder="Time" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="input-box">
                                    <textarea name="message" id="message" placeholder="Message..." required></textarea>
                                    <div class="g-recaptcha" data-sitekey="YOUR_RECAPTCHA_SITE_KEY"></div>
                                    <button type="submit" class="main-btn">Book Appointment <i
                                            class="ri-arrow-right-fill"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- <p id="form-messages" class="form-message"></p> -->
                </div>
            </div>
        </div>
    </div>
    <div class="rs-thumb">
        <img src="assets/images/appoinment/team_image_large.png" alt="">
    </div>
</section>
<!--======== Appointment Box Ends ========-->

<?php include 'includes/footer.php'; ?>