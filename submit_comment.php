<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_slug = isset($_POST['post_slug']) ? trim($_POST['post_slug']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

    if (empty($post_slug) || empty($name) || empty($email) || empty($comment)) {
        header("Location: blog.php?error=All fields are required");
        exit();
    }

    try {
        // Get Post ID from Slug
        $stmt = $pdo->prepare("SELECT id FROM blog_posts WHERE slug = ?");
        $stmt->execute([$post_slug]);
        $post = $stmt->fetch();

        if ($post) {
            $post_id = $post['id'];
            
            // Insert Comment
            $stmt = $pdo->prepare("INSERT INTO blog_comments (post_id, name, email, comment, status) VALUES (?, ?, ?, ?, 'pending')");
            if ($stmt->execute([$post_id, $name, $email, $comment])) {
                header("Location: blog-single.php?slug=" . urlencode($post_slug) . "&msg=Comment submitted successfully! Waiting for approval.");
            } else {
                header("Location: blog-single.php?slug=" . urlencode($post_slug) . "&error=Failed to submit comment");
            }
        } else {
            header("Location: blog.php?error=Invalid post");
        }
    } catch (PDOException $e) {
        header("Location: blog-single.php?slug=" . urlencode($post_slug) . "&error=Database error: " . $e->getMessage());
    }
} else {
    header("Location: blog.php");
    exit();
}
?>