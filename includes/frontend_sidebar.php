<div class="rs-blog-standard-page__sidebar mt-40">
    <!-- Search Removed -->
    
    <div class="rs-blog-category rs-blog-common mt-40">
        <h4 class="rs-sidebar-title">Categories</h4>
        <ul>
            <?php
            $stmt_cat = $pdo->query("SELECT * FROM blog_categories");
            while ($cat = $stmt_cat->fetch()) {
                echo '<li><a href="blog.php?category=' . $cat['id'] . '">' . htmlspecialchars($cat['name']) . ' <i class="ri-arrow-right-fill"></i></a></li>';
            }
            ?>
        </ul>
    </div>
    <div class="rs-blog-sidebar-post rs-blog-common mt-40">
        <h4 class="rs-sidebar-title">Recent Posts</h4>
        <?php
        $stmt_recent = $pdo->query("SELECT * FROM blog_posts WHERE status='published' ORDER BY created_at DESC LIMIT 5");
        while ($recent = $stmt_recent->fetch()) {
            $img = !empty($recent['thumbnail']) ? "assets/images/blog/" . $recent['thumbnail'] : "assets/images/no-image.jpg";
            echo '<div class="rs-blog-sidebar-item mb-25">
                    <div class="rs-thumb">
                        <a href="blog/' . $recent['slug'] . '"><img src="' . $img . '" alt=""></a>
                    </div>
                    <div class="rs-content">
                        <h5 class="title"><a href="blog/' . $recent['slug'] . '">' . htmlspecialchars($recent['title']) . '</a></h5>
                        <span><i class="ri-calendar-line"></i> ' . date('F d, Y', strtotime($recent['created_at'])) . ' </span>
                    </div>
                </div>';
        }
        ?>
    </div>
</div>

<script>
// Search Removed
</script>