<?php include 'includes/header.php'; ?>

<!--======== About Page Banner Start ========-->
<section class="rs-page-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-page-banner__content">
                    <h1 class="title">About</h1>
                    <ul>
                        <li><i class="ri-home-wifi-line"></i> <a href="#">Home</a></li>
                        <li><i class="ri-arrow-right-fill"></i> About</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== About Page Banner Ends ========-->

<!--======== About Page Start ========-->
<section id="rs-about" class="rs-about rs-about-page pb-120 pt-120">
    <div class="rs-about__shape">
        <img src="assets/images/about/arrow-purple-2.svg" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="rs-about__thumb-box">
                    <img src="assets/images/about/about-image.png" alt="">
                    <div class="rs-about__play-box">
                        <div>
                            <img src="assets/images/techyrushi.png" alt="" />
                        </div>
                    </div>
                    <div class="rs-about__countdown-box">
                        <div class="icon">
                            <img src="assets/images/about/count-down-experience-icon.svg" alt="">
                        </div>
                        <div class="coundown-text">
                            <span><span class="rs-count">5</span>+</span>
                            <h4 class="title"> Years Experience</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="rs-about__box">
                    <div class="top-sub-heading">
                        <img src="assets/images/heart-pulse-rate-orange-2.svg" alt="icon">
                        <span>Who We Are</span>
                        <img src="assets/images/heart-pulse-rate-orange.svg" alt="icon">
                    </div>
                    <h2 class="title split-in-fade">Leading IT Solutions & Digital Transformation Partner</h2>
                    <p>At Techyrushi, we don't just write code; we build the future. With over a decade of expertise, we
                        empower businesses to navigate the digital landscape with confidence. From agile startups to
                        established enterprises, we deliver tailored technology solutions that drive efficiency,
                        security, and growth.</p>
                    <ul>
                        <li>
                            <div class="icon">
                                <i class="ri-lightbulb-flash-line" style="font-size: 40px; color: #ff5e14;"></i>
                            </div>
                            <span>Innovative Strategy</span>
                        </li>
                        <li>
                            <div class="icon">
                                <i class="ri-code-s-slash-line" style="font-size: 40px; color: #ff5e14;"></i>
                            </div>
                            <span>Technical Excellence</span>
                        </li>
                    </ul>
                    <p>Our integrated approach ensures seamless connectivity and robust infrastructure for your business
                        needs.</p>
                    <a class="main-btn" href="about"> Discover More <i class="ri-arrow-right-fill"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== About Page Ends ========-->

<!--======== About Featured Start ========-->
<section class="rs-featured-2 about-featured pt-115 pb-120 mb-120">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="rs-section-title black">
                    <div class="top-sub-heading">
                        <img src="assets/images/heart-pulse-rate-orange-2.svg" alt="icon">
                        <span>Our Feachered Services</span>
                        <img src="assets/images/heart-pulse-rate-orange.svg" alt="icon">
                    </div>
                    <h2 class="title split-in-fade">We run all kinds of IT services</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            include_once 'includes/db.php';
            $stmt = $pdo->query("SELECT * FROM services ORDER BY created_at ASC LIMIT 3");
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch()) {
                    $img_src = !empty($row['image']) ? "assets/images/service/" . $row['image'] : "assets/images/featured/featured-thumb-4.png";
                    $icon_class = !empty($row['icon']) ? $row['icon'] : "flaticon-web";
                    ?>
                    <div class="col-lg-4 col-sm-6">
                        <div class="rs-featured-2__item">
                            <div class="rs-thumb">
                                <img src="<?php echo $img_src; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                            </div>
                            <div class="rs-content">
                                <div class="rs-icon">
                                    <img src="assets/images/service/<?php echo $icon_class; ?>" alt="icon">
                                </div>
                                <h4 class="title"><a
                                        href="service-details.php?slug=<?php echo $row['slug']; ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                                </h4>
                                <p><?php echo htmlspecialchars(substr(strip_tags($row['short_description']), 0, 100)) . '...'; ?>
                                </p>
                                <div class="rs-link">
                                    <a class="rs-link" href="service-details.php?slug=<?php echo $row['slug']; ?>">Read More <i
                                            class="ri-arrow-right-fill"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-12"><p>No services found.</p></div>';
            }
            ?>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-featured-2__btn">
                    <a class="main-btn" href="services"> View All Services <svg xmlns="http://www.w3.org/2000/svg"
                            width="14" height="14" viewBox="0 0 14 14">
                            <path
                                d="M6.66667 7.83337H0V6.16671H6.66667V0.333374L13.3333 7.00004L6.66667 13.6667V7.83337Z"
                                fill="#ffffff"></path>
                            <defs>
                                <linearGradient id="paint0_linear_396_7812" x1="-8.73939e-08" y1="2.11909" x2="14.0834"
                                    y2="3.24424" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FE8801" offset="1"></stop>
                                    <stop offset="1" stop-color="#F5B163"></stop>
                                </linearGradient>
                            </defs>
                        </svg></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== About Featured Ends ========-->

