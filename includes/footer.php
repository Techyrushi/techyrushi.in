<!--======== Footer Start ========-->
<footer class="rs-footer">
    <div class="rs-footer__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="rs-footer__info-box">
                        <div class="icon">
                            <img src="assets/images/footer/info-3.png" alt="" />
                        </div>
                        <div class="content">
                            <span>Contact Us</span>
                            <a href="tel:+918446225859">(+91) 8446225859</a>    
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="rs-footer__info-box">
                        <div class="icon">
                            <img src="assets/images/footer/info-1.png" alt="" />
                        </div>
                        <div class="content">
                            <span>Email Us</span>
                            <a href="mailto:techyrushi.talks@gmail.com">techyrushi.talks@gmail.com</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="rs-footer__info-box">
                        <div class="icon">
                            <img src="assets/images/footer/info-2.png" alt="" />
                        </div>
                        <div class="content">
                            <span>Address</span>
                            <h4 class="title">Nashik, Maharashtra</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rs-footer__main-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="rs-footer__about-box">
                        <a href="index"><img src="assets/images/footer_logo.png" alt="" /></a>
                        <p>
                            Empowering businesses with cutting-edge IT solutions, cloud strategies, and digital transformation services. We build scalable systems and innovative software tailored for your growth.
                        </p>
                        <div class="rs-btn">
                            <a class="main-btn" href="about">
                                Discover More
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                </svg></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="rs-footer__navigation">
                        <div class="rs-footer-title">
                            <h4 class="title">Our Services</h4>
                        </div>
                        <ul>
                            <?php
                            try {
                                $stmt_footer_services = $pdo->query("SELECT title, slug FROM services ORDER BY title ASC LIMIT 6");
                                while ($service = $stmt_footer_services->fetch()) {
                                    echo '<li><a href="service/' . $service['slug'] . '">' . htmlspecialchars($service['title']) . '</a></li>';
                                }
                            } catch (Exception $e) {
                                echo '<li><a href="services">View All Services</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="rs-footer__navigation rs-footer--navigation">
                        <div class="rs-footer-title">
                            <h4 class="title">Information</h4>
                        </div>
                        <ul>
                            <li><a href="about">About</a></li>
                            <li><a href="appointment">Appointment</a></li>
                            <li><a href="project">Our Projects</a></li>
                            <!-- <li><a href="pricing">Pricing</a></li> -->
                            <li><a href="services">Services</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="rs-footer__newsletter">
                        <div class="rs-footer-title">
                            <h4 class="title">Newsletter</h4>
                        </div>
                        <p>
                            Subscribe to our newsletter for the latest updates on technology trends, company news, and exclusive offers.
                        </p>
                        <form id="newsletter-form" class="ajax-form" action="submit_newsletter.php" method="POST">
                            <div class="input-box">
                                <input type="email" name="email" placeholder="Your email address" required />
                                <button type="submit" class="main-btn">
                                    Subscribe
                                    <svg width="13" height="14" viewBox="0 0 13 14" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.5 7.8125H0V6.1875H6.5V0.5L13 7L6.5 13.5V7.8125Z" fill="#fff"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rs-footer__menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="rs-footer__menu-box">
                        <ul>
                            <li><a href="privacy">Privacy Policy</a></li>
                            <li><a href="terms">Terms of use</a></li>
                            <li><a href="disclaimer">Disclaimer</a></li>
                            <li><a href="sitemap">Sitemap</a></li>  
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="rs-footer__social">
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/people/Techyrushitalks/61587126144718/" target="_blank"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/techyrushi.talks?igsh=c2J5Njc1NDZ2dzJv" target="_blank"><i class="fa fa-instagram"></i></a>
                            </li>
                            <li>
                                <a href="https://github.com/Techyrushi" target="_blank"><i class="fa fa-github"></i></a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/in/chavanrushikesh/" target="_blank"><i class="fa fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a href="http://wa.me/+918446225859?text=Hello%21+I+am+contacting+you+from+the+Techyrushi+business+website.+I+would+like+to+know+more+about+your+services." target="_blank"><i class="fa fa-whatsapp"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rs-footer__copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="rs-footer__copyright-text">
                        <p>
                            © 2026 Techyrushi. Designed By
                            <a target="_blank" href="https://techyrushi.vercel.app/">Rushikesh Chavan.</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--======== Footer Start ========-->

<!--======== Scroll up and prograss start ========-->
<div id="scrollUp">
    <svg class="arrowup" viewBox="0 0 24 24" width="18" height="18">
        <path d="M13 7.828V20h-2V7.828l-5.364 5.364-1.414-1.414L12 4l7.778 7.778-1.414 1.414L13 7.828z" fill="#fff">
        </path>
    </svg>
    <svg class="scrollprogress" width="40" height="40">
        <circle class="progress-circle" cx="20" cy="20" r="18" stroke-width="2" fill="none" stroke="#fff"
            stroke-dasharray="113.1" stroke-dashoffset="113.1"></circle>
    </svg>
</div>
<!--======== Scroll up and prograss Ends ========-->

<!-- Custom Cursor Start -->
<div id="rs-mouse">
    <div id="cursor-ball"></div>
</div>
<!-- Custom Cursor End -->

<!-- JS Vendor, Plugins & Activation Script Files -->

<!-- jquery Plugins JS -->
<script src="assets/js/jquery.min.js"></script>

<!-- jquery UI JS -->
<script src="assets/js/jquery-ui.min.js"></script>

<!-- bootstrap JS -->
<script src="assets/js/bootstrap.min.js"></script>

<!-- ajax-contact JS -->
<script src="assets/js/ajax-contact.js"></script>

<!-- wow animation JS -->
<script src="assets/js/wow.min.js"></script>

<!-- appear JS -->
<script src="assets/js/jquery.appear.min.js"></script>

<!-- typer JS -->
<script src="assets/js/typer.js"></script>

<!-- PageScroll2id JS -->
<script src="assets/js/jquery.malihu.PageScroll2id.min.js"></script>

<!-- marquee JS -->
<script src="assets/js/jquery.marquee.min.js"></script>

<!-- Slick Slider JS -->
<script src="assets/js/slick.min.js"></script>

<!-- owl carousel JS -->
<script src="assets/js/owl.carousel.min.js"></script>

<!-- flickity JS -->
<script src="assets/js/flickity.pkgd.min.js"></script>

<!-- odometer JS -->
<script src="assets/js/odometer.min.js"></script>

<!-- skeletabs JS -->
<script src="assets/js/skeletabs.js"></script>

<!-- magnific popup js -->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>

<!-- GSAP Interactions Start -->
<script src="assets/js/interactions/gsap.min.js"></script>
<script src="assets/js/interactions/rs-scroll-trigger.min.js"></script>
<script src="assets/js/interactions/rs-splitText.min.js"></script>
<script src="assets/js/interactions/rs-anim-int.js"></script>
<!-- GSAP Interactions End -->

<!-- Activation JS -->
<script src="assets/js/main.js"></script>
</body>

</html>