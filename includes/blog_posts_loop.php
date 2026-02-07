<?php
if (!empty($posts)) {
    foreach ($posts as $row) {
        $img = !empty($row['image']) ? "assets/images/blog/" . $row['image'] : "assets/images/no-image.jpg";    
        $date = date('F d, Y', strtotime($row['created_at']));
        $author = !empty($row['author']) ? $row['author'] : 'Admin';
        $category = !empty($row['category_name']) ? $row['category_name'] : 'Uncategorized';
        $slug = $row['slug'];
?>
<div class="rs-blog-standard-item mb-50">
    <div class="rs-thumb">
        <a href="blog/<?php echo $slug; ?>">
            <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
        </a>
        <div class="rs-meta-box">
            <ul>
                <li><i class="ri-user-3-line"></i> <?php echo htmlspecialchars($author); ?></li>
                <li><i class="ri-calendar-line"></i> <?php echo $date; ?></li>
                <li><a href="blog.php?category=<?php echo $row['category_id']; ?>"><i class="ri-price-tag-3-line"></i> <?php echo htmlspecialchars($category); ?></a></li>
            </ul>
        </div>
    </div>
    <div class="rs-content">
        <h2 class="title"><a href="blog/<?php echo $slug; ?>"><?php echo htmlspecialchars($row['title']); ?></a></h2>
        <p><?php echo htmlspecialchars(substr(strip_tags($row['content']), 0, 150)) . '...'; ?></p>
        <div class="rs-link">
            <a class="main-btn-2" href="blog/<?php echo $slug; ?>">Continue Reading <i class="ri-arrow-right-fill"></i></a>
        </div>
    </div>
</div>
<?php 
    }
} else {
    if (empty($error_msg)) {
        echo "<p>No posts found.</p>";
    }
}
?>