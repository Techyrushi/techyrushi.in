<?php
require_once 'config.php';

try {
    // Services
    $pdo->exec("CREATE TABLE IF NOT EXISTS services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255),
        slug VARCHAR(255),
        short_description TEXT,
        content TEXT,
        image VARCHAR(255),
        icon VARCHAR(50),
        display_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $services = [
        ['Web Development', 'web-development', 'Professional web development services.', 'Full content here.', 'service1.jpg', 'flaticon-web', 1],
        ['App Development', 'app-development', 'Mobile app development for iOS and Android.', 'Full content here.', 'service2.jpg', 'flaticon-smartphone', 2],
        ['Digital Marketing', 'digital-marketing', 'SEO, SEM, and social media marketing.', 'Full content here.', 'service3.jpg', 'flaticon-bullhorn', 3]
    ];

    foreach ($services as $s) {
        $stmt = $pdo->prepare("INSERT INTO services (title, slug, short_description, content, image, icon, display_order) SELECT ?, ?, ?, ?, ?, ?, ? WHERE NOT EXISTS (SELECT 1 FROM services WHERE slug = ?)");
        $stmt->execute([$s[0], $s[1], $s[2], $s[3], $s[4], $s[5], $s[6], $s[1]]);
    }

    // Projects
    $pdo->exec("CREATE TABLE IF NOT EXISTS projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255),
        slug VARCHAR(255),
        industry VARCHAR(255),
        description TEXT,
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $projects = [
        ['E-commerce Platform', 'ecommerce-platform', 'Retail', 'A full-featured e-commerce site.', 'project1.jpg'],
        ['Hospital Management System', 'hospital-management', 'Healthcare', 'Comprehensive hospital management.', 'project2.jpg'],
        ['Portfolio Website', 'portfolio-website', 'Creative', 'Personal portfolio for a designer.', 'project3.jpg']
    ];

    foreach ($projects as $p) {
        $stmt = $pdo->prepare("INSERT INTO projects (title, slug, industry, description, image) SELECT ?, ?, ?, ?, ? WHERE NOT EXISTS (SELECT 1 FROM projects WHERE slug = ?)");
        $stmt->execute([$p[0], $p[1], $p[2], $p[3], $p[4], $p[1]]);
    }

    // Blog Categories
    $pdo->exec("CREATE TABLE IF NOT EXISTS blog_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        slug VARCHAR(255)
    )");

    $categories = [['Technology', 'technology'], ['Business', 'business'], ['Design', 'design']];
    foreach ($categories as $c) {
        $stmt = $pdo->prepare("INSERT INTO blog_categories (name, slug) SELECT ?, ? WHERE NOT EXISTS (SELECT 1 FROM blog_categories WHERE slug = ?)");
        $stmt->execute([$c[0], $c[1], $c[1]]);
    }

    // Blog Posts
    $pdo->exec("CREATE TABLE IF NOT EXISTS blog_posts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255),
        slug VARCHAR(255),
        category_id INT,
        author VARCHAR(255),
        status VARCHAR(50),
        content TEXT,
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Get category ID
    $stmt = $pdo->query("SELECT id FROM blog_categories LIMIT 1");
    $cat_id = $stmt->fetchColumn() ?: 1;

    $posts = [
        ['The Future of AI', 'the-future-of-ai', $cat_id, 'Admin', 'published', 'Content about AI.', 'blog1.jpg'],
        ['10 Tips for Web Design', '10-tips-web-design', $cat_id, 'Admin', 'published', 'Content about design.', 'blog2.jpg']
    ];

    foreach ($posts as $p) {
        $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, category_id, author, status, content, image) SELECT ?, ?, ?, ?, ?, ?, ? WHERE NOT EXISTS (SELECT 1 FROM blog_posts WHERE slug = ?)");
        $stmt->execute([$p[0], $p[1], $p[2], $p[3], $p[4], $p[5], $p[6], $p[1]]);
    }

    // Testimonials
    $pdo->exec("CREATE TABLE IF NOT EXISTS testimonials (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        designation VARCHAR(255),
        content TEXT,
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $testimonials = [
        ['John Doe', 'CEO, Company A', 'Great service!', 'testimonial1.jpg'],
        ['Jane Smith', 'CTO, Company B', 'Highly recommended.', 'testimonial2.jpg']
    ];

    foreach ($testimonials as $t) {
        $stmt = $pdo->prepare("INSERT INTO testimonials (name, designation, content, image) SELECT ?, ?, ?, ? WHERE NOT EXISTS (SELECT 1 FROM testimonials WHERE name = ?)");
        $stmt->execute([$t[0], $t[1], $t[2], $t[3], $t[0]]);
    }

    echo "Mock content added successfully.";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
