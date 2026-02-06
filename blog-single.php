<?php 
include 'includes/db.php';
include 'includes/header.php'; 

if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    // Fetch post with category
    $stmt = $pdo->prepare("SELECT b.*, c.name as category_name, c.id as category_id 
                           FROM blog_posts b 
                           LEFT JOIN blog_categories c ON b.category_id = c.id 
                           WHERE b.slug = ? AND b.status = 'published'");
    $stmt->execute([$slug]);
    $post = $stmt->fetch();

    if (!$post) {
        // Redirect if not found
        echo "<script>window.location.href='blog.php';</script>";
        exit();
    }
    
    // Increment views
    $stmt_view = $pdo->prepare("UPDATE blog_posts SET views = views + 1 WHERE id = ?");
    $stmt_view->execute([$post['id']]);
    
} else {
    echo "<script>window.location.href='blog.php';</script>";
    exit();
}

$img = !empty($post['thumbnail']) ? "assets/images/blog/" . $post['thumbnail'] : "assets/images/no-image.jpg";
$date = date('F d, Y', strtotime($post['created_at']));
$author = !empty($post['author']) ? $post['author'] : 'Admin';
$category = !empty($post['category_name']) ? $post['category_name'] : 'Uncategorized';
?>

<!--======== Page Banner Start ========-->
<section class="rs-page-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-page-banner__content">
                    <h1 class="title"><?php echo htmlspecialchars($post['title']); ?></h1>
                    <ul>
                        <li><i class="ri-home-wifi-line"></i> <a href="index.php">Home</a></li>
                        <li><i class="ri-arrow-right-fill"></i> <a href="blog.php">Blog</a></li>
                        <li><i class="ri-arrow-right-fill"></i> Details</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Page Banner Ends ========-->

<!--======== Blog Details Page Start ========-->
<section class="rs-blog-standard-page pt-120 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="rs-blog-standard-item rs-blog-details-content mt-40">
                    <div class="rs-thumb">
                        <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                    </div>
                    <div class="rs-meta-box">
                        <ul>
                            <li><i class="ri-user-3-line"></i> <?php echo htmlspecialchars($author); ?></li>
                            <li><i class="ri-calendar-line"></i> <?php echo $date; ?></li>
                            <li><a href="blog.php?category=<?php echo $post['category_id']; ?>"><i class="ri-price-tag-3-line"></i> <?php echo htmlspecialchars($category); ?></a></li>
                            <li><i class="ri-eye-line"></i> <?php echo $post['views'] ?? 0; ?> Views</li>
                        </ul>
                    </div>
                    
                    <div class="rs-content">
                        <h2 class="title"><?php echo htmlspecialchars($post['title']); ?></h2>
                        
                        <?php if (!empty($post['video_url'])): ?>
                        <div class="rs-video-wrap mb-40" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; border-radius: 10px;">
                            <?php
                            $video_url = $post['video_url'];
                            $embed_url = '';
                            if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
                                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $matches);
                                if (isset($matches[1])) {
                                    $embed_url = "https://www.youtube.com/embed/" . $matches[1];
                                }
                            } elseif (strpos($video_url, 'vimeo.com') !== false) {
                                preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches);
                                if (isset($matches[1])) {
                                    $embed_url = "https://player.vimeo.com/video/" . $matches[1];
                                }
                            }
                            
                            if ($embed_url) {
                                echo '<iframe src="' . $embed_url . '" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" allowfullscreen></iframe>';
                            }
                            ?>
                        </div>
                        <?php endif; ?>

                        <div class="blog-desc">
                            <?php echo $post['content']; ?>
                        </div>

                        <?php if (!empty($post['attachment'])): ?>
                        <div class="rs-attachment mt-30 p-3" style="background: #f9f9f9; border-left: 4px solid #007bff; border-radius: 4px;">
                            <h5 class="mb-2"><i class="ri-file-download-line"></i> Download Attachment</h5>
                            <a href="assets/files/blog/<?php echo $post['attachment']; ?>" class="btn btn-primary btn-sm" download>
                                Download File <i class="ri-download-line"></i>
                            </a>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($post['tags'])): ?>
                        <div class="rs-tags mt-30">
                            <h4 class="title" style="font-size: 18px; display: inline-block; margin-right: 10px;">Tags:</h4>
                            <ul style="display: inline-block; padding: 0;">
                                <?php 
                                $tags = explode(',', $post['tags']);
                                foreach ($tags as $tag) {
                                    $tag = trim($tag);
                                    if(!empty($tag)) {
                                        echo '<li style="display: inline-block; margin-right: 5px;"><a href="#" class="badge bg-primary text-white" style="padding: 5px 10px; font-weight: normal;">' . htmlspecialchars($tag) . '</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <?php include 'includes/frontend_sidebar.php'; ?>
            </div>
        </div>
    </div>
</section>
<!--======== Blog Details Page Ends ========-->

<?php include 'includes/footer.php'; ?>