<?php include 'includes/header.php'; ?>

<!--======== Project Page Banner Start ========-->
<section class="rs-page-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-page-banner__content">
                    <h1 class="title">Our Project</h1>
                    <ul>
                        <li><i class="ri-home-wifi-line"></i> <a href="#">Home</a></li>
                        <li><i class="ri-arrow-right-fill"></i> Our Project</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Project Page Banner Ends ========-->

<!--======== Project Grid Start ========-->
<div id="rs-portfolios" class="rs-project-3 rs-project-grid pt-115">
    <div class="rs-project-3__slider">
        <div class="container">
            <div class="row">
                <?php
                // Remove redundant include since header.php already includes db.php
                // include 'includes/db.php'; 
                
                try {
                    $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch()) {
                            $img_src = !empty($row['image']) ? "assets/images/project/" . $row['image'] : "assets/images/project/portfolio-item-1.jpg";
                            ?>
                            <div class="col-lg-4 col-md-6 mb-30">
                                <div class="rs-project-3__item">
                                    <div class="rs-thumb">
                                        <img src="<?php echo $img_src; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                    </div>
                                    <div class="rs-project-overlay">
                                        <div class="rs-project-content">
                                            <div class="rs-title">
                                                <a href="project/<?php echo $row['slug']; ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                                            </div>
                                            <div class="rs-category">
                                                <span><i class="ri-price-tag-3-line"></i><a href="#"><?php echo htmlspecialchars($row['industry'] ?? 'Project'); ?></a></span>
                                            </div>
                                            <div class="rs-text">
                                                <p><?php echo htmlspecialchars(substr(strip_tags($row['description']), 0, 100)) . '...'; ?></p>
                                            </div>
                                        </div>
                                        <div class="rs-link">
                                            <a href="project/<?php echo $row['slug']; ?>"><i class="ri-arrow-right-up-line"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div class="col-12 text-center"><p>No projects found.</p></div>';
                    }
                } catch (Exception $e) {
                    echo '<div class="col-12 text-center text-danger"><p>Error loading projects: ' . $e->getMessage() . '</p></div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!--======== Project Grid Ends ========-->

<!--======== Project Cta Start ========-->
<section class="rs-project-cta pt-80 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-project-cta__content">
                    <h2 class="title">Do you have similar development requirements?</h2>
                    <p>We deliver high-quality, scalable solutions tailored to your business needs. Let's discuss how we can bring your vision to life.</p>
                    <a class="main-btn mt-40" href="contact">Contact With Us <i
                            class="ri-arrow-right-fill"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="rs-thumb">
        <img src="assets/images/project/call_to_action_man.png" alt="">
    </div>
</section>
<!--======== Project Cta Ends ========-->

<?php include 'includes/footer.php'; ?>