<!--======== Why Choose 2 Start ========-->
<section class="rs-why-choose-2 pb-85">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="why-choose-2__content">
                    <div class="rs-section-title black">
                        <div class="top-sub-heading">
                            <img src="assets/images/heart-pulse-rate-orange-2.svg" alt="icon">
                            <span>Why Choose Us</span>
                            <img src="assets/images/heart-pulse-rate-orange.svg" alt="icon">
                        </div>
                        <h2 class="title split-in-fade">5+ Years of Excellence in IT Innovation.</h2>
                        <p>With over a decade of industry leadership, we deliver tailored solutions that address your
                            unique business challenges with precision and creativity.</p>
                    </div>
                    <div class="skill-bars">
                        <div class="rs-progress-skill why-choose-two__progress">
                            <h4 class="rs-progress__title">Business Strategy</h4>
                            <div class="rs-progress__bar">
                                <div class="rs-progress__inner rs-count-bar counted" data-percent="90%">
                                    <p class="rs-progress__number count-text">90%</p>
                                </div>
                            </div>
                        </div><!-- /.rs-progress -->
                        <div class="rs-progress-skill why-choose-two__progress">
                            <h4 class="rs-progress__title">AI & Data Analytics</h4>
                            <div class="rs-progress__bar">
                                <div class="rs-progress__inner rs-count-bar counted" data-percent="85%">
                                    <p class="rs-progress__number count-text">85%</p>
                                </div>
                            </div>
                        </div><!-- /.rs-progress -->
                        <div class="rs-progress-skill why-choose-two__progress">
                            <h4 class="rs-progress__title">Software Development</h4>
                            <div class="rs-progress__bar">
                                <div class="rs-progress__inner rs-count-bar counted" data-percent="98%">
                                    <p class="rs-progress__number count-text">98%</p>
                                </div>
                            </div>
                        </div><!-- /.rs-progress -->
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="rs-why-choose-2__thumb wow fadeInRight" data-wow-duration="1.5s" data-wow-delay="0.4s">
                    <div class="rs-thumb-1">
                        <img src="assets/images/why-choose/chose-right-left.jpg" alt="">
                    </div>
                    <div class="rs-thumb-2">
                        <img src="assets/images/why-choose/chose-right-right.jpg" alt="">
                        <img src="assets/images/why-choose/chose-right-bottom.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Why Choose 2 Ends ========-->

