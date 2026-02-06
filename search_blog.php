<?php
require_once 'admin/config.php';

if (isset($_GET['q'])) {
    $q = trim($_GET['q']);
    if (strlen($q) > 0) {
        // Search title and content
        $stmt = $pdo->prepare("SELECT title, slug, created_at, thumbnail FROM blog_posts WHERE status = 'published' AND (title LIKE ? OR content LIKE ?) LIMIT 5");
        $term = "%$q%";
        $stmt->execute([$term, $term]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($results) > 0) {
            echo '<ul style="list-style: none; padding: 0; margin: 0;">';
            foreach ($results as $row) {
                $img = !empty($row['thumbnail']) ? "assets/images/blog/" . $row['thumbnail'] : "assets/images/no-image.jpg";
                echo '<li style="border-bottom: 1px solid #eee; padding: 10px 0; display: flex; align-items: center;">';
                echo '<a href="blog/' . $row['slug'] . '" style="display: flex; align-items: center; width: 100%;">';
                echo '<img src="' . $img . '" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px; border-radius: 4px;">';
                echo '<div>';
                echo '<span style="display: block; font-weight: 600; font-size: 14px; color: #333; line-height: 1.2;">' . htmlspecialchars($row['title']) . '</span>';
                echo '<small style="color: #999; font-size: 12px;">' . date('M d, Y', strtotime($row['created_at'])) . '</small>';
                echo '</div>';
                echo '</a>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<div style="text-align: center; padding: 15px; color: #666;">';
            echo '<p style="font-size: 18px; margin-bottom: 5px;">😕</p>';
            echo '<p style="margin: 0; font-size: 14px;">No results found</p>';
            echo '</div>';
        }
    }
}
?>
