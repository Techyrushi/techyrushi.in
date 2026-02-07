<?php include 'includes/header.php'; ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--======== Banner Start ========-->
<section class="rs-banner">
  <div class="rs-banner-slider">
    <div class="items">
      <div class="rs-banner--slider-item">
        <div class="container">
          <div class="row">
            <div class="col-lg-7">
              <div class="rs-banner--inner-content">
                <h1 class="title" data-animation="fadeInDown" data-delay="0.1s">
                  2026
                </h1>
                <div class="rs-banner__box" data-animation="fadeInLeft" data-delay="0.3s">
                  <div class="rs-banner__image-box">
                    <img src="assets/images/heart-pulse-rate-orange-2.svg" alt="" />
                  </div>
                  <span>Welcome To Techyrushi</span>
                </div>
                <h1 class="title-2" data-animation="fadeInLeft" data-delay="0.6s">
                  Tech Solutions For
                  Digital Future
                </h1>
                <p data-animation="fadeInLeft" data-delay="0.9s">
                  Igniting digital transformation with future-ready technology. We turn ambitious concepts into powerful
                  realities through expert development and strategic consulting.
                </p>
                <a data-animation="fadeInUp" data-delay="1.2s" class="main-btn" href="about">Get Started <i
                    class="ri-arrow-right-fill"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="rs-banner__thumb" data-animation="fadeInUp" data-delay="1.5s">
          <img src="assets/images/banner/man_standing.png" alt="" />
        </div>
        <div class="rs-banner__shape1">
          <img src="assets/images/banner/meter.png" alt="" />
        </div>
        <div class="rs-banner__shape2">
          <img src="assets/images/banner/white-shape.png" alt="" />
          <img class="item-2" src="assets/images/banner/white-shapes.png" alt="" />
        </div>
        <div class="rs-banner__shape3">
          <img src="assets/images/banner/rotate-img1.svg" alt="" />
        </div>
        <div class="rs-banner__shape4">
          <img src="assets/images/banner/rotate-img1.svg" alt="" />
        </div>
        <div class="rs-banner__shape5">
          <img src="assets/images/banner/arrow.png" alt="" />
        </div>
        <div class="rs-banner__shape6">
          <img src="assets/images/banner/arrow.png" alt="" />
        </div>
        <div class="rs-banner__shape7">
          <img src="assets/images/banner/twist-path.svg" alt="" />
        </div>
        <div class="rs-banner__shape8">
          <img src="assets/images/banner/twist-path.svg" alt="" />
        </div>
      </div>
    </div>
    <div class="items">
      <div class="rs-banner--slider-item">
        <div class="container">
          <div class="row">
            <div class="col-lg-7">
              <div class="rs-banner--inner-content">
                <h1 class="title" data-animation="fadeInDown" data-delay="0.1s">
                  2026
                </h1>
                <div class="rs-banner__box" data-animation="fadeInLeft" data-delay="0.3s">
                  <div class="rs-banner__image-box">
                    <img src="assets/images/heart-pulse-rate-orange-2.svg" alt="" />
                  </div>
                  <span>Welcome To Techyrushi</span>
                </div>
                <h1 data-animation="fadeInLeft" data-delay="0.6s" class="title-2">
                  Surfing The Waves of IT
                  Innovation
                </h1>
                <p data-animation="fadeInLeft" data-delay="0.9s">
                  Pioneering the next wave of digital excellence. Our bespoke IT strategies deliver robust, scalable
                  solutions designed to propel your business forward.
                </p>
                <a data-animation="fadeInUp" data-delay="1.2s" class="main-btn" href="about">Get Started <i
                    class="ri-arrow-right-fill"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="rs-banner__thumb" data-animation="fadeInUp" data-delay="1.5s">
          <img src="assets/images/banner/vr_man.png" alt="" />
        </div>
        <div class="rs-banner__shape1">
          <img src="assets/images/banner/meter.png" alt="" />
        </div>
        <div class="rs-banner__shape2">
          <img src="assets/images/banner/white-shape.png" alt="" />
          <img class="item-2" src="assets/images/banner/white-shapes.png" alt="" />
        </div>
        <div class="rs-banner__shape3">
          <img src="assets/images/banner/rotate-img1.svg" alt="" />
        </div>
        <div class="rs-banner__shape4">
          <img src="assets/images/banner/rotate-img1.svg" alt="" />
        </div>
        <div class="rs-banner__shape5">
          <img src="assets/images/banner/arrow.png" alt="" />
        </div>
        <div class="rs-banner__shape6">
          <img src="assets/images/banner/arrow.png" alt="" />
        </div>
        <div class="rs-banner__shape7">
          <img src="assets/images/banner/twist-path.svg" alt="" />
        </div>
        <div class="rs-banner__shape8">
          <img src="assets/images/banner/twist-path.svg" alt="" />
        </div>
      </div>
    </div>
  </div>
