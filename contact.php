<?php include 'includes/header.php'; ?>

<!--======== Contact Page Banner Start ========-->
<section class="rs-page-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-page-banner__content">
                    <h1 class="title">Contact</h1>
                    <ul>
                        <li><i class="ri-home-wifi-line"></i> <a href="#">Home</a></li>
                        <li><i class="ri-arrow-right-fill"></i> Contact</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Contact Page Banner Ends ========-->

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!--======== Contact Page Start ========-->
<section class="rs-contact-page pt-120 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="rs-contact-page__info">
                    <div class="rs-section-title black">
                        <h3 class="title split-in-fade">Get in touch with us</h3>
                        <p>We are here to help you with your IT needs. Whether you have a question about our services, pricing, or need technical support, feel free to reach out.</p>
                    </div>
                    <div class="rs-contact-page__info-box">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="title mb-15">Head Office:</h5>
                                <div class="info-box-item">
                                    <div class="rs-info-icon">
                                        <i class="ri-map-2-line"></i>
                                    </div>
                                    <div class="rs-info-contact">
                                        <span>Address</span>
                                        <h5 class="title">Nashik, Maharashtra</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="info-box-item mb-15">
                                    <div class="rs-info-icon">
                                        <i class="ri-phone-line"></i>
                                    </div>
                                    <div class="rs-info-contact">
                                        <span>Call Us</span>
                                        <h5 class="title"><a href="tel:+918446225859">(+91) 8446225859</a> </h5>    
                                    </div>
                                </div>
                                <div class="info-box-item">
                                    <div class="rs-info-icon">
                                        <i class="ri-mail-send-line"></i>
                                    </div>
                                    <div class="rs-info-contact">
                                        <span>Email Us</span>
                                        <h5 class="title"><a href="mailto:techyrushi.talks@gmail.com">techyrushi.talks@gmail.com</a></h5>   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rs-contact-page__info-social mt-20">
                        <h5 class="title">Follow Us:</h5>
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/people/Techyrushitalks/61587126144718/" target="_blank"><i class="ri-facebook-fill"></i></a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/techyrushi.talks?igsh=c2J5Njc1NDZ2dzJv" target="_blank"><i class="ri-instagram-fill"></i></a>
                            </li>
                            <li>
                                <a href="https://github.com/Techyrushi" target="_blank"><i class="ri-github-fill"></i></a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/in/chavanrushikesh/" target="_blank"><i class="ri-linkedin-fill"></i></a>
                            </li>
                            <li>
                                <a href="http://wa.me/+918446225859?text=Hello%21+I+am+contacting+you+from+the+Techyrushi+business+website.+I+would+like+to+know+more+about+your+services." target="_blank"><i class="ri-whatsapp-fill"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="rs-contact-page__content">
                    <div class="rs-section-title black">
                        <h3 class="title split-in-fade">Let’s discuss your project</h3>
                        <p>Ready to start your digital transformation? Fill out the form below and our team will get back to you shortly to discuss your requirements.</p>
                    </div>
                    <form id="contact-form" class="ajax-form" action="submit_contact.php" method="post">
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
                                    <input type="text" id="subject" name="subject" placeholder="Your Subject" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-box">
                                    <input type="text" id="phone" name="phone" placeholder="Your Phone">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="input-box">
                                    <textarea name="message" id="message" placeholder="Message..." required></textarea>
                                    <div class="g-recaptcha" data-sitekey="YOUR_RECAPTCHA_SITE_KEY"></div>
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
</section>
<!--======== Contact Page Ends ========-->

<!--======== Contact Brand Removed ========-->

<!--======== Contact Map Start ========-->
<div class="rs-contact-map">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d119981.2641508823!2d73.7334399723229!3d19.991105342674436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bddd290b09914b3%3A0xcb07845d9d28215c!2sNashik%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1708154541234!5m2!1sen!2sin"
        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
<!--======== Contact Map Ends ========-->


<?php include 'includes/footer.php'; ?>