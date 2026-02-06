<?php
include 'includes/db.php';
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
                        <li><i class="ri-home-wifi-line"></i> <a href="index">Home</a></li>
                        <li><i class="ri-arrow-right-fill"></i> Sitemap</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Page Banner Ends ========-->

<!--======== Content Start ========-->
<section class="pt-120 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-sitemap-list">
                    <h3>Pages</h3>
                    <ul class="sitemap-ul">
                        <li><a href="index">Home</a></li>
                        <li><a href="about">About Us</a></li>
                        <li><a href="services.php">Services</a>
                            <ul>
                                <?php
                                $stmt_s = $pdo->query("SELECT title, slug FROM services ORDER BY title ASC");
                                while ($s = $stmt_s->fetch()) {
                                    echo '<li><a href="service-details.php?slug=' . $s['slug'] . '">' . htmlspecialchars($s['title']) . '</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                        <li><a href="project">Projects</a>
                            <ul>
                                <?php
                                $stmt_p = $pdo->query("SELECT title, slug FROM projects ORDER BY title ASC");
                                while ($p = $stmt_p->fetch()) {
                                    echo '<li><a href="project-details.php?slug=' . $p['slug'] . '">' . htmlspecialchars($p['title']) . '</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                        <li><a href="blog">Blog</a></li>
                        <li><a href="contact">Contact Us</a></li>
                        <li><a href="privacy.php">Privacy Policy</a></li>
                        <li><a href="disclaimer.php">Disclaimer</a></li>
                        <li><a href="terms.php">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.rs-sitemap-list ul.sitemap-ul {
    list-style: none;
    padding-left: 0;
}
.rs-sitemap-list ul.sitemap-ul li {
    margin-bottom: 10px;
    font-size: 18px;
}
.rs-sitemap-list ul.sitemap-ul li a {
    color: #0a0a0a;
    text-decoration: none;
    transition: all 0.3s ease;
}
.rs-sitemap-list ul.sitemap-ul li a:hover {
    color: #F24E1A;
}
.rs-sitemap-list ul.sitemap-ul ul {
    list-style: disc;
    padding-left: 30px;
    margin-top: 10px;
    margin-bottom: 10px;
}
.rs-sitemap-list ul.sitemap-ul ul li {
    font-size: 16px;
    margin-bottom: 5px;
}
</style>
<!--======== Content Ends ========-->

<?php include 'includes/footer.php'; ?>