</section>
<!--======== Banner Ends ========-->

<!--======== Service Start ========-->
<div class="single-service pt-90">
  <div class="container">
    <div class="row">
      <?php
      // Fetch top 4 services
      $stmt_services = $pdo->query("SELECT * FROM services ORDER BY display_order ASC LIMIT 4");
      if ($stmt_services->rowCount() > 0) {
        while ($service = $stmt_services->fetch()) {
          $service_icon = !empty($service['icon']) ? $service['icon'] : "flaticon-web";
          ?>
          <div class="col-lg-3 col-md-6 col-sm-6 mb-30">
            <div class="single-service__item h-100">
              <div class="single-service__icon">
                <img src="assets/images/service/service-icon.png" alt="" />
              </div>
              <a
                href="service/<?php echo htmlspecialchars($service['slug']); ?>"><?php echo htmlspecialchars($service['title']); ?></a>
              <p>
                <?php echo htmlspecialchars(substr(strip_tags($service['short_description']), 0, 80)) . '...'; ?>
              </p>
            </div>
          </div>
          <?php
        }
      }
      ?>
    </div>
  </div>
</div>
<!--======== Service Ends ========-->

<!--======== About 1 Start ========-->
<section id="rs-about" class="rs-about pb-120 pt-120">
  <div class="rs-about__shape">
    <img class="gsap-move down-200 start-91" src="assets/images/about/arrow-purple.svg" alt="" />
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="rs-about__thumb-box">
          <img src="assets/images/about/about-image.png" alt="" />
          <div class="rs-about__play-box">
            <div>
              <img src="assets/images/techyrushi.png" alt="" />
            </div>
          </div>
          <div class="rs-about__countdown-box">
            <div class="icon">
              <img src="assets/images/about/count-down-experience-icon.svg" alt="" />
            </div>
            <div class="coundown-text">
              <span><span class="rs-count">5</span>+</span>
              <h4 class="title">Years Experience</h4>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="rs-about__box">
          <div class="top-sub-heading">
            <img src="assets/images/heart-pulse-rate-orange-2.svg" alt="icon" />
            <span>Who We Are</span>
            <img src="assets/images/heart-pulse-rate-orange.svg" alt="icon" />
          </div>
          <h2 class="title split-in-fade">
            Your Catalyst for Digital Evolution and Sustainable Growth.
          </h2>
          <p>
            We craft holistic IT ecosystems that accelerate business potential. From bespoke software engineering to
            strategic digital overhauls, we stand as your dedicated ally in the technological landscape.
          </p>
          <ul>
            <li>
              <div class="icon">
                <i class="ri-wifi-line" style="font-size: 40px; color: #ff5e14;"></i>
              </div>
              <span>Seamless Connectivity</span>
            </li>
            <li>
              <div class="icon">
                <i class="ri-settings-5-line" style="font-size: 40px; color: #ff5e14;"></i>
              </div>
              <span>Advanced Solutions</span>
            </li>
          </ul>
          <p>
            Driven by a passion for excellence, we engineer high-caliber solutions that not only align with your unique
            objectives but also redefine the boundaries of what's possible.
          </p>
          <a class="main-btn" href="about">
            Discover More <i class="ri-arrow-right-fill"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!--======== About 1 Ends ========-->

