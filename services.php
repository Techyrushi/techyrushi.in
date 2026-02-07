<?php include 'includes/header.php'; ?>

<!--======== Services Page Banner Start ========-->
<section class="rs-page-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-page-banner__content">
                    <h1 class="title">Services</h1>
                    <ul>
                        <li><i class="ri-home-wifi-line"></i> <a href="index">Home</a></li>
                        <li><i class="ri-arrow-right-fill"></i> Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Services Page Banner Ends ========-->

<!--======== Services List Start ========-->
<section class="rs-featured-2 rs-services-page pt-120 pb-120">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="rs-section-title black text-center">
                    <div class="top-sub-heading">
                        <img src="assets/images/heart-pulse-rate-orange-2.svg" alt="icon">
                        <span>Our Services</span>
                        <img src="assets/images/heart-pulse-rate-orange.svg" alt="icon">
                    </div>
                    <h2 class="title split-in-fade">We run all kinds of IT services</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php
            include_once 'includes/db.php';
            // Fetch ALL services for the services page
            $stmt = $pdo->query("SELECT * FROM services ORDER BY display_order ASC, created_at DESC");
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch()) {
                    $img_src = !empty($row['image']) ? "assets/images/service/" . $row['image'] : "assets/images/featured/featured-thumb-4.png";
                    // Fallback for icon if not set
                    $icon_class = !empty($row['icon']) ? $row['icon'] : "flaticon-web";
                    ?>
                    <div class="col-lg-4 col-sm-6 mb-30">
                        <div class="rs-featured-2__item">
                            <div class="rs-thumb">
                                <img src="<?php echo $img_src; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                            </div>
                            <div class="rs-content">
                                <div class="rs-icon">
                                    <img src="assets/images/service/<?php echo $icon_class; ?>" alt="icon">
                                </div>
                                <h4 class="title"><a
                                        href="service/<?php echo $row['slug']; ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                                </h4>
                                <p><?php echo htmlspecialchars(substr(strip_tags($row['short_description']), 0, 100)) . '...'; ?>
                                </p>
                                <div class="rs-link">
                                    <a class="rs-link" href="service/<?php echo $row['slug']; ?>">Read More <i
                                            class="ri-arrow-right-fill"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-12 text-center"><p>No services found.</p></div>';
            }
            ?>
        </div>
    </div>
</section>
<!--======== Services List Ends ========-->

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

<?php include 'includes/footer.php'; ?>