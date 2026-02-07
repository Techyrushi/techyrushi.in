<?php 
require_once 'includes/db.php';

$project = null;
$next_project = null;
$prev_project = null;

try {
    if (isset($_GET['slug']) && !empty($_GET['slug'])) {
        $slug = $_GET['slug'];
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE slug = ?");
        $stmt->execute([$slug]);
        $project = $stmt->fetch();

        if (!$project) {
            header("Location: project.php");
            exit();
        }
        
        // Set SEO data for header
        $page_title = $project['title'];
        $meta_description = substr(strip_tags($project['description']), 0, 160);
        
        // Increment views
        $pdo->prepare("UPDATE projects SET views = views + 1 WHERE id = ?")->execute([$project['id']]);
        
    } else {
        header("Location: project.php");
        exit();
    }

    // Fetch Next and Prev projects
    $stmt_next = $pdo->prepare("SELECT slug FROM projects WHERE id > ? ORDER BY id ASC LIMIT 1");
    $stmt_next->execute([$project['id']]);
    $next_project = $stmt_next->fetch();

    $stmt_prev = $pdo->prepare("SELECT slug FROM projects WHERE id < ? ORDER BY id DESC LIMIT 1");
    $stmt_prev->execute([$project['id']]);
    $prev_project = $stmt_prev->fetch();
    
} catch (Exception $e) {
    // If error occurs before header, we can just exit or show simple error
    die("Error: " . $e->getMessage());
}

include 'includes/header.php'; 
?>
<!--======== Project Details Page Banner Start ========-->
<section class="rs-page-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-page-banner__content">
                    <h1 class="title"><?php echo htmlspecialchars($project['title']); ?></h1>
                    <ul>
                        <li><i class="ri-home-wifi-line"></i> <a href="index">Home</a></li>
                        <li><i class="ri-arrow-right-fill"></i> <a href="project">Projects</a></li>
                        <li><i class="ri-arrow-right-fill"></i> <?php echo htmlspecialchars($project['title']); ?></li>
                        <li><i class="ri-eye-line" style="margin-left: 15px;"></i> <?php echo $project['views'] ?? 0; ?> Views</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Project Details Page Banner Ends ========-->