<!--======== Featured Start ========-->
<section id="rs-service" class="rs-featured pt-115 pb-120">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="rs-section-title">
          <div class="top-sub-heading">
            <img src="assets/images/heart-pulse-rate-white.svg" alt="icon" />
            <span>Featured Services</span>
            <img src="assets/images/heart-pulse-rate-white.svg" alt="icon" />
          </div>
          <h2 class="title split-in-fade">
            Elevating your digital presence with cutting-edge innovations.
          </h2>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="rs-featured__btn">
          <a class="main-btn" href="services">
            View All Services <i class="ri-arrow-right-fill"></i></a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="rs-featured__item h-100">
          <div class="rs-featured__icon">
            <img width="40" src="assets/images/featured/mobile.png" alt="" />
            <h4 class="title">
              Digital <br />
              Marketing
            </h4>
          </div>
          <div class="rs-featured__list-box">
            <ul>
              <li>
                <div class="icon">
                  <i class="ri-search-line" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">SEO Optimization</a>
              </li>
              <li>
                <div class="icon">
                  <i class="ri-facebook-circle-fill" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">Social Media</a>
              </li>
              <li>
                <div class="icon">
                  <i class="ri-advertisement-line" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">PPC Advertising</a>
              </li>
              <li>
                <div class="icon">
                  <i class="ri-quill-pen-line" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">Content Strategy</a>
              </li>
              <li>
                <div class="icon">
                  <i class="ri-mail-send-line" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">Email Marketing</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="rs-featured__item h-100">
          <div class="rs-featured__icon">
            <img width="70" src="assets/images/featured/desktop.png" alt="" />
            <h4 class="title">
              Web <br />
              Development
            </h4>
          </div>
          <div class="rs-featured__list-box">
            <ul>
              <li>
                <div class="icon">
                  <i class="ri-rocket-line" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">Startup & SaaS Platforms</a>
              </li>
              <li>
                <div class="icon">
                  <i class="ri-shopping-cart-2-line" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">E-Commerce Development</a>
              </li>
              <li>
                <div class="icon">
                  <i class="ri-building-line" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">Enterprise & Business Systems</a>
              </li>
              <li>
                <div class="icon">
                  <i class="ri-government-line" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">Government & Institutional Portals</a>
              </li>
              <li>
                <div class="icon">
                  <i class="ri-code-s-slash-line" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">Custom Web Applications & Portals</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="rs-featured__item h-100">
          <div class="rs-featured__icon">
            <img width="70" src="assets/images/featured/ecommerce-basket.png" alt="" />
            <h4 class="title">
              Graphic Design <br />
              Services
            </h4>
          </div>
          <div class="rs-featured__list-box">
            <ul>
              <li>
                <div class="icon">
                  <i class="ri-brush-line" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">Logo & Brand Identity</a>
              </li>
              <li>
                <div class="icon">
                  <i class="ri-layout-masonry-line" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">UI/UX Design</a>
              </li>
              <li>
                <div class="icon">
                  <i class="ri-image-line" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">Social Media Graphics</a>
              </li>
              <li>
                <div class="icon">
                  <i class="ri-booklet-line" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">Marketing Materials</a>
              </li>
              <li>
                <div class="icon">
                  <i class="ri-box-3-line" style="font-size: 24px; color: #ff5e14;"></i>
                </div>
                <a href="services">Packaging Design</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--======== Featured Ends ========-->