<!--======== Counter 2 Start ========-->
<section class="rs-counter-2 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-counter-2__title">
                    <h5 class="title">Glimpse of our work and presence</h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="rs-counter-2__item">
                    <div class="rs-counter-2__icon">
                        <i class="ri-briefcase-4-line" style="font-size: 45px; color: #ff5e14;"></i>
                    </div>
                    <div class="rs-counter-2__content">
                        <h4 class="title"><span class="rs-count odometer" data-count="150">00</span> +</h4>
                        <span>Projects Completed</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="rs-counter-2__item item-2">
                    <div class="rs-counter-2__icon">
                        <i class="ri-window-line" style="font-size: 45px; color: #ff5e14;"></i>
                    </div>
                    <div class="rs-counter-2__content">
                        <h4 class="title"><span class="rs-count odometer" data-count="120">00</span> +</h4>
                        <span>Websites Launched</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="rs-counter-2__item item-3">
                    <div class="rs-counter-2__icon">
                        <i class="ri-emotion-happy-line" style="font-size: 45px; color: #ff5e14;"></i>
                    </div>
                    <div class="rs-counter-2__content">
                        <h4 class="title"><span class="rs-count odometer" data-count="100">00</span> +</h4>
                        <span>Happy Clients</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="rs-counter-2__item item-4">
                    <div class="rs-counter-2__icon">
                        <i class="ri-star-smile-line" style="font-size: 45px; color: #ff5e14;"></i>
                    </div>
                    <div class="rs-counter-2__content">
                        <h4 class="title"><span class="rs-count odometer" data-count="500">00</span> +</h4>
                        <span>Customer Reviews</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Counter 2 Ends ========-->

<!--======== Testimonial Start ========-->
<section class="rs-testimonial pt-20 pb-145">
    <div class="container">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="rs-section-title black">
                    <div class="top-sub-heading">
                        <img src="assets/images/heart-pulse-rate-orange-2.svg" alt="icon" />
                        <span>Testimonials</span>
                        <img src="assets/images/heart-pulse-rate-orange.svg" alt="icon" />
                    </div>
                    <h2 class="title split-in-fade">
                        What Customers Said About Our Techyrushi
                    </h2>
                </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
        <div class="rs-carousel owl-carousel nav-style1" data-loop="true" data-items="3" data-margin="30"
            data-autoplay="true" data-hoverpause="false" data-autoplay-timeout="5000" data-smart-speed="800"
            data-dots="false" data-nav="true" data-nav-speed="false" data-center-mode="false" data-mobile-device="1"
            data-mobile-device-nav="true" data-mobile-device-dots="false" data-ipad-device="2"
            data-ipad-device-nav="true" data-ipad-device-dots="false" data-ipad-device2="2" data-ipad-device-nav2="true"
            data-ipad-device-dots2="false" data-md-device="2" data-lg-device="3" data-md-device-nav="true"
            data-md-device-dots="false" data-doteach="false">
            <?php
            // Fetch testimonials
            $stmt_testimonials = $pdo->query("SELECT * FROM testimonials ORDER BY id DESC LIMIT 6");
            if ($stmt_testimonials->rowCount() > 0) {
                while ($testimonial = $stmt_testimonials->fetch()) {
                    $testimonial_img = !empty($testimonial['image']) ? "assets/images/testimonial/" . $testimonial['image'] : "assets/images/testimonial/testi1.jpg";
                    ?>
                    <div class="rs-testimonial__item">
                        <div class="rs-testimonial-content-box">
                            <p>
                                <?php echo htmlspecialchars($testimonial['content']); ?>
                            </p>
                            <div class="rs-ratings">
                                <img src="assets/images/testimonial/rating-1.png" alt="" />
                            </div>
                            <div class="rs-quote">
                                <img src="assets/images/testimonial/quote-white.svg" alt="" />
                            </div>
                        </div>
                        <div class="rs-testimonial-user">
                            <div class="thumb"
                                style="background: #F26F20; display: flex; align-items: center; justify-content: center; height: 65px;">
                                <i class="ri-user-voice-fill" style="font-size: 30px; color: #fff;"></i>
                            </div>
                            <div class="content">
                                <h4 class="title"><?php echo htmlspecialchars($testimonial['name']); ?></h4>
                                <span><?php echo htmlspecialchars($testimonial['designation']); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-12 text-center"><p>No testimonials found.</p></div>';
            }
            ?>
        </div>
    </div>
</section>
<!--======== Testimonial Ends ========-->

<?php include 'includes/footer.php'; ?>