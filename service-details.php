<?php 
include 'includes/db.php';
include 'includes/header.php'; 

if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $stmt = $pdo->prepare("SELECT * FROM services WHERE slug = ?");
    $stmt->execute([$slug]);
    $service = $stmt->fetch();

    if (!$service) {
        echo "<script>window.location.href='services.php';</script>";
        exit();
    }
    
    // Increment views
    $pdo->prepare("UPDATE services SET views = views + 1 WHERE id = ?")->execute([$service['id']]);
} else {
    echo "<script>window.location.href='services.php';</script>";
    exit();
}
?>

<!--======== Service Details Page Banner 3 Start ========-->
<section class="rs-page-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-page-banner__content">
                    <h1 class="title"><?php echo htmlspecialchars($service['title']); ?></h1>
                    <ul>
                        <li><i class="ri-home-wifi-line"></i> <a href="index">Home</a></li>
                        <li><i class="ri-arrow-right-fill"></i> <a href="services">Services</a></li>
                        <li><i class="ri-arrow-right-fill"></i> <?php echo htmlspecialchars($service['title']); ?></li>
                        <li><i class="ri-eye-line" style="margin-left: 15px;"></i> <?php echo $service['views'] ?? 0; ?> Views</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Service Details Page Banner 3 Ends ========-->

<!--======== Service Details 3 Start ========-->
<section class="rs-service-details rs-service-details-3 pt-120 pb-95">
    <div class="container">
        <div class="row column-reverse">
            <div class="col-lg-4">
                <div class="rs-service-details__sidebar">
                    <div class="category-box sidebar-common">
                        <div class="sidebar-top-title">
                            <h3 class="title">Our Services</h3>
                        </div>
                        <ul>
                            <?php
                            $stmt_services = $pdo->query("SELECT title, slug FROM services ORDER BY title ASC");
                            while ($row_service = $stmt_services->fetch()) {
                                $active_class = ($row_service['slug'] == $slug) ? 'active' : '';
                                echo '<li><a href="service/' . $row_service['slug'] . '" class="' . $active_class . '"><span>' . htmlspecialchars($row_service['title']) . '</span> <i class="ri-arrow-right-fill"></i></a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="solution-box sidebar-common mt-40">
                        <h4 class="title">Need Custom IT Solutions?</h4>
                        <a class="main-btn" href="contact">Get a Quote <i class="ri-arrow-right-fill"></i></a>
                    </div>
                    <div class="download-box sidebar-common mt-40">
                        <div class="sidebar-top-title">
                            <h3 class="title">Download Brochure</h3>
                        </div>
                        <ul>
                            <?php if (!empty($service['brochure'])): ?>
                                <li><a href="assets/files/service/<?php echo $service['brochure']; ?>" download class="active"><span>Download PDF</span> <i class="ri-download-cloud-2-fill"></i></a></li>
                            <?php else: ?>
                                <li><a href="#" style="opacity: 0.5; cursor: not-allowed;"><span>No Brochure Available</span> <i class="ri-close-circle-line"></i></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="rs-service-details__content">
                    <div class="rs-thumb">
                        <?php if (!empty($service['image'])): ?>
                            <img src="assets/images/service/<?php echo htmlspecialchars($service['image']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>" class="img-fluid w-100">
                        <?php else: ?>
                            <img src="assets/images/service/service-details-thumb-2.jpg" alt="<?php echo htmlspecialchars($service['title']); ?>" class="img-fluid w-100">
                        <?php endif; ?>
                    </div>
                    <div class="rs-content">
                        <h3 class="title"><?php echo htmlspecialchars($service['title']); ?></h3>
                        
                        <?php 
                        $content = $service['content'];
                        // Fix image paths for frontend display
                        $content = str_replace('../../assets/images/uploads/', 'assets/images/uploads/', $content);
                        $content = str_replace('/techzen/assets/images/uploads/', 'assets/images/uploads/', $content);
                        $content = str_replace('\\/techzen\\/assets\\/images\\/uploads\\/', 'assets/images/uploads/', $content);
                        echo $content; 
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Service Details 3 Ends ========-->

<?php include 'includes/footer.php'; ?>