<!--======== Why Choose Start ========-->
<section class="rs-why-choose pt-120 pb-90">
  <div class="rs-why-choose__shape-1">
    <img src="assets/images/why-choose/chose-left-shape.png" alt="" />
  </div>
  <div class="rs-why-choose__shape-2">
    <img src="assets/images/why-choose/chose-right-shape.png" alt="" />
  </div>
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="rs-why-choose__thumb">
          <img src="assets/images/why-choose/why-choose-left1.png" alt="" />
          <img class="item-2" src="assets/images/why-choose/why-choose-levft1" alt="" />
        </div>
      </div>
      <div class="col-lg-6">
        <div class="rs-why-choose__content">
          <div class="rs-section-title black">
            <div class="top-sub-heading">
              <img src="assets/images/heart-pulse-rate-orange-2.svg" alt="icon" />
              <span>Why Choose Us</span>
              <img src="assets/images/heart-pulse-rate-orange.svg" alt="icon" />
            </div>
            <h2 class="title split-in-fade">
              Why Partner With Us?
            </h2>
            <p>
              We architect bespoke IT solutions that optimize efficiency and catalyze growth. Our team is committed to
              your triumph, providing round-the-clock support and seasoned expertise.
            </p>
          </div>
          <div class="rs-why-choose__item-list">
            <ul>
              <li>
                <div class="thumb">
                  <img src="assets/images/why-choose/ch-ico2.png" alt="" />
                </div>
                <div class="content">
                  <h4 class="title">Proven Expertise</h4>
                  <p>
                    Over 5 years of pioneering IT excellence, empowering businesses to evolve and thrive through
                    transformative technology.
                  </p>
                </div>
              </li>
              <li>
                <div class="thumb">
                  <img src="assets/images/why-choose/ch-ico3.png" alt="" />
                </div>
                <div class="content">
                  <h4 class="title">Unwavering Support</h4>
                  <p>
                    A dedicated technical team available 24/7, ensuring your business operations remain seamless and
                    uninterrupted.
                  </p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--======== Why Choose Ends ========-->

<!--======== Counter Start ========-->
<section class="rs-counter pb-120">
  <div class="container">
    <div class="row">
      <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="rs-counter__item">
          <div class="icon">
            <i class="ri-briefcase-4-line" style="font-size: 45px; color: #ff5e14;"></i>
          </div>
          <span><span class="rs-count odometer" data-count="150">00</span>+</span>
          <h4 class="title">
            Projects <br />
            Completed
          </h4>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="rs-counter__item">
          <div class="icon">
            <i class="ri-macbook-line" style="font-size: 45px; color: #ff5e14;"></i>
          </div>
          <span><span class="rs-count odometer" data-count="120">00</span>+</span>
          <h4 class="title">
            Websites <br />
            Launched
          </h4>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="rs-counter__item">
          <div class="icon">
            <i class="ri-emotion-happy-line" style="font-size: 45px; color: #ff5e14;"></i>
          </div>
          <span><span class="rs-count odometer" data-count="100">00</span>+</span>
          <h4 class="title">
            Happy <br />
            Clients
          </h4>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="rs-counter__item">
          <div class="icon">
            <i class="ri-database-2-line" style="font-size: 45px; color: #ff5e14;"></i>
          </div>
          <span><span class="rs-count odometer" data-count="50">00</span>+</span>
          <h4 class="title">
            Data <br />
            Projects
          </h4>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="rs-counter__item">
          <div class="icon">
            <i class="ri-chat-smile-3-line" style="font-size: 45px; color: #ff5e14;"></i>
          </div>
          <span><span class="rs-count odometer" data-count="500">00</span>+</span>
          <h4 class="title">
            Customer <br />
            Reviews
          </h4>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="rs-counter__item">
          <div class="icon">
            <i class="ri-checkbox-circle-line" style="font-size: 45px; color: #ff5e14;"></i>
          </div>
          <span><span class="rs-count odometer" data-count="150">00</span>+</span>
          <h4 class="title">
            Successful <br />
            Deliveries
          </h4>
        </div>
      </div>
    </div>
  </div>
</section>
<!--======== Counter Ends ========-->

