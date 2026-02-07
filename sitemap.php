<?php 
$page_title = "Sitemap";
include 'includes/header.php'; 
?>

<!--======== Page Banner Start ========-->
<section class="rs-page-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-page-banner__content">
                    <h1 class="title">Sitemap</h1>
                    <ul>
                        <li><i class="ri-home-wifi-line"></i> <a href="index.php">Home</a></li>
                        <li><i class="ri-arrow-right-fill"></i> Sitemap</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Page Banner Ends ========-->

<!--======== Sitemap Content Start ========-->
<section class="rs-sitemap pt-120 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-sitemap-content text-center mb-50">
                    <h2 class="title wow fadeInUp" data-wow-delay="0.2s">Explore Our Website</h2>
                    <p class="desc wow fadeInUp" data-wow-delay="0.3s">Navigate through our pages to find what you are looking for.</p>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row">
                    <!-- Main Pages -->
                    <div class="col-md-4 mb-30 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="sitemap-card" style="background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border-top: 4px solid #007bff;">
                            <h4 class="mb-20"><i class="ri-pages-line text-primary"></i> Main Pages</h4>
                            <ul style="list-style: none; padding: 0;">
                                <li class="mb-10"><a href="index.php" style="color: #666; font-size: 16px;"><i class="ri-arrow-right-s-line text-primary"></i> Home</a></li>
                                <li class="mb-10"><a href="about.php" style="color: #666; font-size: 16px;"><i class="ri-arrow-right-s-line text-primary"></i> About Us</a></li>
                                <li class="mb-10"><a href="services.php" style="color: #666; font-size: 16px;"><i class="ri-arrow-right-s-line text-primary"></i> Services</a></li>
                                <li class="mb-10"><a href="projects.php" style="color: #666; font-size: 16px;"><i class="ri-arrow-right-s-line text-primary"></i> Projects</a></li>
                                <li class="mb-10"><a href="blog.php" style="color: #666; font-size: 16px;"><i class="ri-arrow-right-s-line text-primary"></i> Blog</a></li>
                                <li class="mb-10"><a href="contact.php" style="color: #666; font-size: 16px;"><i class="ri-arrow-right-s-line text-primary"></i> Contact</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="col-md-4 mb-30 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="sitemap-card" style="background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border-top: 4px solid #28a745;">
                            <h4 class="mb-20"><i class="ri-service-line text-success"></i> Our Services</h4>
                            <ul style="list-style: none; padding: 0;">
                                <?php
                                $stmt_s = $pdo->query("SELECT title, slug FROM services ORDER BY display_order ASC LIMIT 6");
                                while($s = $stmt_s->fetch()){
                                    $link = "service-details.php?slug=" . $s['slug'];
                                    echo '<li class="mb-10"><a href="'.$link.'" style="color: #666; font-size: 16px;"><i class="ri-arrow-right-s-line text-success"></i> '.htmlspecialchars($s['title']).'</a></li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Legal & Others -->
                    <div class="col-md-4 mb-30 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="sitemap-card" style="background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border-top: 4px solid #ffc107;">
                            <h4 class="mb-20"><i class="ri-shield-line text-warning"></i> Legal & Help</h4>
                            <ul style="list-style: none; padding: 0;">
                                <li class="mb-10"><a href="privacy.php" style="color: #666; font-size: 16px;"><i class="ri-arrow-right-s-line text-warning"></i> Privacy Policy</a></li>
                                <li class="mb-10"><a href="terms.php" style="color: #666; font-size: 16px;"><i class="ri-arrow-right-s-line text-warning"></i> Terms & Conditions</a></li>
                                <li class="mb-10"><a href="disclaimer.php" style="color: #666; font-size: 16px;"><i class="ri-arrow-right-s-line text-warning"></i> Disclaimer</a></li>
                                <li class="mb-10"><a href="appointment.php" style="color: #666; font-size: 16px;"><i class="ri-arrow-right-s-line text-warning"></i> Appointment</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Sitemap Content Ends ========-->

<?php include 'includes/footer.php'; ?>