<!--======== Project Details Start ========-->
<section class="rs-project-details pt-90 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="rs-project-details__content mt-30 ">
                    <div class="rs-thumb">
                        <?php if (!empty($project['image'])): ?>
                            <img src="assets/images/project/<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="img-fluid w-100">
                        <?php else: ?>
                            <img src="assets/images/project/project-details-thumb.jpg" alt="" class="img-fluid w-100">
                        <?php endif; ?>
                    </div>
                    <div class="rs-project-content">
                        <h2 class="title"><?php echo htmlspecialchars($project['title']); ?></h2>
                        
                        <div class="project-description">
                            <?php 
                            $content = $project['description'];
                            // Fix image paths for frontend display
                            $content = str_replace('../../assets/images/uploads/', 'assets/images/uploads/', $content);
                            $content = str_replace('/techzen/assets/images/uploads/', 'assets/images/uploads/', $content);
                            $content = str_replace('\\/techzen\\/assets\\/images\\/uploads\\/', 'assets/images/uploads/', $content);
                            echo $content; 
                            ?>
                        </div>

                        <?php
                        // Fetch Gallery Images
                        $stmt_gal = $pdo->prepare("SELECT * FROM project_images WHERE project_id = ? ORDER BY id ASC");
                        $stmt_gal->execute([$project['id']]);
                        $gallery_images = $stmt_gal->fetchAll();
                        
                        if (count($gallery_images) > 0): 
                        ?>
                        <div class="project-gallery mt-50">
                            <h3 class="title mb-30">Project Gallery</h3>
                            <div class="row">
                                <?php foreach ($gallery_images as $img): ?>
                                <div class="col-md-6 mb-30">
                                    <div class="gallery-item">
                                        <img src="assets/images/project/gallery/<?php echo $img['image_path']; ?>" alt="Project Image" class="img-fluid w-100" style="border-radius: 5px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="rs-project-bar mt-50">
                            <div class="rs-social">
                                <ul>
                                    <li>
                                        <a href="https://www.facebook.com/people/Techyrushitalks/61587126144718/" target="_blank"><i class="ri-facebook-fill"></i></a>
                                    </li>
                                    <!-- <li>
                                        <a href="https://twitter.com/techyrushi" target="_blank"><i class="ri-twitter-x-fill"></i></a>
                                    </li> -->
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
                            <div class="rs-project-switch-btn">
                                <ul>
                                    <?php if ($prev_project): ?>
                                    <li><a class="main-btn" href="project/<?php echo $prev_project['slug']; ?>"><i class="ri-arrow-left-fill"></i> Prev Post</a></li>
                                    <?php endif; ?>
                                    
                                    <?php if ($next_project): ?>
                                    <li><a class="main-btn" href="project/<?php echo $next_project['slug']; ?>">Next Post <i class="ri-arrow-right-fill"></i></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="rs-project-details__sidebar mt-30">
                    <div class="project-sidebar-category">
                        <h4 class="title">Project Information</h4>
                        <div class="sidebar-category-box">
                            <div class="sidebar-category-item">
                                <div class="rs-icon">
                                    <img src="assets/images/project/project-sidebar-icon-1.png" alt="">
                                </div>
                                <div class="rs-content">
                                    <h5>Client</h5>
                                    <span><?php echo htmlspecialchars($project['client_name'] ?? 'N/A'); ?></span>
                                </div>
                            </div>
                            <div class="sidebar-category-item">
                                <div class="rs-icon">
                                    <img src="assets/images/project/project-sidebar-icon-2.png" alt="">
                                </div>
                                <div class="rs-content">
                                    <h5>Country</h5>
                                    <span><?php echo htmlspecialchars($project['country'] ?? 'N/A'); ?></span>
                                </div>
                            </div>
                            <div class="sidebar-category-item">
                                <div class="rs-icon">
                                    <img src="assets/images/project/project-sidebar-icon-3.png" alt="">
                                </div>
                                <div class="rs-content">
                                    <h5>Core technologies</h5>
                                    <span><?php echo htmlspecialchars($project['core_technologies'] ?? 'N/A'); ?></span>
                                </div>
                            </div>
                            <div class="sidebar-category-item">
                                <div class="rs-icon">
                                    <img src="assets/images/project/project-sidebar-icon-4.png" alt="">
                                </div>
                                <div class="rs-content">
                                    <h5>Industry</h5>
                                    <span><?php echo htmlspecialchars($project['industry'] ?? 'N/A'); ?></span>
                                </div>
                            </div>
                            <div class="sidebar-category-item">
                                <div class="rs-icon">
                                    <img src="assets/images/project/project-sidebar-icon-5.png" alt="">
                                </div>
                                <div class="rs-content">
                                    <h5>Date</h5>
                                    <span><?php echo date('F jS, Y', strtotime($project['project_date'])); ?></span>
                                </div>
                            </div>
                            <div class="sidebar-category-item">
                                <div class="rs-icon">
                                    <img src="assets/images/project/project-sidebar-icon-6.png" alt="">
                                </div>
                                <div class="rs-content">
                                    <h5>Cost</h5>
                                    <span><?php echo htmlspecialchars($project['cost'] ?? 'N/A'); ?></span>
                                </div>
                            </div>
                            
                            <?php if (!empty($project['brochure'])): ?>
                            <div class="sidebar-category-item" style="border-bottom: none;">
                                <div class="rs-content" style="width: 100%; padding-left: 0;">
                                    <h5 class="mb-3">Project Brochure</h5>
                                    <a href="assets/files/project/<?php echo $project['brochure']; ?>" class="btn btn-primary w-100" download style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                        <i class="ri-file-download-line"></i> Download PDF
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="sidebar-category-contact mt-40">
                        <h4 class="title">Get Professional Help</h4>
                        <span>Contact Us</span>
                        <img src="assets/images/project/phone-white.png" alt="">
                        <div class="rs-link">
                            <a href="tel:+918446225859">(+91) 8446225859</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Project Details Ends ========-->

<!--======== Project Details Cta Start ========-->
<section class="rs-project-cta rs-project-details-cta mb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-project-cta-box pt-80 pb-90">
                    <div class="rs-project-cta__content">
                        <h2 class="title">Do you have similar development requirements?</h2>
                        <p> Collaboratively administrate empowered markets via plug-and-play networks dynamically
                            procrastinate</p>
                        <a class="main-btn" href="contact">Contact With Us <i class="ri-arrow-right-fill"></i></a>
                    </div>
                    <div class="rs-thumb">
                        <img src="assets/images/project/call_to_action_man.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Project Details Cta Ends ========-->

<?php include 'includes/footer.php'; ?>