<!--======== Cta Start ========-->
<section class="rs-cta pt-95 pb-130">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="rs-section-title">
          <div class="top-sub-heading">
            <img src="assets/images/heart-pulse-rate-white.svg" alt="icon" />
            <span>Work </span>
            <img src="assets/images/heart-pulse-rate-white.svg" alt="icon" />
          </div>
          <h2 class="title split-in-fade">
            Who we work with
          </h2>
          <p>
            Collaborating with visionaries across the spectrum, from agile startups to industry giants. Our mission is
            to deliver scalable technology that evolves in tandem with your ambitions.
          </p>
          <a class="main-btn" href="appointment">Let's Work Together <i class="ri-arrow-right-fill"></i></a>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="rs-cta__main-box">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="rs-cta__item-box">
                <div class="rs-image">
                  <img src="assets/images/cta/work-gradient-border.png" alt="" />
                  <img class="item-2" src="assets/images/cta/dark-Border.png" alt="" />
                </div>
                <div class="rs-cta__box">
                  <div class="bg-icon" style="
                          background-image: url(assets/images/cta/handshake2.png);
                        "></div>
                  <div class="icon">
                    <img src="assets/images/cta/handshake2.png" alt="" />
                  </div>
                  <h4 class="title"><a href="#">Start Up Business </a></h4>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="rs-cta__item-box">
                <div class="rs-image">
                  <img src="assets/images/cta/work-gradient-border.png" alt="" />
                  <img class="item-2" src="assets/images/cta/dark-Border.png" alt="" />
                </div>
                <div class="rs-cta__box">
                  <div class="bg-icon" style="
                          background-image: url(assets/images/cta/bar-chart2.png);
                        "></div>
                  <div class="icon">
                    <img src="assets/images/cta/bar-chart2.png" alt="" />
                  </div>
                  <h4 class="title">
                    <a href="#">Small & Medium Business </a>
                  </h4>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="rs-cta__item-box">
                <div class="rs-image">
                  <img src="assets/images/cta/work-gradient-border.png" alt="" />
                  <img class="item-2" src="assets/images/cta/dark-Border.png" alt="" />
                </div>
                <div class="rs-cta__box">
                  <div class="bg-icon" style="
                          background-image: url(assets/images/cta/property2.png);
                        "></div>
                  <div class="icon">
                    <img src="assets/images/cta/property2.png" alt="" />
                  </div>
                  <h4 class="title"><a href="#">Agencies </a></h4>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="rs-cta__item-box">
                <div class="rs-image">
                  <img src="assets/images/cta/work-gradient-border.png" alt="" />
                  <img class="item-2" src="assets/images/cta/dark-Border.png" alt="" />
                </div>
                <div class="rs-cta__box">
                  <div class="bg-icon" style="
                          background-image: url(assets/images/cta/enterprise.png);
                        "></div>
                  <div class="icon">
                    <img src="assets/images/cta/enterprise.png" alt="" />
                  </div>
                  <h4 class="title"><a href="#">Enterprise </a></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--======== Cta Ends ========-->

<!--======== Progress Start ========-->
<section class="rs-progress pt-110">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="rs-section-title black">
          <div class="top-sub-heading">
            <img src="assets/images/heart-pulse-rate-orange-2.svg" alt="icon" />
            <span>Working Process </span>
            <img src="assets/images/heart-pulse-rate-orange.svg" alt="icon" />
          </div>
          <h2 class="title split-in-fade">
            Process we follow
          </h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-sm-6">
        <div class="rs-progress__item-box">
          <div class="rs-progress-line">
            <img src="assets/images/progress/progress-line-1.png" alt="" />
          </div>
          <div class="rs-progress__item">
            <div class="icon">
              <img src="assets/images/progress/progress-icon-1.png" alt="" />
            </div>
            <h4 class="title">Planning</h4>
            <p>We analyze your requirements to create a strategic roadmap for success.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="rs-progress__item-box item-2">
          <div class="rs-progress-line">
            <img src="assets/images/progress/progress-line-2.png" alt="" />
          </div>
          <div class="rs-progress__item">
            <div class="icon">
              <img src="assets/images/progress/progress-icon-2.png" alt="" />
            </div>
            <h4 class="title">Design</h4>
            <p>Our team designs intuitive and scalable solutions tailored to your needs.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="rs-progress__item-box item-3">
          <div class="rs-progress-line">
            <img src="assets/images/progress/progress-line-3.png" alt="" />
          </div>
          <div class="rs-progress__item">
            <div class="icon">
              <img src="assets/images/progress/progress-icon-3.png" alt="" />
            </div>
            <h4 class="title">Development</h4>
            <p>We build robust applications using cutting-edge technologies.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="rs-progress__item-box item-4">
          <div class="rs-progress-line">
            <img src="assets/images/progress/progress-line-4.png" alt="" />
          </div>
          <div class="rs-progress__item">
            <div class="icon">
              <img src="assets/images/progress/progress-icon-4.png" alt="" />
            </div>
            <h4 class="title">Delivery</h4>
            <p>We ensure smooth deployment and provide ongoing support.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--======== Progress Ends ========-->

