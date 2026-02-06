<?php
require_once 'includes/db.php';
require_once 'includes/track_visit.php';
$current_page = basename($_SERVER['PHP_SELF'], ".php");
$extra_header_class = ($current_page !== 'index' && $current_page !== '') ? ' other-page-header' : '';

// SEO Logic
if (!isset($page_title)) {
    // Determine route name for DB lookup
    $route = $current_page;
    if ($route == '') $route = 'index';
    
    $stmt_seo = $pdo->prepare("SELECT * FROM seo_metadata WHERE route = ?");
    $stmt_seo->execute([$route]);
    $seo = $stmt_seo->fetch();
    
    if ($seo) {
        $page_title = $seo['page_title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
    }
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <base href="/techzen/">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' - Techyrushi' : 'Techyrushi - IT Solutions & Technology'; ?></title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="<?php echo isset($meta_description) ? htmlspecialchars($meta_description) : ''; ?>" />
    <meta name="keywords" content="<?php echo isset($meta_keywords) ? htmlspecialchars($meta_keywords) : ''; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

    <!-- CSS (Font, Vendor, Icon, Plugins & Style CSS files) -->

    <!-- Font CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Flow+Circular&amp;family=Urbanist:ital,wght@0,100..900;1,100..900&amp;display=swap"
        rel="stylesheet" />

    <!-- Bootstrap & Icon Font -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

    <!-- Animation CSS -->
    <link rel="stylesheet" href="assets/css/animation.css" />

    <!-- jquery UI CSS -->
    <link rel="stylesheet" href="assets/css/jquery-ui.css" />

    <!-- awesome Icon Font -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" />

    <!-- remixicon Icon Font -->
    <link rel="stylesheet" href="assets/css/remixicon.css" />

    <!-- Slick Slider CSS  -->
    <link rel="stylesheet" href="assets/css/slick.css" />

    <!-- owl carousel CSS  -->
    <link rel="stylesheet" href="assets/css/owl.carousel.css" />

    <!-- flickity CSS  -->
    <link rel="stylesheet" href="assets/css/flickity.css" />

    <!-- odometer CSS  -->
    <link rel="stylesheet" href="assets/css/odometer.min.css" />

    <!-- skeletabs CSS  -->
    <link rel="stylesheet" href="assets/css/skeletabs.css" />

    <!-- magnific popup CSS -->
    <link rel="stylesheet" href="assets/css/magnific-popup.css" />

    <!-- layout CSS -->
    <link rel="stylesheet" href="assets/css/rs-layouts.css" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body class="home-page-1">
    <!--======== Header start ========-->
    <div class="full-width-header">
        <!--Header Start-->
        <header id="rs-header" class="rs-header<?php echo $extra_header_class; ?>">
            <!-- Menu Start -->
            <div class="menu-area menu-sticky">
                <!-- Offer Section End -->
                <div class="container custom-container">
                    <div class="rs-menu-area">
                        <div class="logo-area">
                            <a href="index">
                                <img src="assets/images/techyrushi.png" alt="" />
                                <img class="dark-logo" src="assets/images/footer_logo.png" alt="" />
                            </a>
                            <a href="index">
                                <img src="assets/images/techyrushi.png" alt="" />   
                                <img class="dark-logo" src="assets/images/footer_logo.png" alt="" />
                            </a>
                        </div>
                        <div class="rs-header-rightside">
                            <div class="main-menu hidden-md">
                                <ul class="nav-menu">
                                    <li>
                                        <a href="index" <?php echo ($current_page == 'index' || $current_page == '') ? 'class="active"' : ''; ?>>
                                            <cite class="rs_item_wrap"> Home </cite>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="about" <?php echo ($current_page == 'about') ? 'class="active"' : ''; ?>>About</a>
                                    </li>
                                    <li class="has-clid relative">
                                        <a href="services" <?php echo ($current_page == 'services' || $current_page == 'service-details') ? 'class="active"' : ''; ?>>
                                            <cite class="rs_item_wrap"> Services </cite>
                                        </a>
                                        <ul class="sub-menu">
                                            <?php
                                            try {
                                                $stmt_services = $pdo->query("SELECT title, slug FROM services ORDER BY title ASC");
                                                while ($service = $stmt_services->fetch()) {
                                                    echo '<li><a href="service/' . $service['slug'] . '">' . htmlspecialchars($service['title']) . '</a></li>';
                                                }
                                            } catch (Exception $e) {
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="project" <?php echo ($current_page == 'project') ? 'class="active"' : ''; ?>>
                                            <cite class="rs_item_wrap"> Projects </cite>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="blog" <?php echo ($current_page == 'blog') ? 'class="active"' : ''; ?>>
                                            <cite class="rs_item_wrap"> Blog </cite>
                                        </a>
                                    </li>
                                    <li><a href="contact" <?php echo ($current_page == 'contact') ? 'class="active"' : ''; ?>>Contact</a></li>
                                </ul>
                                <!-- //.nav-menu -->
                            </div>
                            <!-- //.main-menu -->
                            <div class="rs-header-contct">
                                <a href="tel:+918446225859">
                                    <img src="assets/images/phone-call1.svg" alt="" /> (+91) 8446225859</a>
                            </div>

                            <div class="header-btn">
                                <a class="main-btn" href="contact">Get a Quote
                                    <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                        height="24">
                                        <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                    </svg></a>
                            </div>
                            <div class="canvasmenu-trigger view-md">
                                <i class="fa fa-bars"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Menu End -->
        </header>
        <!--Header End-->
    </div>
    <!--======== Header Ends ========-->

    <!--======== Offcanvas Menu start ========-->
    <div class="offcanvas-menu">
        <div class="menu-canvas-close">
            <i class="fa fa-times" aria-hidden="true"></i>
        </div>
        <div class="offcanvas-menu-inner">
            <div class="offc-logo mb-40">
                <a href="index"><img src="assets/images/techyrushi.png" alt="Logo" /></a>
            </div>
            <ul class="nav-menu">
                <li>
                    <a href="index">Home</a>
                </li>
                <li><a href="about">About</a></li>
                <li class="has-clid relative">
                    <a href="services.php">Services</a>
                    <ul class="sub-menu">
                        <?php
                        try {
                            $stmt_services = $pdo->query("SELECT title, slug FROM services ORDER BY title ASC");
                            while ($service = $stmt_services->fetch()) {
                                echo '<li><a href="service/' . $service['slug'] . '">' . htmlspecialchars($service['title']) . '</a></li>';
                            }
                        } catch (Exception $e) {
                        }
                        ?>
                    </ul>
                </li>
                <li>
                    <a href="project">Projects</a>
                </li>
                <li>
                    <a href="blog">Blog</a>
                </li>
                <li><a href="contact">Contact</a></li>
            </ul>
            <!-- //.nav-menu -->
        </div>
    </div>
    <!--======== Offcanvas Menu Ends ========-->

    <!--======== Preloader area start ========-->
    <div id="pre-load">
        <div id="loader" class="loader">
            <div class="loader-container">
                <div class="loader-icon">
                    <img src="assets/images/favicon.png" alt="" />
                </div>
            </div>
        </div>
    </div>
    <!--======== Preloader area Ends ========-->
