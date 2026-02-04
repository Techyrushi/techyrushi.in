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

<!--======== Appointment Box Start ========-->
<section class="rs-appointment-box pt-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-5"></div>
            <div class="col-lg-7">
                <div class="rs-appointment-box__form">
                    <div class="rs-section-title pb-45">
                        <h2 class="title split-in-fade">Send a question to an expert</h2>
                        <p>Completely synergize resource taxing relationships via premier niche markets professionally.
                        </p>
                    </div>
                    <form id="contact-form" action="https://demo.rstheme.com/html/Techyrushi/assets/php/contact.php"
                        method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-box">
                                    <input type="text" id="name" name="name" placeholder="Your Name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-box">
                                    <input type="email" id="email" name="email" placeholder="Your Email">
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
                            <div class="col-lg-12">
                                <div class="input-box">
                                    <textarea name="message" id="message" placeholder="Message..."></textarea>
                                    <button type="submit" class="main-btn">Send Message <i
                                            class="ri-arrow-right-fill"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p id="form-messages" class="form-message"></p>
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