<!--======== Case Study Start ========-->
<section id="rs-portfolios" class="rs-case-study pt-120 pb-120">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-4">
        <div class="rs-section-title">
          <div class="top-sub-heading">
            <img src="assets/images/heart-pulse-rate-white.svg" alt="icon" />
            <span>Case Study</span>
            <img src="assets/images/heart-pulse-rate-white.svg" alt="icon" />
          </div>
          <h2 class="title split-in-fade">
            Our recent launched
            projects available into market
          </h2>
          <a class="main-btn" href="project">View All Projects <i class="ri-arrow-right-fill"></i></a>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="rs-case-study__slider">
          <div class="rs-carousel owl-carousel nav-style1" data-loop="true" data-items="2" data-margin="30"
            data-autoplay="true" data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800"
            data-dots="false" data-nav="true" data-nav-speed="false" data-center-mode="false" data-mobile-device="1"
            data-mobile-device-nav="true" data-mobile-device-dots="false" data-ipad-device="2"
            data-ipad-device-nav="true" data-ipad-device-dots="false" data-ipad-device2="2" data-ipad-device-nav2="true"
            data-ipad-device-dots2="false" data-md-device="2" data-lg-device="2" data-md-device-nav="true"
            data-md-device-dots="false" data-doteach="false">
            <?php
            // Fetch recent projects
            $stmt_projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC LIMIT 6");
            if ($stmt_projects->rowCount() > 0) {
              while ($project = $stmt_projects->fetch()) {
                $project_img = "assets/images/case-study/Portfolio-1.jpg";
                if (!empty($project['image'])) {
                    $img = $project['image'];
                    if (strpos($img, 'assets/') !== false) {
                        $project_img = str_replace(['../../assets/', '/techzen/assets/', '\/techzen\/assets\/'], 'assets/', $img);
                    } else {
                        $project_img = "assets/images/project/" . $img;
                    }
                }
                ?>
                <div class="items">
                  <div class="rs-case-study__slider-item">
                    <img src="<?php echo htmlspecialchars($project_img); ?>"
                      alt="<?php echo htmlspecialchars($project['title']); ?>" />
                    <div class="rs-item-content">
                      <a href="project/<?php echo htmlspecialchars($project['slug']); ?>">
                        <h3 class="title"><?php echo htmlspecialchars($project['title']); ?></h3>
                        <span><?php echo htmlspecialchars($project['industry'] ?? 'Project'); ?></span>
                      </a>
                    </div>
                    <div class="rs-item-link">
                      <a href="project/<?php echo htmlspecialchars($project['slug']); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 18 18" fill="none">
                          <path
                            d="M15.0052 5.11205L2.11729 18L0 15.8827L12.8864 2.99476H1.52883V0H18V16.4712H15.0052V5.11205Z"
                            fill="#F26F20"></path>
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>
                <?php
              }
            } else {
              // Fallback content or empty
              echo '<div class="items"><p>No projects found.</p></div>';
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--======== Case Study Ends ========-->

<!--======== Testimonial Start ========-->
<section class="rs-testimonial pt-110 pb-120">
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
      data-autoplay="true" data-hoverpause="false" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="false"
      data-nav="true" data-nav-speed="false" data-center-mode="false" data-mobile-device="1"
      data-mobile-device-nav="true" data-mobile-device-dots="false" data-ipad-device="2" data-ipad-device-nav="true"
      data-ipad-device-dots="false" data-ipad-device2="2" data-ipad-device-nav2="true" data-ipad-device-dots2="false"
      data-md-device="2" data-lg-device="3" data-md-device-nav="true" data-md-device-dots="false" data-doteach="false">
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

<!-- Brand Section Removed -->

<!--======== FAQ Start ========-->
<section class="rs-faq pt-80 pb-120">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="rs-section-title text-center">
          <div class="top-sub-heading">
            <img src="assets/images/heart-pulse-rate-orange-2.svg" alt="icon" />
            <span style="color:#F26F20">FAQ</span>
            <img src="assets/images/heart-pulse-rate-orange.svg" alt="icon" />
          </div>
          <h2 class="title split-in-fade">Frequently Asked Questions</h2>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="rs-faq__wrapper">
          <?php
          try {
            $stmt_faq = $pdo->query("SELECT * FROM faqs ORDER BY display_order ASC, created_at DESC");
            $faq_count = 0;
            while ($faq = $stmt_faq->fetch()) {
              $faq_count++;
              $active_class = ($faq_count == 1) ? 'active' : '';
              $num = str_pad($faq_count, 2, '0', STR_PAD_LEFT);
              ?>
              <div class="accordion <?php echo $active_class; ?>">
                <div class="accordion_tab <?php echo $active_class; ?>">
                  <?php echo $num . ' ' . htmlspecialchars($faq['question']); ?>
                  <div class="accordion_arrow">
                    <i class="ri-add-fill"></i>
                  </div>
                </div>
                <div class="accordion_content">
                  <div class="accordion_item">
                    <p><?php echo nl2br(htmlspecialchars($faq['answer'])); ?></p>
                  </div>
                </div>
              </div>
            <?php
            }
          } catch (Exception $e) {
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!--======== FAQ Ends ========-->

<!--======== Newsletter Start ========-->
<section class="rs-newsletter pt-120">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="rs-newsletter__box">
          <div class="rs-newsletter__shape">
            <img src="assets/images/newsletter/curve-arrow.svg" alt="" />
          </div>
          <div class="rs-section-title">
            <div class="top-sub-heading">
              <img src="assets/images/heart-pulse-rate-white.svg" alt="icon" />
              <span>We carry more than just good coding skills</span>
            </div>
            <h2 class="title">Let's build your website!</h2>
          </div>
          <div class="rs-newsletter__btn">
            <a class="main-btn" href="contact">Contact Us <i class="ri-arrow-right-fill"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--======== Newsletter Ends ========-->

<!--======== Blog Start ========-->
<section id="rs-blog" class="rs-blog pb-120">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="rs-section-title black">
          <div class="top-sub-heading">
            <img src="assets/images/heart-pulse-rate-orange-2.svg" alt="icon" />
            <span>Recent Blogs</span>
            <img src="assets/images/heart-pulse-rate-orange.svg" alt="icon" />
          </div>
          <h2 class="title split-in-fade">
            Our insights on trends, Technologies and Transformation
          </h2>
        </div>
      </div>
    </div>
    <div class="row">
      <?php
      try {
        $stmt_home_blog = $pdo->query("SELECT b.*, c.name as category_name 
            FROM blog_posts b 
            LEFT JOIN blog_categories c ON b.category_id = c.id 
            WHERE b.status='published' 
            ORDER BY b.created_at DESC 
            LIMIT 3");

        if ($stmt_home_blog->rowCount() > 0) {
          while ($post = $stmt_home_blog->fetch()) {
            $img_src = !empty($post['image']) ? "assets/images/blog/" . $post['image'] : "assets/images/no-image.jpg";
            $author = !empty($post['author']) ? $post['author'] : 'Admin';
            $date = date('M d, Y', strtotime($post['created_at']));
            $cat_name = !empty($post['category_name']) ? $post['category_name'] : 'Uncategorized';
            $description = substr(strip_tags($post['content']), 0, 100) . '...';
            ?>
            <div class="col-lg-4">
              <div class="rs-blog__single">
                <div class="thumb">
                  <a href="blog/<?php echo $post['slug']; ?>">
                    <img src="<?php echo $img_src; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" />
                  </a>
                  <div class="rs-contact-icon">
                    <a href="blog/<?php echo $post['slug']; ?>"><svg width="14" height="16"
                        viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M3.70371 13.1768L7.90054e-06 14L0.823208 10.2963C0.28108 9.28226 -0.00172329 8.14985 7.90054e-06 7C7.90054e-06 3.1339 3.13391 0 7 0C10.8661 0 14 3.1339 14 7C14 10.8661 10.8661 14 7 14C5.85015 14.0017 4.71774 13.7189 3.70371 13.1768Z"
                          fill="white"></path>
                      </svg></a>
                  </div>
                </div>
                <div class="content">
                  <div class="rs-blog-category">
                    <a href="blog?category=<?php echo $post['category_id']; ?>">
                      <div class="icon"></div>
                      <?php echo htmlspecialchars($cat_name); ?>
                    </a>
                  </div>
                  <h3 class="title">
                    <a
                      href="blog/<?php echo $post['slug']; ?>"><?php echo htmlspecialchars($post['title']); ?></a>
                  </h3>
                  <ul>
                    <li><?php echo $date; ?></li>
                    <li>
                      <div class="rs-icon"></div>
                      By <?php echo htmlspecialchars($author); ?>
                    </li>
                  </ul>
                  <p>
                    <?php echo htmlspecialchars($description); ?>
                  </p>
                  <div class="rs-blog-author">
                    <div class="user">
                      <a href="#">
                        <div class="author-thumb">
                          <img src="assets/images/testimonial/samplepic.jpg" alt="" />
                        </div>
                        <span>by <?php echo htmlspecialchars($author); ?></span>
                      </a>
                    </div>
                    <div class="rs-link">
                      <a href="blog/<?php echo $post['slug']; ?>">Read Post <i
                          class="ri-arrow-right-fill"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php
          }
        } else {
          echo '<div class="col-12 text-center"><p>No blog posts found.</p></div>';
        }
      } catch (Exception $e) {
        echo '<div class="col-12 text-center"><p>No blog posts found.</p></div>';
      }
      ?>
    </div>
    <div class="rs-blog__btn">
      <a class="main-btn" href="blog">View All Blog <i class="ri-arrow-right-fill"></i></a>
    </div>
  </div>
</section>
<!--======== Blog Ends ========-->

<!--======== Contact Start ========-->
<section id="rs-contact" class="rs-contact pt-110 pb-100">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="rs-section-title black">
          <div class="top-sub-heading">
            <img src="assets/images/heart-pulse-rate-orange-2.svg" alt="icon" />
            <span>Contact Us</span>
            <img src="assets/images/heart-pulse-rate-orange.svg" alt="icon" />
          </div>
          <h2 class="title split-in-fade">Send message</h2>
        </div>
        <div class="rs-contact__form-box">
          <form id="contact-form" class="ajax-form" action="submit_contact.php" method="post">
            <div class="row">
              <div class="col-lg-6">
                <div class="input-box">
                  <input type="text" id="name" name="name" placeholder="Your Name" required />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="input-box">
                  <input type="email" id="email" name="email" placeholder="Your Email" required />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="input-box">
                  <input type="text" id="subject" name="subject" placeholder="Your Topic" required />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="input-box">
                  <input type="text" id="phone" name="phone" placeholder="Your Phone" />
                </div>
              </div>
              <div class="col-lg-12">
                <div class="input-box">
                  <textarea name="message" id="message" placeholder="Message..." required></textarea>
                  <div class="g-recaptcha" data-sitekey="YOUR_RECAPTCHA_SITE_KEY"></div>
                  <button type="submit" class="main-btn">
                    Send Message <i class="ri-arrow-right-fill"></i>
                  </button>
                </div>
              </div>
            </div>
          </form>
          <p id="form-messages" class="form-message"></p>
        </div>
      </div>
    </div>
  </div>
  <div class="rs-contact__thumb">
    <img src="assets/images/contact/contact-image.png" alt="" />
    <img class="item-2" src="assets/images/contact/contact-image02.png" alt="" />
  </div>
  <div class="rs-contact__shape1">
    <img src="assets/images/contact/circle-plus.svg" alt="" />
  </div>
  <div class="rs-contact__shape2">
    <img src="assets/images/contact/plane-with-tail.svg" alt="" />
  </div>
</section>
<!--======== Contact Ends ========-->

<?php include 'includes/footer.php'; ?>